<x-guest-layout>
    <!-- Header -->
    <div class="auth-header">
        <h1 class="auth-title">
            Confirm your password
        </h1>
        <p class="auth-subtitle">
            This is a secure area. Please confirm your password before continuing.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

        <!-- Password -->
        <div class="auth-field">
            <x-input-label for="password" :value="__('Password')" class="auth-label" />
            <x-text-input id="password" 
                          class="auth-input" 
                          type="password" 
                          name="password" 
                          required 
                          autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="auth-submit">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>
