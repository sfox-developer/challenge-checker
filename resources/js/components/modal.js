/**
 * Modal Components
 * 
 * Follows Single Responsibility Principle (SRP)
 * Responsibility: Managing modal dialogs and their content
 * 
 * @module components/modal
 */

/**
 * Generic modal utility functions
 * Used for simple show/hide modals with overlay and escape key handling
 */

/**
 * Shows a modal by ID
 * @param {string} modalId - The ID of the modal element to show
 */
export function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}

/**
 * Hides a modal by ID
 * @param {string} modalId - The ID of the modal element to hide
 */
export function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}

/**
 * Initializes modal event listeners for overlay click and escape key
 * @param {string} modalId - The ID of the modal element
 * @param {Function} hideCallback - The function to call when hiding (optional)
 */
export function initModalListeners(modalId, hideCallback = null) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    const hideFunc = hideCallback || (() => hideModal(modalId));

    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            hideFunc();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            hideFunc();
        }
    });
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
