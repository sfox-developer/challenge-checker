/**
 * Activity Card Component
 * 
 * Follows Single Responsibility Principle (SRP)
 * Responsibility: Managing activity card interactions (likes, modal)
 * 
 * @module components/activity
 */

export function createActivityCard(initialLiked, initialLikesCount, activityId, toggleLikeUrl) {
    return {
        showDeleteModal: false,
        showLikesModal: false,
        liked: initialLiked,
        likesCount: initialLikesCount,
        isLiking: false,
        likes: [],
        loadingLikes: false,

        async toggleLike() {
            if (this.isLiking) return;
            
            this.isLiking = true;
            
            try {
                const response = await fetch(toggleLikeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    this.liked = data.liked;
                    this.likesCount = data.likes_count;
                    
                    // Refresh likes list if modal is open
                    if (this.showLikesModal) {
                        await this.loadLikes();
                    }
                    
                    // Close modal if unliking and count reaches 0
                    if (!this.liked && this.likesCount === 0) {
                        this.showLikesModal = false;
                    }
                }
            } catch (error) {
                console.error('Error toggling like:', error);
            } finally {
                this.isLiking = false;
            }
        },

        async openLikesModal() {
            if (this.likesCount > 0) {
                this.showLikesModal = true;
                await this.loadLikes();
            }
        },

        async loadLikes() {
            if (this.loadingLikes) return;
            
            this.loadingLikes = true;
            this.likes = [];
            
            try {
                const response = await fetch(`/feed/${activityId}/likes`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    this.likes = data.likes;
                    // Update likes count with fresh data from server
                    this.likesCount = data.likes_count;
                }
            } catch (error) {
                console.error('Error loading likes:', error);
            } finally {
                this.loadingLikes = false;
            }
        },

        closeLikesModal() {
            this.showLikesModal = false;
        }
    }
}
