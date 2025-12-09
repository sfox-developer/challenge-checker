<x-guest-layout>
    <!-- Header -->
    <div class="auth-header">
        <h1 class="auth-title">
            Create your account
        </h1>
        <p class="auth-subtitle">
            Start tracking your challenges today
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <!-- Name -->
        <div class="auth-field">
            <x-input-label for="name" :value="__('Name')" class="auth-label" />
            <x-text-input id="name" 
                          class="auth-input" 
                          type="text" 
                          name="name" 
                          :value="old('name')" 
                          required 
                          autofocus 
                          autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="auth-field">
            <x-input-label for="email" :value="__('Email')" class="auth-label" />
            <x-text-input id="email" 
                          class="auth-input" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="auth-field">
            <x-input-label for="password" :value="__('Password')" class="auth-label" />
            <x-text-input id="password" 
                          class="auth-input"
                          type="password"
                          name="password"
                          required 
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="auth-field">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="auth-label" />
            <x-text-input id="password_confirmation" 
                          class="auth-input"
                          type="password"
                          name="password_confirmation" 
                          required 
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="space-y-4 pt-2">
            <button type="submit" class="auth-submit">
                {{ __('Create account') }}
            </button>

            <p class="auth-footer">
                Already have an account? 
                <a href="{{ route('login') }}">
                    Sign in
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
