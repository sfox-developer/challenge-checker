/**
 * Registration Form Component
 * Handles multi-step registration logic
 */
export default (initialData = {}) => ({
    step: initialData.hasErrors ? 3 : 1,
    email: initialData.email || '',
    name: initialData.name || '',
    emailValid: Boolean(initialData.email),
    nameValid: Boolean(initialData.name),
    passwordStrength: 0,

    /**
     * Validate email format
     */
    validateEmail() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        this.emailValid = emailRegex.test(this.email);
        return this.emailValid;
    },

    /**
     * Validate name (minimum 2 characters)
     */
    validateName() {
        this.nameValid = this.name.trim().length >= 2;
        return this.nameValid;
    },

    /**
     * Advance to step 2 (name)
     */
    goToStep2() {
        if (this.validateEmail()) {
            this.step = 2;
            this.$nextTick(() => {
                const nameInput = document.getElementById('name');
                if (nameInput) nameInput.focus();
            });
        }
    },

    /**
     * Advance to step 3 (password)
     */
    goToStep3() {
        if (this.validateName()) {
            this.step = 3;
            this.$nextTick(() => {
                const passwordInput = document.getElementById('password');
                if (passwordInput) passwordInput.focus();
            });
        }
    },

    /**
     * Handle Enter key in email field
     */
    handleEmailEnter(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            this.goToStep2();
        }
    },

    /**
     * Handle Enter key in name field
     */
    handleNameEnter(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            this.goToStep3();
        }
    }
});
