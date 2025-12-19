/**
 * Follow Component
 * 
 * Follows Single Responsibility Principle (SRP)
 * Responsibility: Managing user follow/unfollow interactions
 * 
 * Features:
 * - AJAX follow/unfollow without page refresh
 * - Optimistic UI updates for instant feedback
 * - Automatic error rollback on failure
 * - Loading states to prevent double-clicks
 * - Real-time follower count updates
 * - Toast notifications for success/error feedback
 * 
 * @module components/follow
 */

import { createHeaders, showToast } from '../utils/ui.js';

/**
 * Creates a follow component instance
 * 
 * @param {boolean} initialIsFollowing - Whether the current user is following the target user
 * @param {number} initialFollowersCount - Initial count of followers
 * @param {number} userId - Target user ID
 * @returns {Object} Alpine.js component with follow/unfollow functionality
 */
export function createFollowManager(initialIsFollowing, initialFollowersCount, userId) {
    return {
        isFollowing: initialIsFollowing,
        followersCount: initialFollowersCount,
        isLoading: false,

        /**
         * Toggle follow status with optimistic updates
         * 
         * Implementation follows optimistic update pattern:
         * 1. Capture current state for potential rollback
         * 2. Update UI immediately (optimistic)
         * 3. Send server request
         * 4. On success: keep optimistic state
         * 5. On error: rollback to previous state
         */
        async toggleFollow() {
            if (this.isLoading) return;
            
            this.isLoading = true;
            
            // Capture current state for potential rollback
            const previousIsFollowing = this.isFollowing;
            const previousFollowersCount = this.followersCount;
            
            // Optimistic update - change UI immediately
            this.isFollowing = !this.isFollowing;
            this.followersCount += this.isFollowing ? 1 : -1;
            
            try {
                const action = previousIsFollowing ? 'unfollow' : 'follow';
                const url = `/users/${userId}/${action}`;
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: createHeaders({ 'Accept': 'application/json' })
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                
                // Update with server response
                this.isFollowing = data.isFollowing;
                this.followersCount = data.followersCount;
                
                // Update global store and dispatch event for other components
                if (window.Alpine && window.Alpine.store('userDiscovery')) {
                    if (data.isFollowing) {
                        window.Alpine.store('userDiscovery').incrementFollowing();
                    } else {
                        window.Alpine.store('userDiscovery').decrementFollowing();
                    }
                }
                
                // Dispatch custom event for any other listeners
                window.dispatchEvent(new CustomEvent('user-follow-toggled', {
                    detail: { userId, isFollowing: data.isFollowing }
                }));
                
                // Show success notification
                showToast(data.message, 'success');
                
            } catch (error) {
                console.error('Error toggling follow:', error);
                
                // Rollback to previous state on error
                this.isFollowing = previousIsFollowing;
                this.followersCount = previousFollowersCount;
                
                // Show error notification
                showToast('An error occurred. Please try again.', 'error');
            } finally {
                this.isLoading = false;
            }
        }
    }
}
