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
import { createQuickGoalsModal, showModal, hideModal, initModalListeners } from './modal.js';
import { createGoalToggleManager } from './goals.js';
import { createHabitForm, createHabitFormWithGoalToggle, createHabitEditForm } from './habit.js';
import { createChallengeForm } from './challenge.js';
import { toggleHabit, completeWithNotes } from './habitToggle.js';
import { showToast, showError, showSuccess, showInfo, showWarning, getCsrfToken, createHeaders, post } from '../utils/ui.js';
import { createEmojiPicker } from './emojiPicker.js';

// Register components globally for Alpine.js to access
window.themeManager = createThemeManager;
window.activityCard = createActivityCard;
window.quickGoalsModal = createQuickGoalsModal;
window.goalToggleManager = createGoalToggleManager;
window.habitForm = createHabitForm;
window.habitFormWithGoalToggle = createHabitFormWithGoalToggle;
window.habitEditForm = createHabitEditForm;
window.challengeForm = createChallengeForm;
window.emojiPicker = createEmojiPicker;

// Register modal utility functions globally
window.showModal = showModal;
window.hideModal = hideModal;
window.initModalListeners = initModalListeners;

// Register habit toggle functions globally
window.toggleHabit = toggleHabit;
window.completeWithNotes = completeWithNotes;

// Register UI utility functions globally
window.showToast = showToast;
window.showError = showError;
window.showSuccess = showSuccess;
window.showInfo = showInfo;
window.showWarning = showWarning;
window.getCsrfToken = getCsrfToken;
window.createHeaders = createHeaders;
window.post = post;
