/**
 * Emoji Picker Component
 * 
 * Provides a user-friendly emoji picker for text inputs.
 * Uses a popover with common emojis and falls back to native input.
 * 
 * Usage:
 * <div x-data="emojiPicker('inputId')">
 *   <input type="text" id="inputId" />
 *   <button type="button" @click="togglePicker()" x-text="buttonText"></button>
 * </div>
 */

export function createEmojiPicker(inputId) {
    return {
        inputId: inputId,
        showPicker: false,
        currentEmoji: '',
        
        // Common emojis organized by category (56 unique emojis)
        commonEmojis: [
            // Goals & targets
            '🎯', '🏆', '⭐', '✨', '🌟', '💫',
            // Health & fitness
            '❤️', '💪', '🏃', '🧘', '🍎', '🥗',
            // Learning & productivity
            '📚', '📖', '✏️', '📝', '⚡', '💼',
            // Habits & wellness
            '🧠', '💤', '🌱', '🌿', '☕', '💧',
            // Social & creativity
            '👥', '🤝', '🎨', '🎭', '🎵', '🎪',
            // Nature & positivity
            '🌈', '🌸', '🌺', '🔥', '💎', '🎁',
            // Activity & sports
            '⚽', '🏀', '🏋️', '🚴', '🏊', '⛰️',
            // Food & nutrition
            '🥑', '🥤', '🍵', '🌮', '🍇', '🍓',
        ],
        
        init() {
            // Initialize current emoji from input value
            const input = document.getElementById(this.inputId);
            if (input) {
                this.currentEmoji = input.value || '';
                // Listen for manual input changes
                input.addEventListener('input', (e) => {
                    this.currentEmoji = e.target.value;
                });
            }
            
            // Listen for clicks outside to close picker
            document.addEventListener('click', (e) => {
                if (this.showPicker && !this.$el.contains(e.target)) {
                    this.showPicker = false;
                }
            });
        },
        
        togglePicker() {
            this.showPicker = !this.showPicker;
        },
        
        selectEmoji(emoji) {
            const input = document.getElementById(this.inputId);
            if (input) {
                input.value = emoji;
                this.currentEmoji = emoji;
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.focus();
            }
            this.showPicker = false;
        },
        
        clearEmoji() {
            const input = document.getElementById(this.inputId);
            if (input) {
                input.value = '';
                this.currentEmoji = '';
                input.dispatchEvent(new Event('input', { bubbles: true }));
            }
            this.showPicker = false;
        },
        
        get buttonText() {
            return this.currentEmoji || '🎯';
        }
    };
}
