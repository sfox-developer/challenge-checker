import './bootstrap';

// Import component registry - follows Facade Pattern
// Components are organized by domain (theme, activity, modal, goals)
// following Single Responsibility Principle
import './components/index.js';

// Import goal toggle system (uses onclick handlers in Blade templates)
import './goal-toggle.js';

// Import toast notification system
import './toast.js';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
