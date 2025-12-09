@props([
    'frequencyType' => 'daily',
    'frequencyCount' => 1,
    'selectedDays' => []
])

<!-- Frequency Type -->
<div class="mb-6">
    <label for="frequency_type" class="form-label form-label-icon">
        <svg class="w-4 h-4 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
        </svg>
        <span>How often?</span>
    </label>
    
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <label class="cursor-pointer">
            <input type="radio" name="frequency_type" value="daily" x-model="frequencyType" class="sr-only peer" {{ $frequencyType === 'daily' ? 'checked' : '' }}>
            <div class="p-4 text-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-slate-600 peer-checked:bg-blue-50 dark:peer-checked:bg-slate-600/10 transition-all duration-200">
                <div class="text-2xl mb-1">📅</div>
                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Daily</div>
            </div>
        </label>
        
        <label class="cursor-pointer">
            <input type="radio" name="frequency_type" value="weekly" x-model="frequencyType" class="sr-only peer" {{ $frequencyType === 'weekly' ? 'checked' : '' }}>
            <div class="p-4 text-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-slate-600 peer-checked:bg-blue-50 dark:peer-checked:bg-slate-600/10 transition-all duration-200">
                <div class="text-2xl mb-1">📆</div>
                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Weekly</div>
            </div>
        </label>
        
        <label class="cursor-pointer">
            <input type="radio" name="frequency_type" value="monthly" x-model="frequencyType" class="sr-only peer" {{ $frequencyType === 'monthly' ? 'checked' : '' }}>
            <div class="p-4 text-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-slate-600 peer-checked:bg-blue-50 dark:peer-checked:bg-slate-600/10 transition-all duration-200">
                <div class="text-2xl mb-1">🗓️</div>
                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Monthly</div>
            </div>
        </label>
        
        <label class="cursor-pointer">
            <input type="radio" name="frequency_type" value="yearly" x-model="frequencyType" class="sr-only peer" {{ $frequencyType === 'yearly' ? 'checked' : '' }}>
            <div class="p-4 text-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-slate-600 peer-checked:bg-blue-50 dark:peer-checked:bg-slate-600/10 transition-all duration-200">
                <div class="text-2xl mb-1">📖</div>
                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Yearly</div>
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
<div class="mb-6" x-show="frequencyType !== 'daily'">
    <label for="frequency_count" class="form-label form-label-icon">
        <svg class="w-4 h-4 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
        </svg>
        <span>How many times per <span x-text="frequencyPeriod"></span>?</span>
    </label>
    
    <div class="grid grid-cols-7 gap-2">
        <template x-for="i in 7" :key="i">
            <label class="cursor-pointer">
                <input type="radio" name="frequency_count" :value="i" x-model="frequencyCount" class="sr-only peer" :checked="i === {{ $frequencyCount }}">
                <div class="aspect-square flex items-center justify-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-slate-600 peer-checked:bg-slate-600 peer-checked:text-white font-bold text-lg text-gray-900 dark:text-gray-100 transition-all duration-200" x-text="i"></div>
            </label>
        </template>
    </div>
    
    <div class="mt-3">
        <p class="text-sm text-gray-600 dark:text-gray-400 text-center" x-show="frequencyCount > 0">
            <span class="font-semibold text-slate-700 dark:text-slate-400" x-text="frequencyCount"></span>
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

<!-- Weekly frequency config -->
<div x-show="frequencyType === 'weekly'" x-transition class="mb-6">
    <label class="form-label form-label-icon">
        <svg class="w-4 h-4 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
        </svg>
        <span>On which days? <span class="text-optional">(Optional - leave blank for any days)</span></span>
    </label>
    
    <div class="grid grid-cols-7 gap-2">
        <template x-for="(day, index) in ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']" :key="index">
            <label class="cursor-pointer">
                <input type="checkbox" name="weekly_days[]" :value="index + 1" class="sr-only peer" :checked="[{{ implode(',', $selectedDays) }}].includes(index + 1)">
                <div class="aspect-square flex items-center justify-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-slate-600 peer-checked:bg-slate-600 peer-checked:text-white font-semibold text-xs text-gray-900 dark:text-gray-100 transition-all duration-200" x-text="day"></div>
            </label>
        </template>
    </div>
</div>
