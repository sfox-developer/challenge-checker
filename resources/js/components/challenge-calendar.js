/**
 * Challenge Calendar Component
 * Manages calendar state and day detail modal
 */
export function challengeCalendar(calendarData) {
    return {
        selectedDay: null,
        calendar: calendarData,
        
        selectDay(index) {
            this.selectedDay = index;
        },
        
        getSelectedDayData() {
            if (this.selectedDay === null) return null;
            return this.calendar[this.selectedDay];
        },
        
        getSelectedDayTitle(monthName, year) {
            const dayData = this.getSelectedDayData();
            if (!dayData || !dayData.day) return 'Goal Details';
            return `${monthName} ${dayData.day}, ${year}`;
        }
    };
}

/**
 * Daily Goals Modal Component
 * Manages edit mode and goal completion state for a specific day
 */
export function dailyGoalsModal(monthName, year, challengeId, updateRoute) {
    return {
        dayData: null,
        editMode: false,
        editedGoals: {},
        monthName: monthName,
        year: year,
        challengeId: challengeId,
        updateRoute: updateRoute,

        init() {
            // Listen for day data updates
            this.$watch('dayData', (value) => {
                if (value) {
                    this.editMode = false;
                }
            });
        },

        /**
         * Initialize edit mode with current completion states
         */
        initEditMode() {
            this.editedGoals = {};
            if (this.dayData && this.dayData.goals) {
                this.dayData.goals.forEach((goalCompletion) => {
                    this.editedGoals[goalCompletion.goal.id] = goalCompletion.is_completed;
                });
            }
        },

        /**
         * Toggle goal completion state in edit mode
         */
        toggleGoal(goalId) {
            this.editedGoals[goalId] = !this.editedGoals[goalId];
        },

        /**
         * Save changes and submit to backend
         */
        saveChanges() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = this.updateRoute;
            
            const csrfToken = document.querySelector('meta[name=csrf-token]').content;
            form.innerHTML = `
                <input type='hidden' name='_token' value='${csrfToken}'>
                <input type='hidden' name='_method' value='PATCH'>
                <input type='hidden' name='date' value='${this.dayData.date}'>
            `;
            
            Object.keys(this.editedGoals).forEach(goalId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `goals[${goalId}]`;
                input.value = this.editedGoals[goalId] ? '1' : '0';
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
        }
    };
}
