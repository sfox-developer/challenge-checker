import './bootstrap';

// Import component registry - follows Facade Pattern
// Components are organized by domain (theme, activity, modal, goals)
// following Single Responsibility Principle
import './components/index.js';

// Import goal toggle system (uses onclick handlers in Blade templates)
import './goal-toggle.js';

// Import toast notification system
import './toast.js';

// Import Lottie animation helper
import { initLottie } from './lottie.js';

// Import Alpine.js stores
import { registerStores } from './stores/index.js';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';

window.Alpine = Alpine;

Alpine.plugin(intersect);
Alpine.plugin(collapse);
initLottie(Alpine);

// Register global stores before starting Alpine
registerStores(Alpine);

Alpine.start();
