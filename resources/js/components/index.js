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
import { createModalData, createQuickGoalsModal } from './modal.js';
import { createGoalToggleManager } from './goals.js';
import { createHabitForm, createHabitFormWithGoalToggle, createHabitEditForm } from './habit.js';
import { createChallengeForm } from './challenge.js';
import challengeCreateForm from './challenge-create.js';
import { toggleHabit, completeWithNotes } from './habitToggle.js';
import { showToast, showError, showSuccess, showInfo, showWarning, getCsrfToken, createHeaders, post } from '../utils/ui.js';
import { createEmojiPicker } from './emojiPicker.js';
import registrationForm from './registration-form.js';
import { createFollowManager } from './follow.js';
import { challengeCalendar, dailyGoalsModal } from './challenge-calendar.js';

/**
 * Registration Form Component
 * Multi-step registration with email, name, and password
 * Follows Single Responsibility Principle - handles only registration flow
 */

// Register components globally for Alpine.js to access
window.themeManager = createThemeManager;
window.activityCard = createActivityCard;
window.modalData = createModalData;
window.quickGoalsModal = createQuickGoalsModal;
window.goalToggleManager = createGoalToggleManager;
window.habitForm = createHabitForm;
window.habitFormWithGoalToggle = createHabitFormWithGoalToggle;
window.habitEditForm = createHabitEditForm;
window.challengeForm = createChallengeForm;
window.challengeCreateForm = challengeCreateForm;
window.challengeCalendar = challengeCalendar;
window.dailyGoalsModal = dailyGoalsModal;
window.emojiPicker = createEmojiPicker;
window.registrationForm = registrationForm;
window.followManager = createFollowManager;

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
