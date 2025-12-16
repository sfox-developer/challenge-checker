@props([
    'label',
    'value',
    'variant' => null,
    'animate' => false
])

<div {{ $attributes->merge(['class' => 'dashboard-stat-card ' . ($variant ? 'dashboard-stat-card-accent-' . $variant : '')]) }}>
    @if($animate)
        <div class="dashboard-stat-value" x-text="counter"></div>
    @else
        <div class="dashboard-stat-value">
            {{ $value }}
        </div>
    @endif
    <div class="dashboard-stat-label">
        {{ $label }}
    </div>
</div>
