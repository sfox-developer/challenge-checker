@props([
    'label' => null,
    'name' => null,
    'value' => null,
    'options' => [],
    'required' => false,
    'icon' => null,
    'iconColor' => 'blue',
    'optional' => false,
    'hint' => null,
    'placeholder' => 'Select an option...',
])

<x-form-field 
    :label="$label" 
    :name="$name" 
    :icon="$icon" 
    :iconColor="$iconColor" 
    :optional="$optional"
    :hint="$hint">
    
    <select 
        name="{{ $name }}" 
        id="{{ $name }}" 
        class="app-input" 
        @if($required) required @endif
        {{ $attributes }}>
        
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        @endif
    </select>
</x-form-field>
