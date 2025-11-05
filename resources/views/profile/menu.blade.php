<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto px-4">
            <!-- Profile Header -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-6">
                <div class="p-8 text-center">
                    <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}" class="h-24 w-24 rounded-full mx-auto mb-4 ring-4 ring-white shadow-lg">
                    <h2 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h2>
                    <p class="text-gray-600 mt-1">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Menu Options -->
            <div class="space-y-3">
                <!-- My Profile -->
                <a href="{{ route('users.show', Auth::user()) }}" class="block bg-white overflow-hidden shadow-md rounded-xl hover:shadow-lg transition-all duration-200 transform hover:scale-[1.02]">
                    <div class="p-5 flex items-center space-x-4">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">My Profile</h3>
                            <p class="text-sm text-gray-600">View your public profile</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Settings -->
                <a href="{{ route('profile.edit') }}" class="block bg-white overflow-hidden shadow-md rounded-xl hover:shadow-lg transition-all duration-200 transform hover:scale-[1.02]">
                    <div class="p-5 flex items-center space-x-4">
                        <div class="bg-gradient-to-r from-green-500 to-teal-500 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">Settings</h3>
                            <p class="text-sm text-gray-600">Edit your profile & preferences</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Log Out -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full block bg-white overflow-hidden shadow-md rounded-xl hover:shadow-lg transition-all duration-200 transform hover:scale-[1.02]">
                        <div class="p-5 flex items-center space-x-4">
                            <div class="bg-gradient-to-r from-red-500 to-pink-500 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <h3 class="text-lg font-semibold text-gray-900">Log Out</h3>
                                <p class="text-sm text-gray-600">Sign out of your account</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
