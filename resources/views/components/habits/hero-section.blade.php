@props(['isEmpty'])

<div class="section pt-0">
    <div class="container max-w-4xl">
        <div class="text-center animate animate-hidden-fade-up-sm"
             x-data="{}"
             x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), 500)">
            
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Build lasting habits through <span class="lottie-underline">consistency<span class="lottie-underline-animation" x-lottie="{ path: '/animations/line.json', loop: false, autoplay: false, stretch: true, scrollProgress: true }"></span></span>
            </h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                @if($isEmpty)
                    Start tracking your first habit today with flexible frequency options and build momentum through daily practice.
                @else
                    Track your daily progress, maintain your streaks, and watch positive habits become second nature.
                @endif
            </p>
        </div>
    </div>
</div>
