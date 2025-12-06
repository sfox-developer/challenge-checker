@props([
    'label' => null,
    'name' => null,
    'icon' => null,
    'iconColor' => 'blue',
    'optional' => false,
    'hint' => null,
    'error' => null,
])

<div {{ $attributes->merge(['class' => 'mb-6']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-bold text-gray-800 dark:text-gray-100 mb-2 flex items-center space-x-2">
            @if($icon)
                <svg class="w-4 h-4 text-{{ $iconColor }}-500" fill="currentColor" viewBox="0 0 20 20">
                    {!! $icon !!}
                </svg>
            @endif
            <span>{{ $label }}</span>
            @if($optional)
                <span class="text-xs text-gray-500 font-normal">(Optional)</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if($hint)
        <p class="mt-1 text-xs text-gray-500">{{ $hint }}</p>
    @endif

    @if($error || $errors->has($name))
        <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            <span>{{ $error ?? $errors->first($name) }}</span>
        </p>
    @endif
</div>
