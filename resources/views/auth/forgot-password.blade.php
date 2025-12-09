<x-guest-layout>
    <!-- Header -->
    <div class="auth-header">
        <h1 class="auth-title">
            Forgot your password?
        </h1>
        <p class="auth-subtitle">
            No problem. Just let us know your email address and we will email you a password reset link.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="auth-field">
            <x-input-label for="email" :value="__('Email')" class="auth-label" />
            <x-text-input id="email" 
                          class="auth-input" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="auth-submit">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
