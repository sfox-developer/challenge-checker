<x-public-layout>
    <div class="section">
        <div class="container max-w-xl">
            <!-- Header -->
            <div class="text-center mb-12 animate animate-hidden-fade-up" 
                 x-data="{}" 
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                <h1>
                    Forgot your password?
                </h1>
                <p class="subtitle max-w-lg mx-auto">
                    No problem. Just let us know your email address and we will email you a password reset link.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="registration-success-box mb-6 animate animate-hidden-fade-up animate-delay-100"
                     x-data="{}"
                     x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6 animate animate-hidden-fade-up animate-delay-100" 
                  x-data="{}" 
                  x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
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
                Email password reset link
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
