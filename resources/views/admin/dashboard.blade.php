<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Admin Dashboard" gradient="from-red-500 to-pink-500">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                </svg>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Total Users Stats -->
            <div class="mb-6">
                <x-stat-card 
                    label="Total Users" 
                    :value="$users->count()"
                    gradientFrom="red-500"
                    gradientTo="pink-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($users as $user)
                    <div class="card">
                        <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                    @if($user->is_admin)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                            Admin
                                        </span>
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
                                    <span class="font-semibold text-orange-600">{{ $user->active_challenges_count }}</span>
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
                                class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-center py-2 px-4 rounded-lg font-semibold text-sm transition-all duration-200 transform hover:scale-105">
                                View Details
                            </a>
                        </div>
                    @endforeach
                </div>

                @if($users->isEmpty())
                    <div class="text-center py-12">
                        <div class="bg-gradient-to-r from-gray-100 to-gray-200 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">No Users Found</h3>
                        <p class="text-gray-600 dark:text-gray-400">There are no users registered in the system yet.</p>
                    </div>
                @endif
        </div>
    </div>
</x-app-layout>