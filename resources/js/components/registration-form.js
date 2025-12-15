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
    emailChecking: false,
    emailExists: false,
    emailCheckError: '',

    /**
     * Validate email format
     */
    validateEmail() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        this.emailValid = emailRegex.test(this.email);
        
        // Reset existence check when email changes
        this.emailExists = false;
        this.emailCheckError = '';
        
        return this.emailValid;
    },

    /**
     * Check if email already exists in database
     */
    async checkEmailAvailability() {
        if (!this.emailValid) {
            return false;
        }

        this.emailChecking = true;
        this.emailExists = false;
        this.emailCheckError = '';

        try {
            const response = await fetch('/register/check-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ email: this.email }),
            });

            const data = await response.json();
            
            if (!data.available) {
                this.emailExists = true;
            }

            return data.available;
        } catch (error) {
            console.error('Error checking email:', error);
            this.emailCheckError = 'Unable to verify email. Please try again.';
            return false;
        } finally {
            this.emailChecking = false;
        }
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
    async goToStep2() {
        if (!this.validateEmail()) {
            return;
        }

        // Check if email already exists
        const available = await this.checkEmailAvailability();
        
        if (!available || this.emailExists) {
            return;
        }

        this.step = 2;
        this.$nextTick(() => {
            const nameInput = document.getElementById('name');
            if (nameInput) nameInput.focus();
        });
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
