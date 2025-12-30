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
