/**
 * Challenge Form Component
 * 
 * Alpine.js component for challenge creation form.
 * Handles dynamic goal addition and removal.
 * 
 * @module components/challenge
 */

/**
 * Creates a challenge form manager
 * 
 * @returns {Object} Alpine.js component data object
 */
export function createChallengeForm() {
    return {
        newGoals: [],
        
        /**
         * Adds a new empty goal to the form
         */
        addNewGoal() {
            this.newGoals.push({
                name: '',
                icon: '',
                category: '',
                description: ''
            });
        },
        
        /**
         * Removes a goal from the form by index
         * @param {number} index - Index of the goal to remove
         */
        removeNewGoal(index) {
            this.newGoals.splice(index, 1);
        }
    };
}
