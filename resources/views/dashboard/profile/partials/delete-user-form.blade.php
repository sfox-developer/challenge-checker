<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-ui.app-button
        variant="danger"
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-ui.app-button>

    <x-ui.modal 
        name="confirm-user-deletion" 
        :show="$errors->userDeletion->isNotEmpty()"
        eyebrow="Danger Zone"
        :title="__('Delete Account')"
        focusable
    >
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="space-y-4">
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <p class="text-sm font-medium text-red-800 dark:text-red-300">
                        {{ __('Are you sure you want to delete your account?') }}
                    </p>
                    <p class="mt-2 text-sm text-red-700 dark:text-red-400">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>
                </div>

                <div>
                    <x-forms.input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                    <x-forms.text-input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full"
                        placeholder="{{ __('Password') }}"
                    />
                    <x-forms.input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="modal-footer">
                <x-ui.app-button variant="secondary" type="button" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-ui.app-button>
                <x-ui.app-button variant="danger" type="submit">
                    {{ __('Delete Account') }}
                </x-ui.app-button>
            </div>
        </form>
    </x-ui.modal>
</section>
