// Modern Todo Goal Toggle System
class GoalToggleManager {
    constructor() {
        this.pendingRequests = new Set();
        this.initializeTooltips();
    }

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
    }

    updateUIInstantly(goalItem, checkbox, completed) {
        // Add loading state
        goalItem.classList.add('loading');
        
        setTimeout(() => {
            goalItem.classList.remove('loading');
            
            if (completed) {
                // Mark as completed
                goalItem.classList.add('completed', 'completing');
                checkbox.classList.add('checked');
                
                // Add checkmark if not present
                if (!checkbox.querySelector('svg')) {
                    checkbox.innerHTML = `
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    `;
                }
                
                // Update status badge
                this.updateStatusBadge(goalItem, 'completed');
                
            } else {
                // Mark as incomplete
                goalItem.classList.remove('completed', 'completing');
                checkbox.classList.remove('checked');
                checkbox.innerHTML = ''; // Remove checkmark
                
                // Update status badge
                this.updateStatusBadge(goalItem, 'pending');
            }
            
            // Remove completing class after animation
            setTimeout(() => {
                goalItem.classList.remove('completing');
            }, 300);
            
        }, 100);
    }

    updateStatusBadge(goalItem, status) {
        const statusBadge = goalItem.querySelector('.status-badge');
        if (!statusBadge) return;
        
        // Remove existing status classes
        statusBadge.classList.remove('completed', 'pending', 'paused');
        
        // Add new status class and update text
        if (status === 'completed') {
            statusBadge.classList.add('completed');
            statusBadge.textContent = '✓ Done';
        } else if (status === 'pending') {
            statusBadge.classList.add('pending');
            statusBadge.textContent = 'Pending';
        }
    }

    moveItemToCorrectSection(goalItem, completed) {
        const container = goalItem.closest('.todo-container');
        if (!container) return;

        const pendingSection = container.querySelector('.pending-goals');
        const completedSection = container.querySelector('.completed-section');
        
        // Create completed section if it doesn't exist
        if (completed && !completedSection) {
            this.createCompletedSection(container);
        }
        
        // Animate out
        goalItem.style.transform = 'translateX(-20px)';
        goalItem.style.opacity = '0';
        
        setTimeout(() => {
            if (completed) {
                // Move to completed section
                const completedGoalsContainer = container.querySelector('.completed-section .completed-goals') || 
                                              container.querySelector('.completed-section');
                completedGoalsContainer.appendChild(goalItem);
            } else {
                // Move to pending section
                pendingSection.appendChild(goalItem);
            }
            
            // Animate in
            goalItem.style.transform = 'translateX(0)';
            goalItem.style.opacity = '1';
            
            // Update completed count
            this.updateCompletedCount(container);
            
        }, 200);
    }

    createCompletedSection(container) {
        const completedSection = document.createElement('div');
        completedSection.className = 'todo-section completed-section';
        completedSection.innerHTML = `
            <div class="section-header">
                <span>Completed</span>
                <span class="count">0</span>
            </div>
            <div class="completed-goals"></div>
        `;
        container.appendChild(completedSection);
    }

    updateCompletedCount(container) {
        const completedSection = container.querySelector('.completed-section');
        if (!completedSection) return;
        
        const completedItems = completedSection.querySelectorAll('.todo-item.completed');
        const countElement = completedSection.querySelector('.count');
        
        if (countElement) {
            countElement.textContent = completedItems.length;
        }
        
        // Hide section if no completed items
        if (completedItems.length === 0) {
            completedSection.style.display = 'none';
        } else {
            completedSection.style.display = 'block';
        }
    }

    showSuccessFeedback(goalItem, completed) {
        // Add success animation class
        goalItem.classList.add('success-feedback');
        
        // Create ripple effect
        this.createRippleEffect(goalItem);
        
        setTimeout(() => {
            goalItem.classList.remove('success-feedback');
        }, 600);
    }

    showErrorFeedback(goalItem) {
        goalItem.classList.add('error-feedback');
        
        // Shake animation
        goalItem.style.animation = 'shake 0.5s ease-in-out';
        
        setTimeout(() => {
            goalItem.classList.remove('error-feedback');
            goalItem.style.animation = '';
        }, 500);
    }

    createRippleEffect(element) {
        const ripple = document.createElement('div');
        ripple.className = 'ripple-effect';
        
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = (rect.width / 2 - size / 2) + 'px';
        ripple.style.top = (rect.height / 2 - size / 2) + 'px';
        
        element.style.position = 'relative';
        element.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    showCompletionCelebration() {
        // Create and show celebration toast
        const celebration = document.createElement('div');
        celebration.className = 'celebration-toast';
        celebration.innerHTML = `
            <div class="celebration-content">
                <div class="celebration-icon">🎉</div>
                <div class="celebration-text">
                    <div class="celebration-title">Amazing!</div>
                    <div class="celebration-message">All goals completed for today!</div>
                </div>
            </div>
        `;
        
        document.body.appendChild(celebration);
        
        // Animate in
        setTimeout(() => celebration.classList.add('show'), 100);
        
        // Auto remove
        setTimeout(() => {
            celebration.classList.add('hide');
            setTimeout(() => celebration.remove(), 300);
        }, 4000);
        
        // Add confetti effect
        this.triggerConfetti();
    }

    triggerConfetti() {
        // Simple confetti effect
        for (let i = 0; i < 50; i++) {
            setTimeout(() => {
                this.createConfettiPiece();
            }, i * 50);
        }
    }

    createConfettiPiece() {
        const confetti = document.createElement('div');
        confetti.className = 'confetti-piece';
        confetti.style.left = Math.random() * 100 + 'vw';
        confetti.style.backgroundColor = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#ffeaa7'][Math.floor(Math.random() * 5)];
        
        document.body.appendChild(confetti);
        
        setTimeout(() => confetti.remove(), 3000);
    }

    updateProgressIndicators() {
        // Update any progress bars or counters on the page
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            // Recalculate progress
            const container = bar.closest('.challenge-card') || bar.closest('.challenge-container');
            if (container) {
                this.recalculateProgress(container, bar);
            }
        });
    }

    recalculateProgress(container, progressBar) {
        const allGoals = container.querySelectorAll('.todo-item');
        const completedGoals = container.querySelectorAll('.todo-item.completed');
        
        const percentage = allGoals.length > 0 ? (completedGoals.length / allGoals.length) * 100 : 0;
        
        const progressFill = progressBar.querySelector('.progress-fill') || progressBar;
        progressFill.style.width = percentage + '%';
        
        // Update text if exists
        const progressText = container.querySelector('.progress-text');
        if (progressText) {
            progressText.textContent = `${completedGoals.length}/${allGoals.length} completed`;
        }
    }

    initializeTooltips() {
        // Add hover tooltips for better UX
        document.addEventListener('mouseover', (e) => {
            if (e.target.closest('.todo-checkbox') && !e.target.closest('.disabled')) {
                const tooltip = document.createElement('div');
                tooltip.className = 'goal-tooltip';
                tooltip.textContent = 'Click to toggle';
                
                const rect = e.target.getBoundingClientRect();
                tooltip.style.left = rect.left + rect.width / 2 + 'px';
                tooltip.style.top = rect.top - 30 + 'px';
                
                document.body.appendChild(tooltip);
                
                const removeTooltip = () => {
                    tooltip.remove();
                    e.target.removeEventListener('mouseout', removeTooltip);
                };
                
                e.target.addEventListener('mouseout', removeTooltip);
            }
        });
    }
}

// Initialize the goal toggle manager
const goalToggleManager = new GoalToggleManager();

// Global functions for onclick handlers (attached to window for global access)
window.toggleGoalInstant = function(goalId) {
    goalToggleManager.toggleGoal(goalId);
};

// Legacy support
window.toggleGoal = function(goalId) {
    goalToggleManager.toggleGoal(goalId);
};