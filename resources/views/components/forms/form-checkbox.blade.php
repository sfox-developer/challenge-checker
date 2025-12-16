@props([
    'label' => null,
    'name' => null,
    'value' => '1',
    'checked' => false,
    'description' => null,
    'icon' => null,
    'iconColor' => 'blue',
])

<div {{ $attributes->merge(['class' => 'mb-6']) }}>
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input 
                type="checkbox" 
                name="{{ $name }}" 
                id="{{ $name }}" 
                value="{{ $value }}" 
                {{ old($name, $checked) ? 'checked' : '' }}
                class="form-checkbox">
        </div>
        <div class="ml-3">
            <label for="{{ $name }}" class="text-sm font-bold text-gray-800 dark:text-gray-100 flex items-center space-x-2">
                @if($icon)
                    <svg class="w-4 h-4 text-{{ $iconColor }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {!! $icon !!}
                    </svg>
                @endif
                <span>{{ $label }}</span>
            </label>
            @if($description)
                <p class="text-hint mt-1">{{ $description }}</p>
            @endif
        </div>
    </div>
</div>
