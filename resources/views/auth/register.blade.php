<x-public-layout>
    <div class="section">
        <div class="container max-w-xl" x-data="registrationForm({ 
                email: '{{ old('email') }}', 
                name: '{{ old('name') }}',
                hasErrors: {{ $errors->any() ? 'true' : 'false' }}
             })">
            
            <!-- Header - Only show on step 1 -->
            <div class="text-center mb-8" x-show="step === 1">
                <h1>Create your account</h1>
                <p class="subtitle">Start tracking your challenges today</p>
            </div>

            <!-- Trust Signals - Only show on step 1 -->
            <div class="registration-trust" x-show="step === 1">
                <span class="registration-trust-item">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Secure & private
                </span>
                <span class="registration-trust-item">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    No spam, ever
                </span>
                <span class="registration-trust-item">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Completely free
                </span>
            </div>

            <!-- Social Authentication Buttons - Only show on step 1 -->
            <div class="space-y-3 mb-8" x-show="step === 1">
                <!-- Google -->
                <a href="{{ route('social.redirect', 'google') }}"
                   class="btn btn-secondary btn-block">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span>Continue with Google</span>
                </a>

                <!-- Facebook -->
                <a href="{{ route('social.redirect', 'facebook') }}"
                   class="btn btn-secondary btn-block">
                    <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    <span>Continue with Facebook</span>
                </a>
            </div>

            <!-- Divider - Only show on step 1 -->
            <div class="auth-separator" x-show="step === 1">
                <div class="separator-line"></div>
                <div class="separator-text">
                    <span class="">Or continue with email</span>
                </div>
            </div>

            <!-- Progress Indicator - Show on steps 2 and 3 -->
            <div class="registration-progress" x-show="step > 1">
                <div class="registration-progress-group">
                    <div class="registration-progress-step" :class="step > 1 ? 'is-complete' : 'is-active'">
                        <svg x-show="step > 1" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span x-show="step === 1">1</span>
                    </div>
                </div>
                <div class="registration-progress-line" :class="step >= 2 ? 'is-active' : 'is-pending'"></div>
                <div class="registration-progress-group">
                    <div class="registration-progress-step" :class="step === 2 ? 'is-active' : (step > 2 ? 'is-complete' : 'is-pending')">
                        <svg x-show="step > 2" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span x-show="step === 2">2</span>
                    </div>
                </div>
                <div class="registration-progress-line" :class="step >= 3 ? 'is-active' : 'is-pending'"></div>
                <div class="registration-progress-group">
                    <div class="registration-progress-step" :class="step >= 3 ? 'is-active' : 'is-pending'">
                        3
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Hidden inputs for multi-step form -->
                <input type="hidden" name="email" x-model="email" />
                <input type="hidden" name="name" x-model="name" />

                <!-- Step 1: Email -->
                <div x-show="step === 1" class="space-y-6">
                    
                    <div class="form-group">
                        <x-forms.input-label for="email-step1" :value="__('Email address')" class="form-label" />
                        <input id="email-step1"
                               type="email"
                               class="form-input"
                               x-model="email"
                               @input="validateEmail()"
                               @keydown="handleEmailEnter"
                               placeholder="you@example.com"
                               autofocus
                               required />
                        
                        <!-- Format validation error -->
                        <div x-show="!emailValid && email.length > 0 && !emailChecking" class="registration-error">
                            Please enter a valid email address
                        </div>
                        
                        <!-- Email exists error with helpful actions -->
                        <div x-show="emailExists" class="registration-error-box">
                            <div class="registration-error-title">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>This email is already registered</span>
                            </div>
                            <div class="registration-error-actions">
                                <a href="{{ route('login') }}" class="registration-error-link">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Sign in instead
                                </a>
                                <a href="{{ route('password.request') }}" class="registration-error-link">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                    Reset password
                                </a>
                            </div>
                        </div>

                        <!-- Server error -->
                        <div x-show="emailCheckError" class="registration-error" x-text="emailCheckError"></div>
                    </div>

                    <button type="button"
                            @click="goToStep2"
                            :disabled="!emailValid || emailChecking"
                            class="btn btn-primary btn-block"
                            :class="(!emailValid || emailChecking) ? 'opacity-50 cursor-not-allowed' : ''">
                        <svg x-show="emailChecking" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-show="!emailChecking">Continue</span>
                        <span x-show="emailChecking">Checking...</span>
                        <svg x-show="!emailChecking" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>

                    <p class="registration-footer">
                        <span class="text-help">Already have an account?</span>
                        <a href="{{ route('login') }}" class="registration-footer-link">
                            Sign in
                        </a>
                    </p>
                </div>

                <!-- Step 2: Name -->
                <div x-show="step === 2" class="space-y-6">
                    <div class="registration-step-intro">
                        <p class="registration-step-title">Great! Now let's personalize your account</p>
                    </div>

                    <div class="form-group">
                        <x-forms.input-label for="name" :value="__('What should we call you?')" class="form-label" />
                        <input id="name"
                               type="text"
                               class="form-input"
                               x-model="name"
                               @input="validateName()"
                               @keydown="handleNameEnter"
                               placeholder="Your name"
                               autocomplete="name"
                               required />
                        <x-forms.input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="registration-buttons">
                        <button type="button"
                                @click="step = 1"
                                class="btn btn-secondary flex-[30]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Back</span>
                        </button>
                        <button type="button"
                                @click="goToStep3"
                                :disabled="!nameValid"
                                class="btn btn-primary flex-[70]"
                                :class="!nameValid ? 'opacity-50 cursor-not-allowed' : ''">
                            <span>Continue</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Password -->
                <div x-show="step === 3" class="space-y-6" @password-strength-change="passwordStrength = $event.detail">
                    <div class="registration-step-intro">
                        <p class="registration-step-title">
                            Almost there, <span class="font-medium text-gray-900 dark:text-white" x-text="name"></span>! 🎉
                        </p>
                        <p class="registration-step-subtitle">
                            Choose a secure password to protect your account
                        </p>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <x-forms.input-label for="password" :value="__('Create a password')" class="form-label" />
                        <x-forms.text-input id="password" 
                                    class="form-input"
                                    type="password"
                                    name="password"
                                    required 
                                    autocomplete="new-password"
                                    placeholder="At least 8 characters" />

                        <x-forms.password-strength inputId="password" />

                        <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <div class="registration-buttons">
                            <button type="button"
                                    @click="step = 2"
                                    class="btn btn-secondary flex-[30]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                <span>Back</span>
                            </button>
                            <button type="submit" 
                                    class="btn btn-primary flex-[70]"
                                    :disabled="passwordStrength < 3"
                                    :class="passwordStrength < 3 ? 'opacity-50 cursor-not-allowed' : ''">
                                <span>Create account</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</x-public-layout>
