@props([
    'frequencyType' => 'daily',
    'frequencyCount' => 1,
])

<!-- Frequency Type -->
<div class="mb-6">
    <label for="frequency_type" class="form-label">
        How often? <span class="form-label-required">*</span>
    </label>
    
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <label class="cursor-pointer">
            <input type="radio" name="frequency_type" value="daily" x-model="frequencyType" class="sr-only" {{ $frequencyType === 'daily' ? 'checked' : '' }}>
            <div class="frequency-option">
                <div class="frequency-accent-bar"></div>
                <div class="p-4 text-center">
                    <div class="text-2xl mb-1">📅</div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Daily</div>
                </div>
            </div>
        </label>
        
        <label class="cursor-pointer">
            <input type="radio" name="frequency_type" value="weekly" x-model="frequencyType" class="sr-only" {{ $frequencyType === 'weekly' ? 'checked' : '' }}>
            <div class="frequency-option">
                <div class="frequency-accent-bar"></div>
                <div class="p-4 text-center">
                    <div class="text-2xl mb-1">📆</div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Weekly</div>
                </div>
            </div>
        </label>
        
        <label class="cursor-pointer">
            <input type="radio" name="frequency_type" value="monthly" x-model="frequencyType" class="sr-only" {{ $frequencyType === 'monthly' ? 'checked' : '' }}>
            <div class="frequency-option">
                <div class="frequency-accent-bar"></div>
                <div class="p-4 text-center">
                    <div class="text-2xl mb-1">🗓️</div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Monthly</div>
                </div>
            </div>
        </label>
        
        <label class="cursor-pointer">
            <input type="radio" name="frequency_type" value="yearly" x-model="frequencyType" class="sr-only" {{ $frequencyType === 'yearly' ? 'checked' : '' }}>
            <div class="frequency-option">
                <div class="frequency-accent-bar"></div>
                <div class="p-4 text-center">
                    <div class="text-2xl mb-1">📖</div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Yearly</div>
                </div>
            </div>
        </label>
    </div>
    @error('frequency_type')
        <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>

<!-- Frequency Count (hidden for daily) -->
<div class="mb-6" x-show="frequencyType !== 'daily'" x-cloak>
    <label for="frequency_count" class="form-label">
        How many times per <span x-text="frequencyPeriod"></span>? <span class="form-label-required">*</span>
    </label>
    
    <div class="grid grid-cols-7 gap-2">
        <template x-for="i in 7" :key="i">
            <label class="cursor-pointer">
                <input type="radio" name="frequency_count" :value="i" x-model="frequencyCount" class="sr-only" :checked="i === {{ $frequencyCount }}">
                <div class="frequency-number">
                    <div class="frequency-accent-bar"></div>
                    <span x-text="i"></span>
                </div>
            </label>
        </template>
    </div>
    
    <div class="mt-3">
        <p class="text-sm text-gray-600 dark:text-gray-400 text-center" x-show="frequencyCount > 0">
            <span class="font-semibold" style="color: var(--color-accent)" x-text="frequencyCount"></span>
            time<span x-show="frequencyCount > 1">s</span> per 
            <span x-text="frequencyPeriod"></span>
        </p>
    </div>
    
    @error('frequency_count')
        <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
