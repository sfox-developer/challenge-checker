/**
 * Goal Completion Component
 * 
 * Alpine.js component for handling individual goal completion and undo operations.
 * Supports different source types (challenge, habit, standalone) with proper API integration.
 */
export function createGoalCompletion() {
    return {
        // Component state
        isLoading: false,
        isCompleted: false,
        // Store data from attributes
        goalId: null,
        date: null,

        // Initialize component
        init() {
            // Store data attributes in component properties
            this.goalId = this.$el.dataset.goalId;
            this.date = this.$el.dataset.date;
            this.isCompleted = this.$el.dataset.completed === '1';
        },

        /**
         * Toggle goal completion status
         */
        async toggleCompletion() {
            if (this.isLoading) return;

            try {
                this.isLoading = true;
                
                if (this.isCompleted) {
                    await this.undoCompletion();
                } else {
                    await this.completeGoal();
                }
                
                // Sync state across all tabs by updating matching DOM elements
                this.syncCompletionStateAcrossTabs();
                
            } catch (error) {
                this.handleError('Failed to update goal completion. Please try again.');
                console.error('Goal completion error:', error);
            } finally {
                this.isLoading = false;
            }
        },

        /**
         * Complete a goal
         */
        async completeGoal() {
            const response = await this.makeApiCall('POST');
            
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || 'Failed to complete goal');
            }
            
            this.isCompleted = true;
        },

        /**
         * Undo goal completion
         */
        async undoCompletion() {
            const response = await this.makeApiCall('DELETE');
            
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || 'Failed to undo goal completion');
            }
            
            this.isCompleted = false;
        },

        /**
         * Make API call for goal completion operations
         */
        async makeApiCall(method) {
            // Use component properties instead of reading from dataset
            if (!this.goalId || !this.date) {
                console.error('Missing goal data:', {
                    goalId: this.goalId,
                    date: this.date
                });
                throw new Error('Missing required goal or date information');
            }

            let url = `/api/goals/${this.goalId}/complete`;
            let body = {};

            switch (method) {
                case 'POST':
                    // Complete goal
                    body = {
                        date: this.date
                    };
                    break;
                    
                case 'DELETE':
                    // Undo completion - add date to URL
                    url += `/${this.date}`;
                    break;
                    
                default:
                    throw new Error('Unknown method: ' + method);
            }

            const requestOptions = {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                }
            };
            
            // Add body for POST and DELETE requests if there's data to send
            if (Object.keys(body).length > 0) {
                requestOptions.body = JSON.stringify(body);
            }
            
            return fetch(url, requestOptions);
        },

        /**
         * Sync completion state across all tabs
         * Finds all goal cards with matching goal+date and updates their state
         */
        syncCompletionStateAcrossTabs() {
            // Find all matching goal completion components across all tabs
            const selector = `[data-goal-id="${this.goalId}"][data-date="${this.date}"]`;
            const matchingElements = document.querySelectorAll(selector);
            
            // Update each matching element's Alpine component state
            matchingElements.forEach(el => {
                // Skip the current element (already updated)
                if (el === this.$el) return;
                
                // Access the Alpine component instance and update its state
                if (el._x_dataStack && el._x_dataStack[0]) {
                    const component = el._x_dataStack[0];
                    if (component.isCompleted !== undefined) {
                        component.isCompleted = this.isCompleted;
                    }
                }
                
                // Also update the data attribute for consistency
                el.dataset.completed = this.isCompleted ? '1' : '0';
            });
        },

        /**
         * Handle and display errors
         */
        handleError(message) {
            console.error('Goal completion error:', message);
            
            if (window.showError) {
                window.showError(message);
            } else {
                alert(message); // Fallback
            }
        },

        /**
         * Get CSRF token from meta tag
         */
        getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        }
    };
}

/**
 * Enhanced Quick Goals Modal Component
 * 
 * Extends the original modal with refresh capabilities and better state management.
 * Integrates with standard modal event system.
 */
export function createEnhancedQuickGoalsModal() {
    // Get the base modal functionality
    const baseModal = createQuickGoalsModal();

    return {
        ...baseModal,
        showCompleted: false,

        /**
         * Open the modal and load initial content
         */
        open() {
            // Load 'all' tab by default
            if (!this.allLoaded) {
                this.loadAll();
            }
        },

        /**
         * Refresh the current tab content and mark all tabs as stale
         * This ensures that when users switch tabs, they'll see updated data
         */
        async refreshContent() {
            // Mark all tabs as stale so they reload when switched to
            this.allLoaded = false;
            this.challengesLoaded = false;
            this.habitsLoaded = false;
            
            // Immediately reload the currently visible tab
            if (this.activeTab === 'all') {
                await this.loadAll();
            } else if (this.activeTab === 'challenges') {
                await this.loadChallenges();
            } else if (this.activeTab === 'habits') {
                await this.loadHabits();
            }
        }
    };
}