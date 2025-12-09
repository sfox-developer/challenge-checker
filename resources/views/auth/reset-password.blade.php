<x-guest-layout>
    <!-- Header -->
    <div class="auth-header">
        <h1 class="auth-title">
            Reset your password
        </h1>
        <p class="auth-subtitle">
            Enter your new password below
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="auth-field">
            <x-input-label for="email" :value="__('Email')" class="auth-label" />
            <x-text-input id="email" 
                          class="auth-input" 
                          type="email" 
                          name="email" 
                          :value="old('email', $request->email)" 
                          required 
                          autofocus 
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
        <div class="pt-2">
            <button type="submit" class="auth-submit">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
