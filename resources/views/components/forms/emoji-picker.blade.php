@props([
    'id' => 'emoji-input-' . uniqid(),
    'name' => 'icon',
    'value' => '',
    'placeholder' => '🎯',
    'label' => 'Icon (emoji)',
    'maxlength' => '2',
    'disabled' => false,
    'required' => false,
])

<div>
    @if($label)
        <label for="{{ $id }}" class="form-label form-label-icon">
            {{ $label }}
        </label>
    @endif
    
    <div x-data="emojiPicker('{{ $id }}')" class="relative">
        <!-- Input with integrated button -->
        <div class="relative" x-ref="emojiInput">
            <input 
                type="text" 
                id="{{ $id }}"
                name="{{ $name }}"
                value="{{ old($name, $value) }}"
                placeholder="{{ $placeholder }}"
                maxlength="{{ $maxlength }}"
                {{ $disabled ? 'disabled' : '' }}
                {{ $required ? 'required' : '' }}
                {{ $attributes->merge(['class' => 'form-input pr-12']) }}
            />
            
            <!-- Emoji Picker Button - positioned inside input on the right -->
            <button 
                type="button"
                @click="togglePicker()"
                {{ $disabled ? 'disabled' : '' }}
                class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 text-2xl hover:scale-110 transition-transform duration-200 disabled:opacity-50 disabled:cursor-not-allowed rounded"
                :class="{ 'ring-2 ring-blue-500 rounded': showPicker }"
                title="Choose emoji">
                <span x-text="buttonText"></span>
            </button>
        </div>
        
        <!-- Emoji Picker Popover - improved mobile positioning -->
        <div 
            x-show="showPicker"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            x-anchor.bottom-start="$refs.emojiInput"
            class="fixed w-full sm:w-72 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 p-4"
            style="display: none; z-index: 9999;"
            @click.stop>
            
            <div class="mb-3 flex justify-between items-center">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Choose Emoji</h4>
                <button 
                    type="button"
                    @click="clearEmoji()"
                    class="text-xs text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400">
                    Clear
                </button>
            </div>
            
            <!-- Emoji Grid -->
            <div class="grid grid-cols-6 sm:grid-cols-8 gap-2 max-h-60 overflow-y-auto">
                <template x-for="(emoji, index) in commonEmojis" :key="index">
                    <button 
                        type="button"
                        @click="selectEmoji(emoji)"
                        class="text-2xl hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-2 transition-colors duration-150"
                        x-text="emoji">
                    </button>
                </template>
            </div>
            
            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                    Or type any emoji directly in the field
                </p>
            </div>
        </div>
    </div>
</div>
