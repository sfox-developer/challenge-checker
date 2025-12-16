/**
 * Modal Components
 * 
 * Follows Single Responsibility Principle (SRP)
 * Responsibility: Managing modal dialogs and their content
 * 
 * @module components/modal
 */

/**
 * All modals now use Alpine.js with <x-ui.modal> component
 * No generic DOM manipulation utilities needed anymore
 */

/**
 * Alpine.js Modal Component Data
 * Focus management and accessibility for modals
 */
export function createModalData(name, show = false, focusable = false) {
    return {
        show: show,
        name: name,
        focusable: focusable,

        init() {
            this.$watch('show', value => {
                if (value) {
                    document.body.classList.add('overflow-y-hidden');
                    if (this.focusable) {
                        setTimeout(() => this.firstFocusable()?.focus(), 100);
                    }
                } else {
                    document.body.classList.remove('overflow-y-hidden');
                }
            });
        },

        focusables() {
            const selector = 'a, button, input:not([type="hidden"]), textarea, select, details, [tabindex]:not([tabindex="-1"])';
            return [...this.$el.querySelectorAll(selector)]
                .filter(el => !el.hasAttribute('disabled'));
        },

        firstFocusable() {
            return this.focusables()[0];
        },

        lastFocusable() {
            return this.focusables().slice(-1)[0];
        },

        nextFocusable() {
            const focusables = this.focusables();
            const currentIndex = focusables.indexOf(document.activeElement);
            const nextIndex = (currentIndex + 1) % (focusables.length + 1);
            return focusables[nextIndex] || this.firstFocusable();
        },

        prevFocusable() {
            const focusables = this.focusables();
            const currentIndex = focusables.indexOf(document.activeElement);
            const prevIndex = Math.max(0, currentIndex) - 1;
            return focusables[prevIndex] || this.lastFocusable();
        },

        handleTab(event) {
            if (event.shiftKey) {
                this.prevFocusable()?.focus();
            } else {
                this.nextFocusable()?.focus();
            }
        }
    };
}

/**
 * Quick Goals Modal
 * Displays active challenges and habits for quick completion
 */
export function createQuickGoalsModal() {
    return {
        isOpen: false,
        activeTab: 'challenges',
        challengesContent: '<div class="text-center py-8"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div><p class="mt-4 text-gray-600 dark:text-gray-400">Loading challenges...</p></div>',
        habitsContent: '',
        challengesLoaded: false,
        habitsLoaded: false,
        
        open() {
            this.isOpen = true;
            if (!this.challengesLoaded) {
                this.loadChallenges();
            }
        },
        
        close() {
            this.isOpen = false;
        },
        
        switchTab(tab) {
            this.activeTab = tab;
            if (tab === 'habits' && !this.habitsLoaded) {
                this.loadHabits();
            }
        },
        
        async loadChallenges() {
            try {
                const response = await fetch('/api/quick-goals');
                const html = await response.text();
                this.challengesContent = html;
                this.challengesLoaded = true;
            } catch (error) {
                this.challengesContent = '<div class="text-center py-8 text-red-600 dark:text-red-400">Error loading challenges. Please try again.</div>';
            }
        },
        
        async loadHabits() {
            this.habitsContent = '<div class="text-center py-8"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-teal-600 mx-auto"></div><p class="mt-4 text-gray-600 dark:text-gray-400">Loading habits...</p></div>';
            try {
                const response = await fetch('/api/quick-habits');
                const html = await response.text();
                this.habitsContent = html;
                this.habitsLoaded = true;
            } catch (error) {
                this.habitsContent = '<div class="text-center py-8 text-red-600 dark:text-red-400">Error loading habits. Please try again.</div>';
            }
        }
    }
}
