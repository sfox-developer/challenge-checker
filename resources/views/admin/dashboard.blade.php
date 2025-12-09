<x-app-layout>
    <x-slot name="header">
        <x-ui.page-header title="Admin Dashboard">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                </svg>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Actions -->
            <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('admin.categories.index') }}" class="card card-interactive p-6">
                    <div class="flex items-center space-x-4">
                        <div class="bg-slate-100 dark:bg-slate-900 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="h3">Manage Categories</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Create and edit goal categories</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.changelogs.index') }}" class="card card-interactive p-6">
                    <div class="flex items-center space-x-4">
                        <div class="bg-slate-100 dark:bg-slate-900 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="h3">Manage Changelogs</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Create and publish changelog entries</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Total Users Stats -->
            <div class="mb-6">
                <x-ui.stat-card 
                    label="Total Users" 
                    :value="$users->count()">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                    </x-slot>
                </x-ui.stat-card>
            </div>

            
            <div class="grid-3-cols-responsive">
                @foreach($users as $user)
                    <div class="card">
                        <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="h3">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                    @if($user->is_admin)
                                        <span class="badge-admin mt-1">Admin</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Total Challenges:</span>
                                    <span class="font-semibold">{{ $user->challenges_count }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Active:</span>
                                    <span class="font-semibold text-slate-700">{{ $user->active_challenges_count }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Completed:</span>
                                    <span class="font-semibold text-green-600">{{ $user->completed_challenges_count }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Member since:</span>
                                    <span class="font-semibold">{{ $user->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('admin.user', $user) }}" 
                                class="block w-full bg-slate-700 dark:bg-slate-600 hover:bg-slate-800 dark:hover:bg-slate-700 text-white text-center py-2 px-4 rounded-lg font-semibold text-sm transition-all duration-200 transform hover:scale-105">
                                View Details
                            </a>
                        </div>
                    @endforeach
                </div>

                @if($users->isEmpty())
                    <div class="text-center py-12">
                        <div class="empty-state-icon-muted">
                            <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="h2 mb-2">No Users Found</h3>
                        <p class="text-gray-600 dark:text-gray-400">There are no users registered in the system yet.</p>
                    </div>
                @endif
        </div>
    </div>
</x-app-layout>