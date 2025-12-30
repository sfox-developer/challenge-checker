/**
 * Challenge Edit Form Component
 * Handles validation for challenge editing
 */
export default (initialName = '', initialDuration = '') => ({
    name: initialName,
    days_duration: initialDuration,
    
    /**
     * Validate required fields
     */
    isValid() {
        return this.name.trim().length > 0 && 
               this.days_duration && 
               this.days_duration >= 1 && 
               this.days_duration <= 365;
    }
});
