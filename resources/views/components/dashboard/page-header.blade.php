@props([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
])

<div class="py-8 md:py-12 text-center">
    <div class="container">
        @if($eyebrow)
            <div class="eyebrow animate animate-hidden-fade-up-sm" 
                 x-data="{}" 
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up-sm') }, 50)">
                {{ $eyebrow }}
            </div>
        @endif
        
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4 animate animate-hidden-fade-up-sm" 
            x-data="{}" 
            x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up-sm') }, 100)">
            {{ $title }}
        </h1>
        
        @if($description)
            <p class="text-base text-gray-600 dark:text-gray-400 max-w-2xl mx-auto animate animate-hidden-fade-up-sm animate-delay-100" 
               x-data="{}" 
               x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up-sm') }, 100)">
                {{ $description }}
            </p>
        @endif
    </div>
</div>
