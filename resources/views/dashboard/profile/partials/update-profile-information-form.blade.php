<section>
    <header>
        <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Avatar Selection -->
        <div x-data="{ 
            showModal: false, 
            selectedAvatar: '{{ old('avatar', $user->avatar) }}',
            getAvatarUrl(key) {
                return '/avatars/' + key + '.svg';
            }
        }">
            <x-forms.input-label for="avatar" :value="__('Avatar')" />
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 mb-3">
                {{ __("Click on your avatar to change it.") }}
            </p>
            
            <!-- Current Avatar Display -->
            <div class="flex items-center space-x-4">
                <button type="button" @click="showModal = true" class="group relative">
                    <img :src="getAvatarUrl(selectedAvatar)" alt="Current avatar" class="h-24 w-24 rounded-full ring-4 ring-gray-200 group-hover:ring-blue-400 transition-all duration-200 shadow-lg">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded-full flex items-center justify-center transition-all duration-200">
                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </div>
                </button>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Current Avatar</p>
                    <button type="button" @click="showModal = true" class="text-sm text-slate-700 hover:text-slate-900">
                        Change avatar
                    </button>
                </div>
            </div>

            <!-- Hidden input to store selected avatar -->
            <input type="hidden" name="avatar" :value="selectedAvatar">
            
            <!-- Avatar Selection Modal -->
            <div x-show="showModal" 
                 x-cloak
                 @keydown.escape.window="showModal = false"
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div class="fixed inset-0 transition-opacity" @click="showModal = false">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Modal panel -->
                    <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">Choose Your Avatar</h3>
                            <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600 dark:text-gray-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 max-h-96 overflow-y-auto p-2">
                            @foreach(\App\Domain\User\Models\User::getAvailableAvatars() as $key => $label)
                                <button type="button"
                                        @click="selectedAvatar = '{{ $key }}'; showModal = false"
                                        :class="selectedAvatar === '{{ $key }}' ? 'border-slate-700 ring-2 ring-slate-200' : 'border-gray-200 hover:border-slate-400'"
                                        class="rounded-lg border-2 transition-all duration-200 p-2 bg-white focus:outline-none">
                                    <img src="{{ asset('avatars/' . $key . '.svg') }}" alt="{{ $label }}" class="w-full aspect-square rounded">
                                </button>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 flex justify-end">
                            <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors duration-200">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <x-forms.input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-forms.input-label for="name" :value="__('Name')" />
            <x-forms.text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-forms.input-label for="email" :value="__('Email')" />
            <x-forms.text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-forms.input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-ui.app-button variant="primary" type="submit">{{ __('Save') }}</x-ui.app-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
