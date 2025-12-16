@props(['isEmpty'])

<div class="section pt-0">
    <div class="container max-w-4xl">
        <div class="text-center animate animate-hidden-fade-up-sm"
             x-data="{}"
             x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), 500)">
            
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Build your personal <span class="lottie-underline">goal library<span class="lottie-underline-animation" x-lottie="{ path: '/animations/line.json', loop: false, autoplay: true, stretch: true }"></span></span>
            </h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                @if($isEmpty)
                    Create reusable goals that you can add to any challenge or habit, saving time and maintaining consistency.
                @else
                    Manage your collection of reusable goals and use them across multiple challenges and habits.
                @endif
            </p>
        </div>
    </div>
</div>
