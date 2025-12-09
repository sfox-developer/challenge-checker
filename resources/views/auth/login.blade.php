<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-12">
        <h1>
            Welcome back
        </h1>
        <p class="subtitle">
            Sign in to your account to continue
        </p>
    </div>

    <!-- Session Status -->
    <x-shared.auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <x-forms.input-label for="email" :value="__('Email')" class="form-label" />
            <x-forms.text-input id="email" 
                          class="form-input" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autofocus 
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
                          autocomplete="current-password" />
            <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between text-sm">
            <label for="remember_me" class="checkbox-label">
                <input id="remember_me" type="checkbox" name="remember" class="form-checkbox">
                <span>{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="link text-sm" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="space-y-4 pt-2">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Sign in') }}
            </button>

            <p class="text-center text-sm">
                <span class="text-help">Don't have an account?</span>
                <a href="{{ route('register') }}" class="link font-medium">
                    Sign up
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
