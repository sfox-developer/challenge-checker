@props([
    'label',
    'value',
    'icon',
    'gradientFrom' => 'blue-500',
    'gradientTo' => 'indigo-500'
])

<div class="card">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <div class="bg-gradient-to-r from-{{ $gradientFrom }} to-{{ $gradientTo }} p-2 md:p-3 rounded-lg">
                {!! $icon !!}
            </div>
        </div>
        <div class="ml-3 md:ml-4 min-w-0">
            <div class="text-xs md:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                {{ $label }}
            </div>
            <div class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ $value }}{{ $suffix ?? '' }}
            </div>
        </div>
    </div>
</div>
