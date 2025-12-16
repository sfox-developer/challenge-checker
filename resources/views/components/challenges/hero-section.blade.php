@props(['isEmpty'])

<div class="section pt-0">
    <div class="container max-w-4xl">
        <div class="text-center animate animate-hidden-fade-up-sm"
             x-data="{}"
             x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), 500)">
            
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Transform goals into <span class="lottie-underline">achievements<span class="lottie-underline-animation" x-lottie="{ path: '/animations/line.json', loop: false, autoplay: true, stretch: true }"></span></span>
            </h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                @if($isEmpty)
                    Start your first challenge to track progress, build momentum, and achieve your goals with time-bound focus.
                @else
                    Keep the momentum going! Track your progress, stay consistent, and watch your goals become reality.
                @endif
            </p>
        </div>
    </div>
</div>
