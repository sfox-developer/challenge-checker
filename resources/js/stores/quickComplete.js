/**
 * Quick Complete Store
 * 
 * Global Alpine.js store for managing quick complete modal state.
 * Provides reactive state for tab content, counts, and loading states
 * that can be accessed from any component.
 * 
 * Architecture Pattern: Centralized State Management
 * This provides a single source of truth for modal state that eliminates
 * scope conflicts between nested Alpine.js components.
 * 
 * @module stores/quickComplete
 */

/**
 * Creates the quick complete store
 * 
 * @param {Object} Alpine - Alpine.js instance
 */
export function registerQuickCompleteStore(Alpine) {
    Alpine.store('quickComplete', {
        // State
        activeTab: 'all',
        allContent: '<div class="text-center py-8"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-slate-600 mx-auto"></div><p class="mt-4 text-gray-600 dark:text-gray-400">Loading goals...</p></div>',
        challengesContent: '',
        habitsContent: '',
        allLoaded: false,
        challengesLoaded: false,
        habitsLoaded: false,
        allCount: 0,
        challengesCount: 0,
        habitsCount: 0,

        /**
         * Initialize modal on open
         * Loads all tab content in parallel to get counts immediately
         */
        open() {
            // Load all tabs to get accurate counts for badges
            // They load in parallel but only 'all' tab content will be visible initially
            if (!this.allLoaded) {
                this.loadAll();
            }
            if (!this.challengesLoaded) {
                this.loadChallenges();
            }
            if (!this.habitsLoaded) {
                this.loadHabits();
            }
        },

        /**
         * Switch to a different tab
         * Lazy loads content only on first view - state is synced via DOM updates
         * 
         * @param {string} tab - Tab name: 'all', 'challenges', or 'habits'
         */
        switchTab(tab) {
            this.activeTab = tab;
            // Lazy load - only fetch if not already loaded
            // State sync happens via direct DOM updates when goals are toggled
            if (tab === 'all' && !this.allLoaded) {
                this.loadAll();
            } else if (tab === 'challenges' && !this.challengesLoaded) {
                this.loadChallenges();
            } else if (tab === 'habits' && !this.habitsLoaded) {
                this.loadHabits();
            }
        },

        /**
         * Load all goals (challenges + habits)
         */
        async loadAll() {
            try {
                const response = await fetch('/api/quick-all');
                const html = await response.text();
                this.allContent = html;
                this.allLoaded = true;
                // Extract count from data attribute
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const countElement = tempDiv.querySelector('[data-goal-count]');
                this.allCount = countElement ? parseInt(countElement.dataset.goalCount) : 0;
                
                // Render content into the tab and initialize Alpine
                this._renderContent('allTab', html);
            } catch (error) {
                this.allContent = '<div class="text-center py-8 text-red-600 dark:text-red-400">Error loading goals. Please try again.</div>';
                console.error('Error loading all goals:', error);
                this._renderContent('allTab', this.allContent);
            }
        },

        /**
         * Load challenge goals only
         */
        async loadChallenges() {
            try {
                const response = await fetch('/api/quick-goals');
                const html = await response.text();
                this.challengesContent = html;
                this.challengesLoaded = true;
                // Extract count from data attribute
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const countElement = tempDiv.querySelector('[data-goal-count]');
                this.challengesCount = countElement ? parseInt(countElement.dataset.goalCount) : 0;
                
                // Render content into the tab and initialize Alpine
                this._renderContent('challengesTab', html);
            } catch (error) {
                this.challengesContent = '<div class="text-center py-8 text-red-600 dark:text-red-400">Error loading challenges. Please try again.</div>';
                console.error('Error loading challenges:', error);
                this._renderContent('challengesTab', this.challengesContent);
            }
        },

        /**
         * Load habit goals only
         */
        async loadHabits() {
            this.habitsContent = '<div class="text-center py-8"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-teal-600 mx-auto"></div><p class="mt-4 text-gray-600 dark:text-gray-400">Loading habits...</p></div>';
            this._renderContent('habitsTab', this.habitsContent);
            
            try {
                const response = await fetch('/api/quick-habits');
                const html = await response.text();
                this.habitsContent = html;
                this.habitsLoaded = true;
                // Extract count from data attribute
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const countElement = tempDiv.querySelector('[data-goal-count]');
                this.habitsCount = countElement ? parseInt(countElement.dataset.goalCount) : 0;
                
                // Render content into the tab and initialize Alpine
                this._renderContent('habitsTab', html);
            } catch (error) {
                this.habitsContent = '<div class="text-center py-8 text-red-600 dark:text-red-400">Error loading habits. Please try again.</div>';
                console.error('Error loading habits:', error);
                this._renderContent('habitsTab', this.habitsContent);
            }
        },

        /**
         * Render HTML content into a tab and initialize Alpine components
         * @param {string} refName - The x-ref name of the tab element
         * @param {string} html - The HTML content to render
         * @private
         */
        _renderContent(refName, html) {
            if (typeof Alpine === 'undefined') {
                console.error('Alpine is not defined');
                return;
            }

            // Use setTimeout to ensure we're accessing refs after they're available
            setTimeout(() => {
                // Find the modal component root
                const modalRoot = document.querySelector('[x-data*="modalData"]');
                if (!modalRoot || !modalRoot._x_dataStack) {
                    console.error('Modal root not found');
                    return;
                }

                // Access $refs from the Alpine component
                const alpineData = modalRoot._x_dataStack[0];
                if (!alpineData.$refs || !alpineData.$refs[refName]) {
                    console.error(`Ref ${refName} not found`);
                    return;
                }

                const tabElement = alpineData.$refs[refName];
                
                // Set the HTML content
                tabElement.innerHTML = html;
                
                // Initialize Alpine on the new content
                Alpine.initTree(tabElement);
            }, 50);
        },

        /**
         * Refresh content is no longer needed - state is synced via DOM updates
         * Kept for backwards compatibility but does nothing
         * @deprecated State sync now happens via syncCompletionStateAcrossTabs()
         */
        async refreshContent() {
            // No-op: completion state is now synced directly in the DOM
            // This method is kept to avoid breaking existing event listeners
        }
    });
}