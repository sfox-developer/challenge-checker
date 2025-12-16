@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'icon' => null,
    'iconColor' => 'blue',
    'optional' => false,
    'hint' => null,
    'min' => null,
    'max' => null,
])

<x-forms.form-field 
    :label="$label" 
    :name="$name" 
    :icon="$icon" 
    :iconColor="$iconColor" 
    :optional="$optional"
    :hint="$hint">
    
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        class="form-input" 
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        @if($min !== null) min="{{ $min }}" @endif
        @if($max !== null) max="{{ $max }}" @endif
        {{ $attributes }}>
</x-forms.form-field>
