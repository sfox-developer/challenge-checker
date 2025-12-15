<x-public-layout>
    <div class="section">
        <div class="container max-w-xl">
            <!-- Header -->
            <div class="text-center mb-8 animate animate-hidden-fade-up" 
                 x-data="{}" 
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                <h1>
                    Confirm your password
                </h1>
                <p class="subtitle">
                    This is a secure area. Please confirm your password before continuing.
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6 animate animate-hidden-fade-up animate-delay-100" 
                  x-data="{}" 
                  x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
        @csrf

        <!-- Password -->
        <div class="form-group">
            <x-forms.input-label for="password" value="Password" class="form-label" />
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
                Confirm
            </button>
        </div>
            </form>
        </div>
    </div>
</x-public-layout>
