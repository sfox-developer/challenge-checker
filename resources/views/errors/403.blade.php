<x-public-layout>
    <x-slot name="title">403 - Access forbidden</x-slot>

    <div class="section">
        <div class="container max-w-2xl text-center">
            <!-- Icon -->
            <div class="mb-8 animate animate-hidden-fade-up"
                 x-data="{}"
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-slate-100 dark:bg-slate-800/50 mb-6">
                    <svg class="w-12 h-12 text-slate-700 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>

            <!-- Message -->
            <div class="animate animate-hidden-fade-up animate-delay-100"
                 x-data="{}"
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 200)">
                <h1 class="mb-4">Access forbidden</h1>
                <p class="subtitle mb-8">
                    You don't have permission to access this page.
                </p>
            </div>

            <!-- Debug Info -->
            @if(config('app.debug'))
                <div class="mb-8 p-4 rounded-xl bg-yellow-50/50 dark:bg-yellow-900/10 text-left animate animate-hidden-fade-up animate-delay-150"
                     style="backdrop-filter: blur(10px);"
                     x-data="{}"
                     x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 250)">
                    <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200 mb-1">Debug information:</p>
                    <p class="text-xs text-yellow-700 dark:text-yellow-300 font-mono">
                        {{ $exception->getMessage() ?: 'This action is unauthorized.' }}
                    </p>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center animate animate-hidden-fade-up animate-delay-200"
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
        </div>
    </div>
</x-public-layout>
