/**
 * User Discovery Store
 * 
 * Global Alpine.js store for managing user discovery and following state.
 * Provides reactive state that updates across all components when users
 * follow/unfollow others.
 * 
 * Architecture Pattern: Centralized State Management
 * Similar to Vuex/Pinia stores, this provides a single source of truth
 * for follower counts that can be accessed and updated from any component.
 * 
 * @module stores/userDiscovery
 */

/**
 * Creates the user discovery store
 * 
 * @param {Object} Alpine - Alpine.js instance
 */
export function registerUserDiscoveryStore(Alpine) {
    Alpine.store('userDiscovery', {
        // State
        followingCount: 0,
        
        /**
         * Initialize store with server-side data
         * Should be called once when the filter tabs component mounts
         * 
         * @param {number} followingCount - Initial following count from server
         */
        init(followingCount) {
            this.followingCount = followingCount;
        },
        
        /**
         * Increment following count
         * Called when a user successfully follows someone
         */
        incrementFollowing() {
            this.followingCount++;
        },
        
        /**
         * Decrement following count
         * Called when a user successfully unfollows someone
         */
        decrementFollowing() {
            this.followingCount--;
        }
    });
}
