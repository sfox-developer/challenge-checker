/**
 * Goal Toggle Component
 * 
 * Follows Single Responsibility Principle (SRP)
 * Responsibility: Managing goal completion toggles with optimistic UI updates
 * 
 * @module components/goals
 */

export function createGoalToggleManager() {
    return {
        pendingRequests: new Set(),
        
        init() {
            this.initializeTooltips();
        },
        
        async toggleGoal(goalId) {
            if (this.pendingRequests.has(goalId)) {
                return; // Prevent double-clicks
            }

            const goalItem = document.querySelector(`[data-goal-id="${goalId}"]`);
            const checkbox = goalItem?.querySelector('.todo-checkbox');
            
            if (!goalItem || !checkbox) return;

            this.pendingRequests.add(goalId);
            
            // Get current state
            const isCurrentlyCompleted = goalItem.classList.contains('completed');
            
            try {
                // Instant UI update with optimistic feedback
                this.updateUIInstantly(goalItem, checkbox, !isCurrentlyCompleted);
                
                // Make API call
                const response = await fetch(`/goals/${goalId}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Update was successful - show success feedback
                    this.showSuccessFeedback(goalItem, data.completed);
                    
                    // Move item to appropriate section after animation
                    setTimeout(() => {
                        this.moveItemToCorrectSection(goalItem, data.completed);
                    }, 300);
                    
                    // Show celebration if all goals completed
                    if (data.all_goals_completed) {
                        this.showCompletionCelebration();
                    }
                    
                    // Update progress indicators
                    this.updateProgressIndicators();
                    
                } else {
                    // Revert optimistic update on failure
                    this.updateUIInstantly(goalItem, checkbox, isCurrentlyCompleted);
                    this.showErrorFeedback(goalItem);
                }
                
            } catch (error) {
                console.error('Goal toggle error:', error);
                // Revert optimistic update on error
                this.updateUIInstantly(goalItem, checkbox, isCurrentlyCompleted);
                this.showErrorFeedback(goalItem);
            } finally {
                this.pendingRequests.delete(goalId);
            }
        },

        updateUIInstantly(goalItem, checkbox, completed) {
            // Add loading state
            goalItem.classList.add('loading');
            
            setTimeout(() => {
                goalItem.classList.remove('loading');
                
                if (completed) {
                    // Mark as completed
                    goalItem.classList.add('completed', 'completing');
                    checkbox.checked = true;
                    
                    // Add checkmark animation
                    const checkmark = checkbox.nextElementSibling;
                    if (checkmark) {
                        checkmark.classList.add('animate-check');
                        setTimeout(() => checkmark.classList.remove('animate-check'), 600);
                    }
                } else {
                    // Mark as not completed
                    goalItem.classList.remove('completed', 'completing');
                    checkbox.checked = false;
                }
            }, 50);
        },

        moveItemToCorrectSection(goalItem, completed) {
            const currentSection = goalItem.closest('[data-section]');
            const targetSectionName = completed ? 'completed' : 'active';
            const targetSection = document.querySelector(`[data-section="${targetSectionName}"]`);
            
            if (!currentSection || !targetSection || currentSection === targetSection) {
                return;
            }

            // Add exit animation
            goalItem.style.opacity = '0';
            goalItem.style.transform = 'translateX(-10px)';
            
            setTimeout(() => {
                const container = targetSection.querySelector('.goals-container');
                if (container) {
                    // Determine insertion point
                    if (completed) {
                        // Add to top of completed section
                        container.prepend(goalItem);
                    } else {
                        // Add to bottom of active section
                        container.appendChild(goalItem);
                    }
                    
                    // Reset and trigger entrance animation
                    goalItem.style.opacity = '0';
                    goalItem.style.transform = 'translateX(10px)';
                    
                    setTimeout(() => {
                        goalItem.style.transition = 'all 0.3s ease';
                        goalItem.style.opacity = '1';
                        goalItem.style.transform = 'translateX(0)';
                    }, 50);
                }
                
                // Update empty states
                this.updateEmptyStates();
            }, 300);
        },

        showSuccessFeedback(goalItem, completed) {
            const feedback = document.createElement('div');
            feedback.className = 'success-feedback';
            feedback.innerHTML = completed ? '✓ Completed!' : '○ Reopened';
            feedback.style.cssText = `
                position: absolute;
                top: 50%;
                right: 20px;
                transform: translateY(-50%);
                background: ${completed ? '#10b981' : '#6b7280'};
                color: white;
                padding: 4px 12px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 600;
                opacity: 0;
                animation: feedbackSlide 1.5s ease;
                pointer-events: none;
            `;
            
            goalItem.style.position = 'relative';
            goalItem.appendChild(feedback);
            
            setTimeout(() => feedback.remove(), 1500);
        },

        showErrorFeedback(goalItem) {
            const feedback = document.createElement('div');
            feedback.className = 'error-feedback';
            feedback.innerHTML = '✕ Error';
            feedback.style.cssText = `
                position: absolute;
                top: 50%;
                right: 20px;
                transform: translateY(-50%);
                background: #ef4444;
                color: white;
                padding: 4px 12px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 600;
                opacity: 0;
                animation: feedbackSlide 1.5s ease;
                pointer-events: none;
            `;
            
            goalItem.style.position = 'relative';
            goalItem.appendChild(feedback);
            
            setTimeout(() => feedback.remove(), 1500);
        },

        showCompletionCelebration() {
            // Implementation for celebration animation
            console.log('🎉 All goals completed!');
        },

        updateProgressIndicators() {
            // Update any progress bars or counters on the page
            const progressElements = document.querySelectorAll('[data-progress]');
            progressElements.forEach(el => {
                // Calculate and update progress
                const completed = document.querySelectorAll('.goal-item.completed').length;
                const total = document.querySelectorAll('.goal-item').length;
                const percentage = total > 0 ? (completed / total) * 100 : 0;
                
                el.style.width = `${percentage}%`;
                el.setAttribute('aria-valuenow', percentage);
            });
        },

        updateEmptyStates() {
            const sections = document.querySelectorAll('[data-section]');
            sections.forEach(section => {
                const container = section.querySelector('.goals-container');
                const emptyState = section.querySelector('.empty-state');
                const hasGoals = container && container.children.length > 0;
                
                if (emptyState) {
                    emptyState.style.display = hasGoals ? 'none' : 'block';
                }
            });
        },

        initializeTooltips() {
            // Initialize any tooltips if needed
        }
    }
}

// Add animation styles if not already in CSS
if (!document.querySelector('#goal-toggle-animations')) {
    const style = document.createElement('style');
    style.id = 'goal-toggle-animations';
    style.textContent = `
        @keyframes feedbackSlide {
            0% { opacity: 0; transform: translateY(-50%) translateX(10px); }
            20% { opacity: 1; transform: translateY(-50%) translateX(0); }
            80% { opacity: 1; transform: translateY(-50%) translateX(0); }
            100% { opacity: 0; transform: translateY(-50%) translateX(-10px); }
        }
        
        .animate-check {
            animation: checkPop 0.3s ease;
        }
        
        @keyframes checkPop {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
    `;
    document.head.appendChild(style);
}
