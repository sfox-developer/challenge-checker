/**
 * Component Registry
 * 
 * Follows Facade Pattern and Dependency Injection principles
 * 
 * This module serves as the central registry for all Alpine.js components,
 * making them available globally while maintaining module separation.
 * Each component follows the Single Responsibility Principle (SRP),
 * with each module handling one specific domain concern.
 * 
 * Architecture Benefits:
 * - Separation of Concerns: Each component in its own file
 * - Single Responsibility: Each component has one clear purpose
 * - Testability: Components can be tested in isolation
 * - Maintainability: Easy to find and modify specific functionality
 * - Scalability: New components can be added without modifying existing ones
 * 
 * @module components
 */

import { createThemeManager } from './theme.js';
import { createActivityCard } from './activity.js';
import { createQuickGoalsModal } from './modal.js';
import { createGoalToggleManager } from './goals.js';

// Register components globally for Alpine.js to access
window.themeManager = createThemeManager;
window.activityCard = createActivityCard;
window.quickGoalsModal = createQuickGoalsModal;
window.goalToggleManager = createGoalToggleManager;
