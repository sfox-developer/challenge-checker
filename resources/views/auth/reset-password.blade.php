<x-public-layout>
    <div class="section">
        <div class="container max-w-xl">
            <!-- Header -->
            <div class="text-center mb-12 animate animate-hidden-fade-up" 
                 x-data="{}" 
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                <h1>
                    Reset your password
                </h1>
                <p class="subtitle">
                    Enter your new password below
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6 animate animate-hidden-fade-up animate-delay-100" 
                  x-data="{}" 
                  x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-group">
            <x-forms.input-label for="email" value="Email" class="form-label" />
            <x-forms.text-input id="email" 
                          class="form-input" 
                          type="email" 
                          name="email" 
                          :value="old('email', $request->email)" 
                          required 
                          autofocus 
                          autocomplete="username" />
            <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <x-forms.input-label for="password" value="Password" class="form-label" />
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
            <x-forms.input-label for="password_confirmation" value="Confirm password" class="form-label" />
            <x-forms.text-input id="password_confirmation" 
                          class="form-input" 
                          type="password" 
                          name="password_confirmation" 
                          required 
                          autocomplete="new-password" />
            <x-forms.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="btn btn-primary btn-block">
                Reset password
            </button>
        </div>

        <!-- Sign in link -->
        <p class="registration-footer">
            <span class="text-help">Remember your password?</span>
            <a href="{{ route('login') }}" class="registration-footer-link">
                Sign in
            </a>
        </p>
            </form>
        </div>
    </div>
</x-public-layout>
