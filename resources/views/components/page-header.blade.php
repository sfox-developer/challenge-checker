@props([
    'title' => null,
    'gradient' => 'from-blue-500 to-purple-500',
])

@php
    // Convert "from-blue-500 to-purple-500" to "blue-purple"
    $gradientClass = preg_replace('/from-(\w+)-\d+\s+to-(\w+)-\d+/', '$1-$2', $gradient);
@endphp

<div class="page-header">
    <div class="page-header-content">
        @isset($icon)
            <div class="page-header-icon gradient-{{ $gradientClass }}">
                {{ $icon }}
            </div>
        @endisset
        <h2 class="page-header-title">
            {{ $title }}
        </h2>
    </div>
    
    @isset($action)
        <div class="page-header-actions">
            {{ $action }}
        </div>
    @endisset
</div>
