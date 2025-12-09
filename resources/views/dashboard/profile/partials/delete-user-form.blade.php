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

    <x-ui.modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="bg-red-600 dark:bg-red-500 px-6 py-4">
            <div class="modal-header-title">
                <h3 class="h3 text-white">{{ __('Delete Account') }}</h3>
                <button type="button" @click="$dispatch('close')" class="text-white hover:text-gray-200 text-2xl font-bold leading-none">&times;</button>
            </div>
        </div>
        
        <div class="px-6 py-4">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-forms.input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-forms.text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-forms.input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-ui.app-button variant="secondary" type="button" x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-ui.app-button>

                    <x-ui.app-button variant="danger" type="submit">
                        {{ __('Delete Account') }}
                    </x-ui.app-button>
                </div>
            </form>
        </div>

                <x-ui.app-button variant="danger" type="submit" class="ms-3">
                    {{ __('Delete Account') }}
                </x-ui.app-button>
            </div>
        </form>
    </x-ui.modal>
</section>
