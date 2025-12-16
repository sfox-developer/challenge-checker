@props([
    'variant' => 'primary',     // primary, secondary, success, danger
    'size' => 'md',             // sm, md, lg
    'type' => 'button',         // button, submit, reset
    'href' => null,             // If provided, renders as <a> instead of <button>
    'icon' => null,             // SVG icon slot
    'iconPosition' => 'left',   // left, right
])

@php
    // Map variant to CSS class
    $variantClasses = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'success' => 'btn-success',
        'danger' => 'btn-danger',
    ];

    // Determine the base class
    $baseClass = $variantClasses[$variant] ?? 'btn-primary';
    
    // Add size modifiers
    if ($size === 'sm') {
        $baseClass .= ' btn-sm';
    } elseif ($size === 'lg') {
        $baseClass .= ' btn-lg';
    }
    
    // Add disabled class if disabled attribute is present
    $isDisabled = $attributes->get('disabled', false);
    if ($isDisabled) {
        $baseClass .= ' btn-disabled';
    }

    // Merge with additional classes from $attributes
    $classes = $attributes->get('class', '');
    $finalClasses = trim("$baseClass $classes");
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $finalClasses]) }}>
        @if($icon && $iconPosition === 'left')
            {{ $icon }}
        @endif
        
        {{ $slot }}
        
        @if($icon && $iconPosition === 'right')
            {{ $icon }}
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $finalClasses]) }}>
        @if($icon && $iconPosition === 'left')
            {{ $icon }}
        @endif
        
        {{ $slot }}
        
        @if($icon && $iconPosition === 'right')
            {{ $icon }}
        @endif
    </button>
@endif
