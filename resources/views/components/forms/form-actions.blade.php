@props([
    'cancelRoute' => null,
    'cancelText' => 'Cancel',
    'submitText' => 'Submit',
    'submitIcon' => null,
    'submitVariant' => 'primary',
    'reverse' => false,
])

<div {{ $attributes->merge(['class' => 'flex space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700']) }}
     @if($reverse) style="flex-direction: row-reverse; justify-content: flex-end;" @endif>
    
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        @if(!$reverse)
            @if($cancelRoute)
                <x-ui.app-button variant="secondary" :href="$cancelRoute">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                    {{ $cancelText }}
                </x-ui.app-button>
            @endif
            
            <x-ui.app-button variant="{{ $submitVariant }}" type="submit">
                @if($submitIcon)
                    <x-slot name="icon">
                        {!! $submitIcon !!}
                    </x-slot>
                @else
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                @endif
                {{ $submitText }}
            </x-ui.app-button>
        @else
            <x-ui.app-button variant="{{ $submitVariant }}" type="submit">
                @if($submitIcon)
                    <x-slot name="icon">
                        {!! $submitIcon !!}
                    </x-slot>
                @else
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                @endif
                {{ $submitText }}
            </x-ui.app-button>
            
            @if($cancelRoute)
                <x-ui.app-button variant="secondary" :href="$cancelRoute">
                    {{ $cancelText }}
                </x-ui.app-button>
            @endif
        @endif
    @endif
</div>
