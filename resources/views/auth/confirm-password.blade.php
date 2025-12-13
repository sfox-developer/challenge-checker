<x-public-layout>
    <div class="section">
        <div class="container max-w-xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="h2">
                    Confirm your password
                </h1>
                <p class="text-muted">
                    This is a secure area. Please confirm your password before continuing.
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

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

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
        </div>
    </div>
</x-public-layout>
