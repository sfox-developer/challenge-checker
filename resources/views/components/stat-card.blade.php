@props([
    'label',
    'value'
])

<div class="stat-card">
    <div class="stat-card-value">
        {{ $value }}{{ $suffix ?? '' }}
    </div>
    <div class="stat-card-label">
        {{ $label }}
    </div>
</div>
