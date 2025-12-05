/**
 * Habit Form Component
 * 
 * Alpine.js component for habit creation and editing forms.
 * Handles frequency type selection and period text transformation.
 * 
 * @module components/habit
 */

/**
 * Creates a habit form manager with frequency configuration
 * 
 * @param {string} initialFrequencyType - Initial frequency type ('daily', 'weekly', 'monthly', 'yearly')
 * @param {number} initialFrequencyCount - Initial frequency count (1-7)
 * @returns {Object} Alpine.js component data object
 */
export function createHabitForm(initialFrequencyType = 'daily', initialFrequencyCount = 1) {
    return {
        frequencyType: initialFrequencyType,
        frequencyCount: initialFrequencyCount,
        
        /**
         * Computed property that converts frequency type to period name
         * daily -> day, weekly -> week, monthly -> month, yearly -> year
         */
        get frequencyPeriod() {
            const periods = {
                'daily': 'day',
                'weekly': 'week',
                'monthly': 'month',
                'yearly': 'year'
            };
            return periods[this.frequencyType] || this.frequencyType;
        },
        
        /**
         * Initialize watcher to auto-set frequency_count to 1 for daily habits
         */
        init() {
            this.$watch('frequencyType', value => {
                if (value === 'daily') {
                    this.frequencyCount = 1;
                }
            });
        }
    };
}

/**
 * Creates a habit form manager for create view (no existing goal selection)
 * 
 * @param {boolean} hasGoalsInLibrary - Whether user has goals in their library
 * @returns {Object} Alpine.js component data object
 */
export function createHabitFormWithGoalToggle(hasGoalsInLibrary = false) {
    return {
        useExisting: hasGoalsInLibrary,
        selectedGoalId: '',
        ...createHabitForm()
    };
}

/**
 * Creates a habit form manager for edit view
 * 
 * @param {string} frequencyType - Current habit frequency type
 * @param {number} frequencyCount - Current habit frequency count
 * @returns {Object} Alpine.js component data object
 */
export function createHabitEditForm(frequencyType, frequencyCount) {
    return createHabitForm(frequencyType, frequencyCount);
}
