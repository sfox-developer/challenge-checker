/**
 * Challenge Create Form Component
 * Handles multi-step challenge creation with goal selection modals
 */
export default () => ({
    step: 1,
    selectedGoalIds: [],
    newGoals: [],
    showGoalSelectModal: false,
    showGoalCreateModal: false,
    newGoal: {
        name: '',
        icon: '🎯',
        category_id: '',
        description: ''
    },
    goals: [], // Will be initialized from window.goalsLibraryData
    
    // Form data
    name: '',
    description: '',
    days_duration: '',
    is_public: true,
    
    // Frequency properties (for frequency-selector component)
    frequencyType: 'daily',
    frequencyCount: 1,
    
    // Computed property for frequency period
    get frequencyPeriod() {
        const periods = {
            'daily': 'day',
            'weekly': 'week',
            'monthly': 'month',
            'yearly': 'year'
        };
        return periods[this.frequencyType] || this.frequencyType;
    },
    
    // Validation
    nameValid: false,
    
    /**
     * Validate challenge name
     */
    validateName() {
        this.nameValid = this.name.trim().length > 0;
        return this.nameValid;
    },
    
    /**
     * Validate step 2 (duration required)
     */
    validateStep2() {
        return this.days_duration && this.days_duration >= 1 && this.days_duration <= 365;
    },
    
    /**
     * Go to next step
     */
    nextStep() {
        if (this.step === 1 && !this.validateName()) {
            return;
        }
        
        if (this.step === 2 && !this.validateStep2()) {
            return;
        }
        
        if (this.step < 3) {
            this.step++;
            this.scrollToTop();
        }
    },
    
    /**
     * Go to previous step
     */
    prevStep() {
        if (this.step > 1) {
            this.step--;
            this.scrollToTop();
        }
    },
    
    /**
     * Scroll to top of form
     */
    scrollToTop() {
        this.$nextTick(() => {
            const stepForm = document.querySelector('.step-form');
            if (stepForm) {
                const offset = 100; // Account for sticky nav + some padding
                const elementPosition = stepForm.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - offset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    },
    
    /**
     * Toggle goal selection
     */
    toggleGoal(goalId) {
        const index = this.selectedGoalIds.indexOf(goalId);
        if (index === -1) {
            this.selectedGoalIds.push(goalId);
        } else {
            this.selectedGoalIds.splice(index, 1);
        }
    },
    
    /**
     * Check if goal is selected
     */
    isGoalSelected(goalId) {
        return this.selectedGoalIds.includes(goalId);
    },
    
    /**
     * Open goal selection modal
     */
    openGoalSelectModal() {
        this.showGoalSelectModal = true;
        document.body.style.overflow = 'hidden';
    },
    
    /**
     * Close goal selection modal
     */
    closeGoalSelectModal() {
        this.showGoalSelectModal = false;
        document.body.style.overflow = '';
    },
    
    /**
     * Open goal creation modal
     */
    openGoalCreateModal() {
        this.resetNewGoal();
        this.showGoalCreateModal = true;
        document.body.style.overflow = 'hidden';
    },
    
    /**
     * Close goal creation modal
     */
    closeGoalCreateModal() {
        this.showGoalCreateModal = false;
        document.body.style.overflow = '';
    },
    
    /**
     * Reset new goal form
     */
    resetNewGoal() {
        this.newGoal = {
            name: '',
            icon: '🎯',
            category_id: '',
            description: ''
        };
    },
    
    /**
     * Add new goal to list
     */
    addNewGoalToList() {
        if (!this.newGoal.name.trim()) {
            return;
        }
        
        this.newGoals.push({
            ...this.newGoal,
            tempId: Date.now()
        });
        
        this.closeGoalCreateModal();
    },
    
    /**
     * Remove new goal from list
     */
    removeNewGoal(index) {
        this.newGoals.splice(index, 1);
    },
    
    /**
     * Get total goals count
     */
    getTotalGoalsCount() {
        return this.selectedGoalIds.length + this.newGoals.length;
    },
    
    /**
     * Handle Enter key navigation
     */
    handleEnter(event, currentStep) {
        if (event.key === 'Enter') {
            event.preventDefault();
            if (currentStep < 3) {
                this.nextStep();
            }
        }
    },
    
    /**
     * Get goal name by ID (for display in selected goals)
     */
    getGoalNameById(goalId) {
        const goal = this.goals.find(g => g.id === goalId);
        return goal ? goal.name : `Goal #${goalId}`;
    },
    
    /**
     * Get goal icon by ID
     */
    getGoalIconById(goalId) {
        const goal = this.goals.find(g => g.id === goalId);
        return goal && goal.icon ? goal.icon : '🎯';
    },
    
    /**
     * Get goal category by ID
     */
    getGoalCategoryById(goalId) {
        const goal = this.goals.find(g => g.id === goalId);
        return goal && goal.category ? goal.category.name : '';
    },
    
    /**
     * Initialize component
     */
    init() {
        // Load goals from window if available
        if (window.goalsLibraryData) {
            this.goals = window.goalsLibraryData;
        }
        
        // Watch frequency type and auto-set count to 1 for daily
        this.$watch('frequencyType', value => {
            if (value === 'daily') {
                this.frequencyCount = 1;
            }
        });
    }
});
