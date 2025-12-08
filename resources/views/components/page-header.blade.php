@props([
    'title' => null,
    'gradient' => 'primary',  // primary (blue-purple), success (green), danger (red)
])

<div class="page-header">
    <div class="page-header-content">
        @isset($icon)
            <div class="page-header-icon gradient-{{ $gradient }}">
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
