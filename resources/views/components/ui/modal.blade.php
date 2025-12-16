@props([
    'name',
    'show' => false,
    'maxWidth' => 'md',
    'eyebrow' => null,
    'title' => null,
    'showClose' => true,
])

@php
$maxWidthClass = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
][$maxWidth];
@endphp

<div
    x-data="modalData('{{ $name }}', @js($show), {{ $attributes->has('focusable') ? 'true' : 'false' }})"
    x-on:open-modal.window="$event.detail === name && (show = true)"
    x-on:close-modal.window="$event.detail === name && (show = false)"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show && (show = false)"
    x-on:keydown.tab.prevent="handleTab($event)"
    x-show="show"
    class="modal-wrapper"
    style="display: {{ $show ? 'block' : 'none' }};"
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="modal-backdrop"
    ></div>

    {{-- Modal Content --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="modal-content {{ $maxWidthClass }} w-full"
    >
        {{-- Top Accent Bar --}}
        <div class="modal-accent"></div>

        {{-- Close Button --}}
        @if($showClose)
            <button type="button" @click="show = false" class="modal-close-button">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        @endif

        {{-- Header --}}
        @if($eyebrow || $title)
            <div class="modal-header">
                @if($eyebrow)
                    <div class="modal-eyebrow">{{ $eyebrow }}</div>
                @endif
                
                @if($title)
                    <h3 class="modal-title">{{ $title }}</h3>
                @endif
            </div>
        @endif

        <div class="modal-body">
            {{ $slot }}
        </div>
    </div>
</div>
