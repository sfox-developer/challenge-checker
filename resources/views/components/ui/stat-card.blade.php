@props([
    'label',
    'value'
])

<div class="dashboard-stat-card">
    @isset($icon)
    <div class="dashboard-stat-icon">
        {{ $icon }}
    </div>
    @endisset
    <div class="dashboard-stat-value">
        {{ $value }}
    </div>
    <div class="dashboard-stat-label">
        {{ $label }}
    </div>
</div>
