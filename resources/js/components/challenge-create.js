/**
 * Simplified Challenge Create Form Component
 * Works with shared goal selector component
 */
export default () => ({
    step: 1,
    
    // Form data
    name: '',
    description: '',
    days_duration: '',
    is_public: true,
    
    // Frequency properties
    frequencyType: 'daily',
    frequencyCount: 1,
    
    // Validation
    nameValid: false,
    
    /**
     * Initialize component
     */
    init() {
        // Watch for changes in form fields to trigger validation
        this.$watch('name', () => this.validateName());
    },
    
    /**
     * Validate challenge name
     */
    validateName() {
        this.nameValid = this.name.trim().length > 0;
        return this.nameValid;
    },
    
    /**
     * Move to next step
     */
    nextStep() {
        if (this.step < 3) {
            this.step++;
        }
    },
    
    /**
     * Move to previous step
     */
    prevStep() {
        if (this.step > 1) {
            this.step--;
        }
    },
    
    /**
     * Check if we can proceed to next step
     */
    canProceed() {
        switch(this.step) {
            case 1:
                return this.nameValid;
            case 2:
                return this.days_duration && this.days_duration >= 1 && this.days_duration <= 365;
            case 3:
                // This will be handled by the shared goal selector
                return true;
            default:
                return false;
        }
    },
    
    /**
     * Computed property for frequency period
     */
    get frequencyPeriod() {
        const periods = {
            'daily': 'day',
            'weekly': 'week',
            'monthly': 'month',
            'yearly': 'year'
        };
        return periods[this.frequencyType] || this.frequencyType;
    }
});