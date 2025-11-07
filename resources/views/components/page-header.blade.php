@props([
    'icon' => null,
    'title',
    'gradient' => 'from-blue-500 to-purple-500',
])

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
    <div class="flex items-center space-x-3">
        @if($icon)
            <div class="bg-gradient-to-r {{ $gradient }} p-2 rounded-lg flex-shrink-0">
                {{ $icon }}
            </div>
        @endif
        <h2 class="font-bold text-xl sm:text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ $title }}
        </h2>
    </div>
    
    @isset($action)
        <div class="w-full sm:w-auto">
            {{ $action }}
        </div>
    @endisset
</div>
