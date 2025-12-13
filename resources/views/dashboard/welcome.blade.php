<x-dashboard-layout>
    <x-slot name="title">Welcome - {{ config('app.name') }}</x-slot>

    <div class="section">
        <div class="container max-w-2xl text-center">
            
            <!-- Success Illustration -->
            <div class="mb-8 animate animate-hidden-scale-up" 
                 x-data="{}" 
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-scale-up') }, 100)">
                <div class="w-48 h-48 mx-auto" 
                     x-data="{ 
                         lottieLoaded: false,
                         animation: null 
                     }"
                     x-init="
                         import('https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js').then(module => {
                             const lottie = module.default;
                             animation = lottie.loadAnimation({
                                 container: $el,
                                 renderer: 'svg',
                                 loop: false,
                                 autoplay: true,
                                 path: 'https://lottie.host/a1ff5b4d-7b29-4c6e-9c8b-3e4f6a5c8e2d/Q5gK2tGH3l.json'
                             });
                             lottieLoaded = true;
                         });
                     ">
                </div>
            </div>

            <!-- Success Message -->
            <div class="animate animate-hidden-fade-up-sm" 
                 x-data="{}" 
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up-sm') }, 200)">
                <h1 class="h1 mb-4">Welcome to {{ config('app.name') }}! 🎉</h1>
                <p class="text-xl text-body mb-8">
                    Your account has been created successfully. You're all set to start tracking your goals and building better habits!
                </p>
            </div>

            <!-- Getting Started Cards -->
            <div class="grid md:grid-cols-3 gap-6 mb-10 text-left">
                <!-- Card 1: Create Challenge -->
                <div class="card p-6 animate animate-hidden-fade-up animate-delay-100" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                    <div class="text-4xl mb-3">🎯</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Start a Challenge
                    </h3>
                    <p class="text-sm text-body">
                        Create your first 30, 60, or 90-day challenge and set meaningful goals to track daily progress.
                    </p>
                </div>

                <!-- Card 2: Build Habits -->
                <div class="card p-6 animate animate-hidden-fade-up animate-delay-200" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                    <div class="text-4xl mb-3">🔄</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Track Habits
                    </h3>
                    <p class="text-sm text-body">
                        Build lasting habits with flexible tracking. Set your frequency and watch your streaks grow.
                    </p>
                </div>

                <!-- Card 3: Share Progress -->
                <div class="card p-6 animate animate-hidden-fade-up animate-delay-300" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                    <div class="text-4xl mb-3">👥</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Join the Community
                    </h3>
                    <p class="text-sm text-body">
                        Share your achievements, discover others' progress, and stay motivated together.
                    </p>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="animate animate-hidden-fade-up animate-delay-400" 
                 x-data="{}" 
                 x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <a href="{{ route('feed.index') }}" class="btn btn-primary btn-lg inline-flex items-center gap-2">
                    <span>Get Started</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <p class="text-sm text-help mt-4">
                    You can explore the app at your own pace
                </p>
            </div>

        </div>
    </div>
</x-dashboard-layout>
