@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'registration-success-box']) }}>
        {{ $status }}
    </div>
@endif
