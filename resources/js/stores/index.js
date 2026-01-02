/**
 * Alpine.js Store Registry
 * 
 * Centralized registration of all Alpine.js global stores.
 * Stores provide reactive state management across components,
 * similar to Vuex/Pinia in Vue or Redux in React.
 * 
 * Usage Pattern:
 * 1. Create store module in stores/ directory
 * 2. Export registerXxxStore(Alpine) function
 * 3. Import and call in this index.js
 * 4. Access in components via $store.storeName
 * 
 * Benefits:
 * - Single source of truth for shared state
 * - Reactive updates across all components
 * - No prop drilling or event bubbling needed
 * - Easier to test and maintain than scattered state
 * 
 * @module stores
 */

import { registerUserDiscoveryStore } from './userDiscovery.js';
import { registerQuickCompleteStore } from './quickComplete.js';

/**
 * Register all Alpine.js stores
 * Should be called before Alpine.start() in app.js
 * 
 * @param {Object} Alpine - Alpine.js instance
 */
export function registerStores(Alpine) {
    registerUserDiscoveryStore(Alpine);
    registerQuickCompleteStore(Alpine);
    
    // Add more stores here as needed:
    // registerChallengeStore(Alpine);
    // registerNotificationStore(Alpine);
}
