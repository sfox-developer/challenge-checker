@props([
    'variant' => 'primary',     // primary, secondary, success, danger, blue, gradient-purple, gradient-pause, gradient-complete
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
        'blue' => 'btn-blue',
        'gradient-purple' => 'btn-gradient-purple',
        'gradient-pause' => 'btn-gradient-pause',
        'gradient-complete' => 'btn-gradient-complete',
        'modal-cancel' => 'btn-modal-cancel',
        'modal-confirm' => 'btn-modal-confirm',
        'action-sm' => 'btn-action-sm',
        'action-pause' => 'btn-action-pause',
        'action-complete' => 'btn-action-complete',
    ];

    // Map size to CSS class for variants that support sizing
    $sizeClasses = [
        'sm' => 'btn-success-sm',
        'md' => 'btn-success',
        'lg' => 'btn-success',
    ];

    // Determine the base class
    if ($variant === 'success' && $size === 'sm') {
        $baseClass = 'btn-success-sm';
    } else {
        $baseClass = $variantClasses[$variant] ?? 'btn-primary';
    }

    // Merge with additional classes from $attributes
    $classes = $attributes->get('class', '');
    $finalClasses = trim("$baseClass $classes");
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $finalClasses]) }}>
        @if($icon && $iconPosition === 'left')
            <span class="icon-left">{{ $icon }}</span>
        @endif
        
        <span>{{ $slot }}</span>
        
        @if($icon && $iconPosition === 'right')
            <span class="icon-right">{{ $icon }}</span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $finalClasses]) }}>
        @if($icon && $iconPosition === 'left')
            <span class="icon-left">{{ $icon }}</span>
        @endif
        
        <span>{{ $slot }}</span>
        
        @if($icon && $iconPosition === 'right')
            <span class="icon-right">{{ $icon }}</span>
        @endif
    </button>
@endif
