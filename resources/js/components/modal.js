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
