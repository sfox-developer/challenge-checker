<x-public-layout>
    <div class="section">
        <div class="container max-w-xl">
            <!-- Header -->
            <div class="text-center mb-8 animate animate-hidden-fade-up" 
                 x-data="{}" 
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                <h1>
                    Create your account
                </h1>
                <p class="subtitle">
                    Start tracking your challenges today
                </p>
            </div>

            <!-- Trust Signals -->
            <div class="flex items-center justify-center gap-6 mb-8 text-sm text-help animate animate-hidden-fade-up animate-delay-100"
                 x-data="{}"
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 200)">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Secure & private
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    No spam, ever
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Completly free
                </span>
            </div>

            <!-- Social Authentication Buttons -->
            <div class="space-y-3 mb-8 animate animate-hidden-fade-up animate-delay-200"
                 x-data="{}"
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 300)">
                <!-- Google -->
                <a href="{{ route('social.redirect', 'google') }}"
                   class="btn btn-secondary btn-block flex items-center justify-center gap-3 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
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
                   class="btn btn-secondary btn-block flex items-center justify-center gap-3 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    <span>Continue with Facebook</span>
                </a>
            </div>

            <!-- Divider -->
        <div class="auth-separator">
            <div class="separator-line"></div>
            <div class="separator-text">
                <span class="texture-perlin">Or continue with email</span>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" 
            class="space-y-6 animate animate-hidden-fade-up animate-delay-300"
            x-data="{}" 
            x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 400)">

                @csrf

                <!-- Name -->
                <div class="form-group">
                    <x-forms.input-label for="name" :value="__('Name')" class="form-label" />
                    <x-forms.text-input id="name" 
                                class="form-input" 
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                required 
                                autofocus 
                                autocomplete="name" />
                    <x-forms.input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <x-forms.input-label for="email" :value="__('Email')" class="form-label" />
                    <x-forms.text-input id="email" 
                                class="form-input" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autocomplete="username" />
                    <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="form-group">
                    <x-forms.input-label for="password" :value="__('Password')" class="form-label" />
                    <x-forms.text-input id="password" 
                                class="form-input"
                                type="password"
                                name="password"
                                required 
                                autocomplete="new-password" />

                    <x-forms.password-strength inputId="password" />

                    <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <x-forms.input-label for="password_confirmation" :value="__('Confirm Password')" class="form-label" />
                    <x-forms.text-input id="password_confirmation" 
                                class="form-input"
                                type="password"
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password" />
                    <x-forms.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="space-y-4 pt-2">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('Create account') }}
                    </button>

                    <p class="text-center text-sm">
                        <span class="text-help">Already have an account?</span>
                        <a href="{{ route('login') }}" class="link font-medium">
                            Sign in
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>
