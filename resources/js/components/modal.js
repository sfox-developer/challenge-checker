/**
 * Modal Components
 * 
 * Follows Single Responsibility Principle (SRP)
 * Responsibility: Managing modal dialogs and their content
 * 
 * @module components/modal
 */

/**
 * Quick Goals Modal
 * Displays active challenges for quick goal completion
 */
export function createQuickGoalsModal() {
    return {
        isOpen: false,
        content: '<div class="text-center py-8"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div><p class="mt-4 text-gray-600 dark:text-gray-400">Loading your active challenges...</p></div>',
        
        open() {
            this.isOpen = true;
            this.loadChallenges();
        },
        
        close() {
            this.isOpen = false;
        },
        
        async loadChallenges() {
            try {
                const response = await fetch('/api/quick-goals');
                const html = await response.text();
                this.content = html;
            } catch (error) {
                this.content = '<div class="text-center py-8 text-red-600 dark:text-red-400">Error loading challenges. Please try again.</div>';
            }
        }
    }
}
