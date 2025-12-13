<x-public-layout>
    <div class="section">
        <div class="container max-w-xl">
            <!-- Header -->
            <div class="text-center mb-12 animate animate-hidden-fade-up" 
                 x-data="{}" 
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                <h1>
                    Create your account
                </h1>
                <p class="subtitle">
                    Start tracking your challenges today
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6 animate animate-hidden-fade-up animate-delay-100" 
                  x-data="{}" 
                  x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
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
