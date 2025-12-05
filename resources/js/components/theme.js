/**
 * Theme Management Component
 * 
 * Follows Single Responsibility Principle (SRP)
 * Responsibility: Managing application theme (light/dark mode) and user preferences
 * 
 * @module components/theme
 */

import { createHeaders } from '../utils/ui.js';

export function createThemeManager() {
    return {
        // Get initial theme from server-side rendered value
        theme: document.documentElement.dataset.theme || 'light',
        
        init() {
            // Apply initial theme
            this.applyTheme();
        },
        
        async toggleTheme() {
            // Simple toggle between light and dark
            this.theme = this.theme === 'light' ? 'dark' : 'light';
            this.applyTheme();
            await this.saveThemePreference();
        },
        
        applyTheme() {
            if (this.theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        },
        
        async saveThemePreference() {
            try {
                const response = await fetch('/profile/theme', {
                    method: 'POST',
                    headers: createHeaders({ 'Accept': 'application/json' }),
                    body: JSON.stringify({ theme: this.theme })
                });
                
                if (!response.ok) {
                    console.error('Failed to save theme preference');
                }
            } catch (error) {
                console.error('Error saving theme preference:', error);
            }
        },
        
        isDark() {
            return this.theme === 'dark';
        },
        
        getThemeIcon() {
            return this.theme === 'dark' ? 'moon' : 'sun';
        }
    }
}
