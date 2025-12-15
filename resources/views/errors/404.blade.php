<x-public-layout>
    <x-slot name="title">404 - Page not found</x-slot>

    <div class="section">
        <div class="container max-w-2xl text-center">
            <!-- Icon -->
            <div class="mb-8 animate animate-hidden-fade-up"
                 x-data="{}"
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-slate-100 dark:bg-slate-800/50 mb-6">
                    <svg class="w-12 h-12 text-slate-700 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Message -->
            <div class="animate animate-hidden-fade-up animate-delay-100"
                 x-data="{}"
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 200)">
                <h1 class="mb-4">Page not found</h1>
                <p class="subtitle mb-8">
                    Oops! The page you're looking for doesn't exist. It might have been moved or deleted.
                </p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center mb-12 animate animate-hidden-fade-up animate-delay-200"
                 x-data="{}"
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 300)">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Go back</span>
                </a>
                
                @auth
                    <a href="{{ route('feed.index') }}" class="btn btn-primary">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Go to feed</span>
                    </a>
                @else
                    <a href="{{ url('/') }}" class="btn btn-primary">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Go home</span>
                    </a>
                @endauth
            </div>

            <!-- Helpful Links -->
            @auth
                <div class="pt-8 border-t border-gray-200 dark:border-gray-700 animate animate-hidden-fade-up animate-delay-300"
                     x-data="{}"
                     x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 400)">
                    <p class="text-help mb-4">Looking for something? Try these:</p>
                    <div class="flex flex-wrap justify-center gap-4 text-sm">
                        <a href="{{ route('challenges.index') }}" class="link">Your challenges</a>
                        <a href="{{ route('feed.index') }}" class="link">Activity feed</a>
                        <a href="{{ route('profile.edit') }}" class="link">Profile settings</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</x-public-layout>
