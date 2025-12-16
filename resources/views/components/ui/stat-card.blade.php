@props([
    'label',
    'value',
    'variant' => null
])

<div {{ $attributes->merge(['class' => 'dashboard-stat-card ' . ($variant ? 'dashboard-stat-card-accent-' . $variant : '')]) }}>
    <div class="dashboard-stat-value">
        {{ $value }}
    </div>
    <div class="dashboard-stat-label">
        {{ $label }}
    </div>
</div>
