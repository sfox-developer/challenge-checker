/**
 * Toast Notification System
 * 
 * Provides toast notifications for user feedback.
 * Automatically displays Laravel flash messages on page load.
 */

/**
 * Show a toast notification
 * @param {string} message - The message to display
 * @param {string} type - Type of toast (success, error, info, warning)
 * @param {number} duration - Duration in milliseconds (default: 3000)
 */
export function showToast(message, type = 'success', duration = 3000) {
    const toast = document.createElement('div');
    toast.className = `toast toast--${type}`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Trigger animation
    setTimeout(() => toast.classList.add('toast--show'), 10);
    
    // Auto dismiss
    setTimeout(() => {
        toast.classList.remove('toast--show');
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

/**
 * Initialize toast system - check for flash messages
 */
export function initToastSystem() {
    // Flash messages are injected via data attributes
    const flashData = document.getElementById('flash-messages');
    if (!flashData) return;
    
    const message = flashData.dataset.message;
    const type = flashData.dataset.type;
    
    if (message && type) {
        showToast(message, type);
    }
}

// Make showToast globally available
window.showToast = showToast;

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initToastSystem);
} else {
    initToastSystem();
}
