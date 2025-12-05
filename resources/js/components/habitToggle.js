/**
 * Habit Toggle Component
 * 
 * Handles habit completion toggling and note-based completion.
 * Manages API calls and UI updates for habit tracking.
 * 
 * @module components/habitToggle
 */

import { showToast, showError, showSuccess, createHeaders } from '../utils/ui.js';

/**
 * Toggles a habit's completion status
 * 
 * @param {Event} event - The checkbox change event
 * @param {number} habitId - The ID of the habit to toggle
 * @param {string} date - The date to toggle for (YYYY-MM-DD format)
 */
export function toggleHabit(event, habitId, date) {
    const checkbox = event.target;
    const isChecked = checkbox.checked;

    fetch(`/habits/${habitId}/toggle`, {
        method: 'POST',
        headers: createHeaders(),
        body: JSON.stringify({ date })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI
            const habitCard = checkbox.closest('[x-data]');
            if (habitCard && window.Alpine) {
                window.Alpine.$data(habitCard).isCompleted = data.is_completed;
            }
            
            // Show toast
            if (data.is_completed) {
                showSuccess('✅ Habit completed!');
            }
            
            // Refresh page to update stats
            setTimeout(() => location.reload(), 500);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        checkbox.checked = !isChecked;
        showError('❌ Something went wrong');
    });
}

/**
 * Completes a habit with additional notes and metadata
 * 
 * @param {number} habitId - The ID of the habit to complete
 * @param {string} date - The date to complete for (YYYY-MM-DD format)
 */
export function completeWithNotes(habitId, date) {
    const habitCard = event.target.closest('[x-data]');
    const alpineData = window.Alpine.$data(habitCard);
    
    fetch(`/habits/${habitId}/complete`, {
        method: 'POST',
        headers: createHeaders(),
        body: JSON.stringify({
            date,
            notes: alpineData.notes || null,
            duration_minutes: alpineData.duration ? parseInt(alpineData.duration) : null,
            mood: alpineData.mood || null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('✅ Habit completed with notes!');
            alpineData.isCompleted = true;
            alpineData.showNotes = false;
            
            // Reset form
            alpineData.notes = '';
            alpineData.duration = '';
            alpineData.mood = '';
            
            // Refresh page to update stats
            setTimeout(() => location.reload(), 500);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('❌ Something went wrong');
    });
}
