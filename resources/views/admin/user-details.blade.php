<x-app-layout>
    <x-slot name="header">
        <x-page-header title="{{ $user->name }}" gradient="from-blue-500 to-purple-500">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                </svg>
            </x-slot>
            <x-slot name="action">
                <div class="flex space-x-2">
                    <x-app-button variant="secondary" href="{{ route('admin.dashboard') }}">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                            </svg>
                        </x-slot>
                        Back
                    </x-app-button>
                    
                    @if($user->is_admin)
                        <span class="px-4 py-2 rounded-lg text-sm font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Admin User
                        </span>
                    @else
                        <x-app-button 
                            variant="secondary" 
                            type="button"
                            onclick="window.showDeleteUserModal('{{ $user->name }}', '{{ route('admin.user.delete', $user) }}')">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </x-slot>
                            Delete
                        </x-app-button>
                    @endif
                </div>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- User Email Info -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    <span>{{ $user->email }}</span>
                    <span class="text-gray-300 dark:text-gray-600">•</span>
                    <span>Member since {{ $user->created_at->format('M j, Y') }}</span>
                </div>
            </div>

            <!-- User Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <x-stat-card 
                    label="Total Challenges" 
                    :value="$user->challenges->count()" 
                    gradientFrom="blue-500" 
                    gradientTo="indigo-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Active" 
                    :value="$user->challenges->where('started_at', '!=', null)->where('completed_at', null)->where('is_active', true)->count()" 
                    gradientFrom="yellow-400" 
                    gradientTo="orange-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Completed" 
                    :value="$user->challenges->where('completed_at', '!=', null)->count()" 
                    gradientFrom="green-500" 
                    gradientTo="green-600">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Paused" 
                    :value="$user->challenges->where('started_at', '!=', null)->where('is_active', false)->where('completed_at', null)->count()" 
                    gradientFrom="purple-500" 
                    gradientTo="pink-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>
            </div>

            <!-- Challenges List -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Challenges</h3>
                    
                    @if($user->challenges->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($user->challenges as $challenge)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $challenge->name }}</h4>
                                            @if($challenge->description)
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $challenge->description }}</p>
                                            @endif
                                        </div>
                                        @if($challenge->completed_at)
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                                ✓ Completed
                                            </span>
                                        @elseif($challenge->started_at && $challenge->is_active)
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-800">
                                                🏃 Active
                                            </span>
                                        @elseif($challenge->started_at && !$challenge->is_active)
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-800">
                                                ⏸️ Paused
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-800">
                                                📝 Draft
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Challenge Info -->
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-4">
                                        <div>
                                            <span class="text-gray-500">Duration:</span>
                                            <span class="font-semibold ml-1">{{ $challenge->days_duration }} days</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Created:</span>
                                            <span class="font-semibold ml-1">{{ $challenge->created_at->format('M j, Y') }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Started:</span>
                                            <span class="font-semibold ml-1">{{ $challenge->started_at ? $challenge->started_at->format('M j, Y') : '-' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Completed:</span>
                                            <span class="font-semibold ml-1">{{ $challenge->completed_at ? $challenge->completed_at->format('M j, Y') : '-' }}</span>
                                        </div>
                                    </div>

                                    <!-- Progress Bar (for active challenges) -->
                                    @if($challenge->is_active && !$challenge->completed_at)
                                        <div class="mb-4">
                                            <div class="flex justify-between text-sm mb-2">
                                                <span class="text-gray-600 dark:text-gray-400">Progress</span>
                                                <span class="font-semibold text-blue-600">{{ number_format($challenge->getProgressPercentage(), 1) }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-500" style="width: {{ $challenge->getProgressPercentage() }}%"></div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Goals -->
                                    @if($challenge->goals->isNotEmpty())
                                        <div>
                                            <h5 class="font-medium text-gray-800 dark:text-gray-100 mb-2">Goals ({{ $challenge->goals->count() }})</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                @foreach($challenge->goals as $goal)
                                                    <div class="bg-gray-50 p-3 rounded-lg">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <span class="font-medium text-sm">{{ $goal->name }}</span>
                                                            @if($challenge->started_at)
                                                                @php
                                                                    $isCompleted = $goal->isCompletedForDate(today()->toDateString(), $user->id);
                                                                @endphp
                                                                <span class="text-xs px-2 py-1 rounded-full {{ $isCompleted ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                                    {{ $isCompleted ? 'Done Today' : 'Pending' }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        @if($goal->dailyProgress->isNotEmpty())
                                                            <div class="text-xs text-gray-500">
                                                                Total completed days: {{ $goal->dailyProgress->where('completed', true)->count() }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">No Challenges</h4>
                            <p class="text-gray-600 dark:text-gray-400">This user hasn't created any challenges yet.</p>
                        </div>
                    @endif
            </div>
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
                        Delete User Account
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
</x-app-layout>