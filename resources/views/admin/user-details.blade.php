<x-dashboard-layout>
    <x-dashboard.page-header 
        eyebrow="Admin" 
        :title="$user->name" 
    />

    <div class="pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="flex space-x-2">
                <x-ui.app-button variant="secondary" href="{{ route('admin.dashboard') }}">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                    Back
                </x-ui.app-button>
                
                @if($user->is_admin)
                        <span class="px-4 py-2 rounded-lg text-sm font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Admin User
                        </span>
                    @else
                        <x-ui.app-button 
                            variant="secondary" 
                            type="button"
                            onclick="window.showDeleteUserModal('{{ $user->name }}', '{{ route('admin.user.delete', $user) }}')">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </x-slot>
                            Delete
                        </x-ui.app-button>
                    @endif
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- User Details Card -->
            <div class="card">
                <div class="flex items-start space-x-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 rounded-full bg-slate-700 dark:bg-slate-600 p-1">
                            <div class="w-full h-full rounded-full bg-white dark:bg-gray-800 flex items-center justify-center overflow-hidden">
                                <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="flex-1 min-w-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Email</label>
                                    <div class="mt-1 flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->email }}</span>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Account Status</label>
                                    <div class="mt-1 flex items-center space-x-2">
                                        @if($user->email_verified_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-400">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Verified
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-400">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                Unverified
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Theme Preference</label>
                                    <div class="mt-1 flex items-center space-x-2">
                                        @php
                                            $theme = $user->getThemePreference();
                                            $themeIcons = [
                                                'light' => '<path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>',
                                                'dark' => '<path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>',
                                                'system' => '<path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"></path>'
                                            ];
                                        @endphp
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            {!! $themeIcons[$theme] !!}
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100 capitalize">{{ $theme }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Member Since</label>
                                    <div class="mt-1 flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->created_at->format('F j, Y') }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">({{ $user->created_at->diffForHumans() }})</span>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Social Stats</label>
                                    <div class="mt-1 flex items-center space-x-4">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->followers_count }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">followers</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->following_count }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">following</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Activity</label>
                                    <div class="mt-1 flex items-center space-x-4">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->habits_count }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">habits</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->goals_library_count }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">goals</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->activities_count }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">posts</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <x-ui.stat-card 
                    label="Total Challenges" 
                    :value="$user->challenges->count()">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                        </svg>
                    </x-slot>
                </x-ui.stat-card>

                <x-ui.stat-card 
                    label="Active" 
                    :value="$user->challenges->where('started_at', '!=', null)->where('completed_at', null)->where('is_active', true)->count()">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-ui.stat-card>

                <x-ui.stat-card 
                    label="Completed" 
                    :value="$user->challenges->where('completed_at', '!=', null)->count()">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-ui.stat-card>

                <x-ui.stat-card 
                    label="Paused" 
                    :value="$user->challenges->where('started_at', '!=', null)->where('is_active', false)->where('completed_at', null)->count()">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-ui.stat-card>
            </div>

            <!-- User Content Tabs -->
            <x-social.user-content-tabs 
                :user="$user" 
                :challenges="$challenges"
                :habits="$habits"
                :activities="$activities"
                defaultTab="challenges"
                :adminView="true" />
        </div>
    </div>

    <!-- Delete User Confirmation Modal -->
    <div id="deleteUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="mt-4 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="deleteUserModalTitle">
                        Delete user account
                    </h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400" id="deleteUserModalMessage">
                            Are you sure you want to delete this user? This action cannot be undone.
                        </p>
                        <p class="text-sm text-red-600 dark:text-red-400 font-semibold mt-3">
                            All user data including challenges, habits, activities, and social connections will be permanently deleted.
                        </p>
                    </div>
                    <div class="flex justify-center space-x-4 px-4 py-3">
                        <button 
                            onclick="window.hideDeleteUserModal()"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors duration-200">
                            Cancel
                        </button>
                        <button 
                            id="confirmDeleteButton"
                            onclick="window.confirmDeleteUser()"
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors duration-200">
                            Delete User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteUserUrl = null;
        let deleteUserName = null;

        window.showDeleteUserModal = function(userName, url) {
            deleteUserUrl = url;
            deleteUserName = userName;
            document.getElementById('deleteUserModalMessage').innerHTML = 
                `Are you sure you want to delete <strong>${userName}</strong>? This action cannot be undone.`;
            document.getElementById('deleteUserModal').classList.remove('hidden');
        };

        window.hideDeleteUserModal = function() {
            document.getElementById('deleteUserModal').classList.add('hidden');
            deleteUserUrl = null;
            deleteUserName = null;
        };

        window.confirmDeleteUser = async function() {
            if (!deleteUserUrl) return;

            const button = document.getElementById('confirmDeleteButton');
            button.disabled = true;
            button.textContent = 'Deleting...';

            try {
                const response = await fetch(deleteUserUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    window.showSuccess(data.message);
                    // Redirect to admin dashboard after successful deletion
                    setTimeout(() => {
                        window.location.href = '{{ route('admin.dashboard') }}';
                    }, 1500);
                } else {
                    window.showError(data.message);
                    window.hideDeleteUserModal();
                    button.disabled = false;
                    button.textContent = 'Delete User';
                }
            } catch (error) {
                console.error('Delete error:', error);
                window.showError('An error occurred while deleting the user. Please try again.');
                window.hideDeleteUserModal();
                button.disabled = false;
                button.textContent = 'Delete User';
            }
        };

        // Close modal when clicking outside
        document.getElementById('deleteUserModal').addEventListener('click', function(e) {
            if (e.target === this) {
                window.hideDeleteUserModal();
            }
        });
    </script>
</x-dashboard-layout>