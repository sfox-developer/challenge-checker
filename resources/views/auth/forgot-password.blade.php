<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-12">
        <h1>
            Forgot your password?
        </h1>
        <p class="subtitle max-w-lg mx-auto">
            No problem. Just let us know your email address and we will email you a password reset link.
        </p>
    </div>

    <!-- Session Status -->
    <x-shared.auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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
                          autofocus />
            <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
