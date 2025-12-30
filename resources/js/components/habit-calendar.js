/**
 * Habit Calendar Component
 * Manages calendar state and day detail modal for habit completions
 */
export function habitCalendar(calendarData) {
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
            if (!dayData || !dayData.day) return 'Completion Details';
            return `${monthName} ${dayData.day}, ${year}`;
        }
    };
}

/**
 * Habit Day Modal Component
 * Manages edit mode and completion state for a specific day
 */
export function habitDayModal(monthName, year, habitId, updateRoute) {
    return {
        dayData: null,
        editMode: false,
        editedCompletion: false,
        monthName: monthName,
        year: year,
        habitId: habitId,
        updateRoute: updateRoute,

        init() {
            // Listen for day data updates
            this.$watch('dayData', (value) => {
                if (value) {
                    this.editMode = false;
                    this.editedCompletion = value.is_completed || false;
                }
            });
        },

        /**
         * Initialize edit mode with current completion state
         */
        initEditMode() {
            this.editedCompletion = this.dayData?.is_completed || false;
        },

        /**
         * Toggle completion state in edit mode
         */
        toggleCompletion() {
            this.editedCompletion = !this.editedCompletion;
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
                <input type='hidden' name='is_completed' value='${this.editedCompletion ? '1' : '0'}'>
            `;
            
            document.body.appendChild(form);
            form.submit();
        }
    };
}
