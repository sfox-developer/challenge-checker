<x-public-layout>
    <div class="section">
        <div class="container max-w-xl">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1>
                    Reset your password
                </h1>
                <p class="subtitle">
                    Enter your new password below
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-group">
            <x-forms.input-label for="email" :value="__('Email')" class="form-label" />
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
        <div class="pt-2">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
        </div>
    </div>
</x-public-layout>
