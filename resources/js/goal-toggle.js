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

        // Get challenge ID from parent container
        const challengeContainer = goalItem.closest('[data-challenge-id]');
        const challengeId = challengeContainer?.dataset.challengeId;
        
        if (!challengeId) {
            console.error('Challenge ID not found');
            return;
        }

        this.pendingRequests.add(goalId);
        
        // Get current state
        const isCurrentlyCompleted = goalItem.classList.contains('completed');
        
        try {
            // Instant UI update with optimistic feedback
            this.updateUIInstantly(goalItem, checkbox, !isCurrentlyCompleted);
            
            // Make API call
            const response = await fetch(`/challenges/${challengeId}/goals/${goalId}/toggle`, {
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
// Quick function for simple goal toggling in FAB
window.toggleGoalInstant = async function(goalId) {
    try {
        const goalCard = document.querySelector(`[data-goal-id="${goalId}"]`);
        if (!goalCard) return;
        
        const button = goalCard.querySelector('button[onclick*="toggleGoalInstant"]');
        const checkbox = button?.querySelector('div');
        if (!checkbox) return;
        
        // Get current state
        const isCompleted = checkbox.classList.contains('bg-teal-500');
        
        // Optimistic UI update
        if (isCompleted) {
            // Mark as incomplete
            checkbox.classList.remove('bg-teal-500', 'border-teal-500');
            checkbox.classList.add('border-gray-300', 'dark:border-gray-500');
            checkbox.innerHTML = '';
            goalCard.classList.remove('bg-teal-50', 'dark:bg-teal-900/20', 'border-teal-500');
            goalCard.classList.add('bg-white', 'dark:bg-gray-700', 'border-gray-200', 'dark:border-gray-600');
            
            // Update title
            const title = goalCard.querySelector('h5');
            if (title) {
                title.classList.remove('line-through', 'opacity-75');
            }
            
            // Remove done badge
            const doneBadge = goalCard.querySelector('.flex-shrink-0.text-xs');
            if (doneBadge && doneBadge.textContent.includes('Done')) {
                doneBadge.remove();
            }
        } else {
            // Mark as complete
            checkbox.classList.add('bg-teal-500', 'border-teal-500');
            checkbox.classList.remove('border-gray-300', 'dark:border-gray-500', 'hover:border-blue-500');
            checkbox.innerHTML = '<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
            goalCard.classList.add('bg-teal-50', 'dark:bg-teal-900/20', 'border-teal-500');
            goalCard.classList.remove('bg-white', 'dark:bg-gray-700', 'border-gray-200', 'dark:border-gray-600', 'hover:border-blue-300', 'dark:hover:border-blue-700');
            
            // Update title
            const title = goalCard.querySelector('h5');
            if (title) {
                title.classList.add('line-through', 'opacity-75');
            }
            
            // Update description styling
            const description = goalCard.querySelector('p.text-sm');
            if (description) {
                description.classList.add('line-through', 'opacity-75', 'text-gray-500', 'dark:text-gray-500');
                description.classList.remove('text-gray-600', 'dark:text-gray-400');
            }
            
            // Add done badge
            const content = goalCard.querySelector('.flex-1.min-w-0');
            if (content && !goalCard.querySelector('.flex-shrink-0.text-xs')) {
                const badge = document.createElement('span');
                badge.className = 'flex-shrink-0 text-xs font-semibold text-teal-600 dark:text-teal-400';
                badge.textContent = '✓ Done';
                content.parentElement.appendChild(badge);
            }
        }
        
        // Update progress (find by challenge container)
        const challengeContainer = goalCard.closest('[data-challenge-id]');
        if (challengeContainer) {
            updateChallengeProgress(challengeContainer, isCompleted ? -1 : 1);
        }
        
        // Get challenge ID for API call
        const challengeId = challengeContainer?.dataset.challengeId;
        if (!challengeId) {
            console.error('Challenge ID not found');
            return;
        }
        
        // Make API call
        const response = await fetch(`/challenges/${challengeId}/goals/${goalId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (!data.success) {
            // Revert on failure
            if (!isCompleted) {
                checkbox.classList.remove('bg-teal-500', 'border-teal-500');
                checkbox.classList.add('border-gray-300', 'dark:border-gray-500');
                checkbox.innerHTML = '';
                goalCard.classList.remove('bg-teal-50', 'dark:bg-teal-900/20', 'border-teal-500');
                goalCard.classList.add('bg-white', 'dark:bg-gray-700', 'border-gray-200', 'dark:border-gray-600');
                
                const title = goalCard.querySelector('h5');
                if (title) title.classList.remove('line-through', 'opacity-75');
                
                const description = goalCard.querySelector('p.text-sm');
                if (description) {
                    description.classList.remove('line-through', 'opacity-75', 'text-gray-500', 'dark:text-gray-500');
                    description.classList.add('text-gray-600', 'dark:text-gray-400');
                }
                
                if (challengeContainer) {
                    updateChallengeProgress(challengeContainer, -1);
                }
            } else {
                checkbox.classList.add('bg-teal-500', 'border-teal-500');
                checkbox.classList.remove('border-gray-300', 'dark:border-gray-500');
                checkbox.innerHTML = '<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
                goalCard.classList.add('bg-teal-50', 'dark:bg-teal-900/20', 'border-teal-500');
                goalCard.classList.remove('bg-white', 'dark:bg-gray-700', 'border-gray-200', 'dark:border-gray-600');
                
                const title = goalCard.querySelector('h5');
                if (title) title.classList.add('line-through', 'opacity-75');
                
                if (challengeContainer) {
                    updateChallengeProgress(challengeContainer, 1);
                }
            }
        }
    } catch (error) {
        console.error('Goal toggle error:', error);
    }
};

// Helper function to update challenge progress
function updateChallengeProgress(container, change) {
    const progressText = container.querySelector('[data-progress-text]');
    const progressBar = container.querySelector('[data-progress-bar]');
    const progressHeader = container.querySelector('.rounded-lg.p-4.border-2');
    
    if (!progressText) return;
    
    // Parse current progress
    const match = progressText.textContent.match(/(\d+)\/(\d+)/);
    if (!match) return;
    
    const completed = parseInt(match[1]) + change;
    const total = parseInt(match[2]);
    const percentage = Math.round((completed / total) * 100);
    const allCompleted = completed === total;
    
    // Update text
    progressText.textContent = `${completed}/${total} completed`;
    
    // Update progress bar
    if (progressBar) {
        progressBar.style.width = `${percentage}%`;
        
        // Change color when all completed
        if (allCompleted) {
            progressBar.className = 'bg-teal-500 h-1.5 rounded-full transition-all duration-300';
            progressText.classList.remove('text-blue-600', 'dark:text-blue-400');
            progressText.classList.add('text-teal-600', 'dark:text-teal-400');
            
            // Update header border and icon
            if (progressHeader) {
                progressHeader.classList.remove('border-blue-200', 'dark:border-blue-800', 'bg-blue-50', 'dark:bg-blue-900/20');
                progressHeader.classList.add('border-teal-500', 'bg-teal-50', 'dark:bg-teal-900/20');
                
                const icon = progressHeader.querySelector('svg');
                if (icon) {
                    icon.classList.remove('text-blue-500');
                    icon.classList.add('text-teal-500');
                }
                
                // Show celebration message
                let celebration = progressHeader.querySelector('.mt-2');
                if (!celebration) {
                    celebration = document.createElement('div');
                    celebration.className = 'mt-2 flex items-center gap-2 text-sm font-medium text-teal-600 dark:text-teal-400';
                    celebration.innerHTML = `
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Perfect! All goals completed! 🎉
                    `;
                    progressHeader.appendChild(celebration);
                }
            }
        } else {
            progressBar.className = 'bg-teal-500 h-1.5 rounded-full transition-all duration-300';
            progressText.classList.remove('text-teal-600', 'dark:text-teal-400');
            progressText.classList.add('text-blue-600', 'dark:text-blue-400');
            
            // Update header border and icon
            if (progressHeader) {
                progressHeader.classList.remove('border-teal-500', 'bg-teal-50', 'dark:bg-teal-900/20');
                progressHeader.classList.add('border-blue-200', 'dark:border-blue-800', 'bg-blue-50', 'dark:bg-blue-900/20');
                
                const icon = progressHeader.querySelector('svg');
                if (icon) {
                    icon.classList.remove('text-teal-500');
                    icon.classList.add('text-blue-500');
                }
                
                // Remove celebration message
                const celebration = progressHeader.querySelector('.mt-2');
                if (celebration) {
                    celebration.remove();
                }
            }
        }
    }
}

// Legacy support
window.toggleGoal = function(goalId) {
    toggleGoalInstant(goalId);
};

// Habit Toggle Function
window.toggleHabit = async function(habitId, date, buttonElement) {
    try {
        const habitCard = document.querySelector(`[data-habit-id="${habitId}"]`);
        if (!habitCard) return;
        
        const checkbox = buttonElement.querySelector('div');
        const progressContainer = habitCard.querySelector('[data-progress-container]');
        const progressBar = habitCard.querySelector('[data-progress-bar]');
        const progressText = habitCard.querySelector('[data-progress-text]');
        
        // Optimistic UI update
        const isCompleted = checkbox.classList.contains('bg-teal-500');
        
        if (isCompleted) {
            checkbox.classList.remove('bg-teal-500', 'border-teal-500');
            checkbox.classList.add('border-gray-300', 'dark:border-gray-500');
            checkbox.innerHTML = '';
            habitCard.classList.remove('bg-teal-50', 'dark:bg-teal-900/20', 'border-teal-500');
            habitCard.classList.add('bg-white', 'dark:bg-gray-700', 'border-gray-200', 'dark:border-gray-600');
        } else {
            checkbox.classList.add('bg-teal-500', 'border-teal-500');
            checkbox.classList.remove('border-gray-300', 'dark:border-gray-500');
            checkbox.innerHTML = '<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
            habitCard.classList.add('bg-teal-50', 'dark:bg-teal-900/20', 'border-teal-500');
            habitCard.classList.remove('bg-white', 'dark:bg-gray-700', 'border-gray-200', 'dark:border-gray-600');
        }
        
        // Make API call
        const response = await fetch(`/habits/${habitId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ date })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update progress bar and text if they exist
            if (progressBar && progressText && data.progress) {
                const progressPercentage = Math.min(100, (data.progress.current / data.progress.target) * 100);
                progressBar.style.width = `${progressPercentage}%`;
                progressText.textContent = `${data.progress.current}/${data.progress.target}`;
                
                // Add success color if target reached
                if (data.progress.current >= data.progress.target) {
                    progressText.classList.add('text-teal-600', 'dark:text-teal-400');
                } else {
                    progressText.classList.remove('text-teal-600', 'dark:text-teal-400');
                }
            }
        } else {
            // Revert on failure
            if (!isCompleted) {
                checkbox.classList.remove('bg-teal-500', 'border-teal-500');
                checkbox.classList.add('border-gray-300', 'dark:border-gray-500');
                checkbox.innerHTML = '';
                habitCard.classList.remove('bg-teal-50', 'dark:bg-teal-900/20', 'border-teal-500');
                habitCard.classList.add('bg-white', 'dark:bg-gray-700', 'border-gray-200', 'dark:border-gray-600');
            } else {
                checkbox.classList.add('bg-teal-500', 'border-teal-500');
                checkbox.classList.remove('border-gray-300', 'dark:border-gray-500');
                checkbox.innerHTML = '<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
                habitCard.classList.add('bg-teal-50', 'dark:bg-teal-900/20', 'border-teal-500');
                habitCard.classList.remove('bg-white', 'dark:bg-gray-700', 'border-gray-200', 'dark:border-gray-600');
            }
        }
    } catch (error) {
        console.error('Habit toggle error:', error);
    }
};
