/**
 * Goal Calendar Component
 * Manages calendar state and day detail modal for goal completions across challenges and habits
 */
export function goalCalendar(calendarData) {
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
 * Goal Day Modal Component
 * Displays completion details for a specific day showing all sources (challenges/habits)
 */
export function goalDayModal(monthName, year, goalId) {
    return {
        dayData: null,
        monthName: monthName,
        year: year,
        goalId: goalId,

        init() {
            // Listen for day data updates
            this.$watch('dayData', (value) => {
                if (value) {
                    // Day data received
                }
            });
        },

        get hasCompletions() {
            return this.dayData && this.dayData.completed_count > 0;
        },

        get completionSources() {
            if (!this.dayData || !this.dayData.sources) return [];
            return this.dayData.sources;
        },

        getSourceIcon(type) {
            return type === 'challenge' ? '🎯' : '✅';
        },

        getSourceLabel(type, source) {
            const typeLabel = type === 'challenge' ? 'Challenge' : 'Habit';
            return source && source.name ? `${typeLabel}: ${source.name}` : typeLabel;
        },

        getSourceName(source) {
            return source.name || 'Unknown';
        }
    };
}
