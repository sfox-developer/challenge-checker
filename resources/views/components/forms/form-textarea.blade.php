@props([
    'label' => null,
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'rows' => 3,
    'required' => false,
    'icon' => null,
    'iconColor' => 'purple',
    'optional' => true,
    'hint' => null,
])

<x-forms.form-field 
    :label="$label" 
    :name="$name" 
    :icon="$icon" 
    :iconColor="$iconColor" 
    :optional="$optional"
    :hint="$hint">
    
    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}" 
        rows="{{ $rows }}" 
        class="form-input" 
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        {{ $attributes }}>{{ old($name, $value) }}</textarea>
</x-forms.form-field>
