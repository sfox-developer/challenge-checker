/**
 * Shared Goal Selector Component
 * Handles goal selection/creation logic for both single and multiple selections
 */

export default (config = {}) => ({
    // Configuration
    allowMultiple: config.allowMultiple || false,
    maxSelections: config.maxSelections || (config.allowMultiple ? 999 : 1),
    
    // Goal selection state (permanent)
    selectedGoalIds: config.allowMultiple ? [] : null,
    selectedGoalSources: config.allowMultiple ? [] : null, // Track 'library' or 'new' for each
    newGoals: config.allowMultiple ? [] : [],
    newGoal: {
        name: '',
        icon: '🎯',
        category_id: '',
        description: ''
    },
    
    // Temporary modal selection state 
    tempSelectedGoalIds: config.allowMultiple ? [] : null,
    tempSelectedGoalSources: config.allowMultiple ? [] : null,
    
    // Modal state
    showGoalSelectModal: false,
    showGoalCreateModal: false,
    
    // Goals data
    goals: [], // Will be initialized from window.goalsLibraryData
    
    /**
     * Initialize component
     */
    init() {
        // Load goals from window if available
        if (window.goalsLibraryData) {
            this.goals = window.goalsLibraryData;
        }
        
        // Initialize state based on configuration
        if (!this.allowMultiple) {
            this.selectedGoalIds = null;
            this.selectedGoalSources = null;
            this.newGoals = [];
        }
    },
    
    /**
     * Check if we have any goals selected
     */
    hasGoals() {
        if (this.allowMultiple) {
            return this.selectedGoalIds.length > 0 || this.newGoals.length > 0;
        } else {
            return this.selectedGoalIds !== null;
        }
    },
    
    /**
     * Check if a goal is selected (for modal display)
     */
    isGoalSelected(goalId) {
        // When modal is open, check temporary state
        if (this.showGoalSelectModal) {
            if (this.allowMultiple) {
                return this.tempSelectedGoalIds.includes(goalId);
            } else {
                return this.tempSelectedGoalIds === goalId;
            }
        }
        
        // Otherwise check permanent state
        if (this.allowMultiple) {
            return this.selectedGoalIds.includes(goalId);
        } else {
            return this.selectedGoalIds === goalId;
        }
    },
    
    /**
     * Get count of selected goals (for modal display)
     */
    getSelectedCount() {
        // When modal is open, count temporary selections
        if (this.showGoalSelectModal) {
            if (this.allowMultiple) {
                return this.tempSelectedGoalIds.length;
            } else {
                return this.tempSelectedGoalIds !== null ? 1 : 0;
            }
        }
        
        // Otherwise count permanent selections
        if (this.allowMultiple) {
            return this.selectedGoalIds.length + this.newGoals.length;
        } else {
            return this.hasGoals() ? 1 : 0;
        }
    },
    
    /**
     * Get count of permanent selected goals (for display outside modal)
     */
    getPermanentSelectedCount() {
        if (this.allowMultiple) {
            return this.selectedGoalIds.length + this.newGoals.length;
        } else {
            return this.hasGoals() ? 1 : 0;
        }
    },
    
    /**
     * Check if max selections reached
     */
    canSelectMore() {
        // When in modal, check temporary selections
        if (this.showGoalSelectModal || this.showGoalCreateModal) {
            return this.getSelectedCount() < this.maxSelections;
        }
        // Otherwise check permanent selections
        return this.getPermanentSelectedCount() < this.maxSelections;
    },
    
    /**
     * Open goal selection modal
     */
    openGoalSelectModal() {
        // Initialize temporary state with current selections
        if (this.allowMultiple) {
            this.tempSelectedGoalIds = [...this.selectedGoalIds];
            this.tempSelectedGoalSources = [...this.selectedGoalSources];
        } else {
            this.tempSelectedGoalIds = this.selectedGoalIds;
            this.tempSelectedGoalSources = this.selectedGoalSources;
        }
        
        this.showGoalSelectModal = true;
    },
    
    /**
     * Close goal selection modal and apply selections
     */
    closeGoalSelectModal() {
        // Apply temporary selections to permanent state
        if (this.allowMultiple) {
            this.selectedGoalIds = [...this.tempSelectedGoalIds];
            this.selectedGoalSources = [...this.tempSelectedGoalSources];
        } else {
            this.selectedGoalIds = this.tempSelectedGoalIds;
            this.selectedGoalSources = this.tempSelectedGoalSources;
        }
        this.showGoalSelectModal = false;
    },
    
    /**
     * Cancel goal selection modal without applying changes
     */
    cancelGoalSelectModal() {
        this.showGoalSelectModal = false;
    },
    
    /**
     * Select/deselect a goal from the library (temporary when in modal)
     */
    toggleGoal(goal) {
        // Use temporary state when modal is open
        const targetIds = this.showGoalSelectModal ? 'tempSelectedGoalIds' : 'selectedGoalIds';
        const targetSources = this.showGoalSelectModal ? 'tempSelectedGoalSources' : 'selectedGoalSources';
        
        if (this.allowMultiple) {
            const index = this[targetIds].indexOf(goal.id);
            if (index > -1) {
                // Remove goal
                this[targetIds].splice(index, 1);
                this[targetSources].splice(index, 1);
            } else if (this.canSelectMore()) {
                // Add goal
                this[targetIds].push(goal.id);
                this[targetSources].push('library');
            }
        } else {
            // Single selection
            if (this[targetIds] === goal.id) {
                // Deselect
                this[targetIds] = null;
                this[targetSources] = null;
            } else {
                // Select
                this[targetIds] = goal.id;
                this[targetSources] = 'library';
            }
        }
    },
    
    /**
     * Select a goal and close modal (for single selection)
     */
    selectGoal(goal) {
        this.toggleGoal(goal);
        // For single selection, don't auto-close when in modal - wait for Done button
        if (!this.allowMultiple && !this.showGoalSelectModal) {
            // Only auto-close if not in modal (legacy behavior)
        }
    },
    
    /**
     * Remove a selected goal
     */
    removeGoal(goalId, isNewGoal = false) {
        if (isNewGoal) {
            if (this.allowMultiple) {
                const index = this.newGoals.findIndex(g => g.tempId === goalId);
                if (index > -1) {
                    this.newGoals.splice(index, 1);
                }
            } else {
                this.newGoal = {
                    name: '',
                    icon: '🎯',
                    category_id: '',
                    description: ''
                };
            }
        } else {
            if (this.allowMultiple) {
                const index = this.selectedGoalIds.indexOf(goalId);
                if (index > -1) {
                    this.selectedGoalIds.splice(index, 1);
                    this.selectedGoalSources.splice(index, 1);
                }
            } else {
                this.selectedGoalIds = null;
                this.selectedGoalSources = null;
            }
        }
    },
    
    /**
     * Open goal creation modal
     */
    openGoalCreateModal() {
        this.showGoalCreateModal = true;
        // Reset form
        this.newGoal = {
            name: '',
            icon: '🎯',
            category_id: '',
            description: ''
        };
    },
    
    /**
     * Close goal creation modal
     */
    closeGoalCreateModal() {
        this.showGoalCreateModal = false;
    },
    
    /**
     * Save a new goal
     */
    async saveNewGoal() {
        if (!this.newGoal.name.trim()) {
            window.showError?.('Goal name is required');
            return;
        }
        
        if (!this.canSelectMore()) {
            window.showError?.(`Maximum ${this.maxSelections} goal${this.maxSelections > 1 ? 's' : ''} allowed`);
            return;
        }
        
        try {
            const response = await fetch(window.goalStoreRoute || '/goals', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: this.newGoal.name,
                    icon: this.newGoal.icon,
                    category_id: this.newGoal.category_id,
                    description: this.newGoal.description,
                    is_public: false
                })
            });
            
            if (!response.ok) {
                throw new Error('Failed to create goal');
            }
            
            const goal = await response.json();
            
            // Add goal to the global goals list for immediate use
            this.goals.push(goal);
            
            if (this.allowMultiple) {
                // For multiple selection, add to permanent state directly
                this.selectedGoalIds.push(goal.id);
                this.selectedGoalSources.push('library');
            } else {
                // For single selection, set permanent selection directly
                this.selectedGoalIds = goal.id;
                this.selectedGoalSources = 'library';
            }
            
            // Clear the newGoal form data since it's now saved and selected
            this.newGoal = {
                name: '',
                icon: '🎯',
                category_id: '',
                description: ''
            };
            
            // Close modal and show success
            this.closeGoalCreateModal();
            window.showSuccess?.('Goal created and selected!');
            
        } catch (error) {
            console.error('Error creating goal:', error);
            window.showError?.('Failed to create goal. Please try again.');
        }
    },
    
    /**
     * Get goal by ID
     */
    getGoalById(goalId) {
        return this.goals.find(g => g.id === goalId);
    },
    
    /**
     * Get goal name by ID
     */
    getGoalNameById(goalId) {
        const goal = this.getGoalById(goalId);
        return goal ? goal.name : '';
    },
    
    /**
     * Get goal icon by ID
     */
    getGoalIconById(goalId) {
        const goal = this.getGoalById(goalId);
        return goal ? goal.icon : '🎯';
    },
    
    /**
     * Get goal description by ID
     */
    getGoalDescriptionById(goalId) {
        const goal = this.getGoalById(goalId);
        return goal ? goal.description : '';
    },
    
    /**
     * Get all selected goals (library + new) for form submission
     */
    getSelectedGoals() {
        const result = {
            libraryGoals: [],
            newGoals: []
        };
        
        if (this.allowMultiple) {
            // Multiple selection
            result.libraryGoals = this.selectedGoalIds.map(id => this.getGoalById(id)).filter(Boolean);
            result.newGoals = this.newGoals;
        } else {
            // Single selection
            if (this.selectedGoalSources === 'library' && this.selectedGoalIds) {
                const goal = this.getGoalById(this.selectedGoalIds);
                if (goal) result.libraryGoals.push(goal);
            }
            // Don't include newGoal unless it's actually saved and selected
        }
        
        return result;
    }
});