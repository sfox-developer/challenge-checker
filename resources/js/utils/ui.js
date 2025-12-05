/**
 * UI Utilities
 * 
 * General-purpose UI utility functions for notifications, feedback, and common interactions.
 * These utilities are framework-agnostic and can be used throughout the application.
 * 
 * @module utils/ui
 */

/**
 * Shows a toast notification
 * 
 * @param {string} message - The message to display
 * @param {string} type - The type of toast ('success', 'error', 'info', 'warning')
 * @param {number} duration - Duration in milliseconds (default: 3000)
 */
export function showToast(message, type = 'success', duration = 3000) {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500',
        warning: 'bg-yellow-500'
    };

    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white ${
        colors[type] || colors.success
    } z-50 transition-opacity duration-300`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

/**
 * Shows an error toast notification
 * 
 * @param {string} message - The error message to display
 */
export function showError(message) {
    showToast(message, 'error');
}

/**
 * Shows a success toast notification
 * 
 * @param {string} message - The success message to display
 */
export function showSuccess(message) {
    showToast(message, 'success');
}

/**
 * Shows an info toast notification
 * 
 * @param {string} message - The info message to display
 */
export function showInfo(message) {
    showToast(message, 'info');
}

/**
 * Shows a warning toast notification
 * 
 * @param {string} message - The warning message to display
 */
export function showWarning(message) {
    showToast(message, 'warning');
}

/**
 * Gets the CSRF token from the meta tag
 * 
 * @returns {string} The CSRF token value
 * @throws {Error} If CSRF token is not found
 */
export function getCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!token) {
        throw new Error('CSRF token not found in page meta tags');
    }
    return token;
}

/**
 * Creates standard headers for fetch requests including CSRF token
 * 
 * @param {Object} additionalHeaders - Additional headers to merge
 * @returns {Object} Headers object with CSRF token
 */
export function createHeaders(additionalHeaders = {}) {
    return {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
        ...additionalHeaders
    };
}

/**
 * Makes a POST request with automatic CSRF token handling
 * 
 * @param {string} url - The URL to send the request to
 * @param {Object} data - The data to send in the request body
 * @param {Object} options - Additional fetch options
 * @returns {Promise<any>} The response data
 */
export async function post(url, data = {}, options = {}) {
    const response = await fetch(url, {
        method: 'POST',
        headers: createHeaders(options.headers),
        body: JSON.stringify(data),
        ...options
    });
    
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    return response.json();
}

/**
 * Debounces a function call
 * 
 * @param {Function} func - The function to debounce
 * @param {number} wait - The debounce delay in milliseconds
 * @returns {Function} The debounced function
 */
export function debounce(func, wait = 300) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Throttles a function call
 * 
 * @param {Function} func - The function to throttle
 * @param {number} limit - The throttle limit in milliseconds
 * @returns {Function} The throttled function
 */
export function throttle(func, limit = 300) {
    let inThrottle;
    return function executedFunction(...args) {
        if (!inThrottle) {
            func(...args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}
