@props([
    'inputId' => 'password',
])

<div x-data="{ hasStartedTyping: false, localStrength: 0 }" class="mt-2">
    <!-- Hidden input watcher -->
    <div x-init="
        const input = document.getElementById('{{ $inputId }}');
        if (input) {
            input.addEventListener('input', (e) => {
                const password = e.target.value;
                if (password.length > 0) {
                    hasStartedTyping = true;
                    let score = 1;
                    if (password.length >= 8) score++;
                    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
                    if (/\d/.test(password)) score++;
                    if (/[^a-zA-Z\d]/.test(password)) score++;
                    localStrength = Math.min(score, 4);
                    $dispatch('password-strength-change', localStrength);
                } else {
                    hasStartedTyping = false;
                    localStrength = 0;
                    $dispatch('password-strength-change', 0);
                }
            });
        }
    "></div>

    <!-- Strength Bars -->
    <div class="flex gap-1">
        <div class="h-1 flex-1 rounded-full transition-colors duration-200"
             :class="localStrength >= 1 ? (localStrength === 1 ? 'bg-red-500' : localStrength === 2 ? 'bg-orange-500' : localStrength === 3 ? 'bg-green-500' : 'bg-green-700') : 'bg-gray-300 dark:bg-gray-600'"></div>
        <div class="h-1 flex-1 rounded-full transition-colors duration-200"
             :class="localStrength >= 2 ? (localStrength === 2 ? 'bg-orange-500' : localStrength === 3 ? 'bg-green-500' : 'bg-green-700') : 'bg-gray-300 dark:bg-gray-600'"></div>
        <div class="h-1 flex-1 rounded-full transition-colors duration-200"
             :class="localStrength >= 3 ? (localStrength === 3 ? 'bg-green-500' : 'bg-green-700') : 'bg-gray-300 dark:bg-gray-600'"></div>
        <div class="h-1 flex-1 rounded-full transition-colors duration-200"
             :class="localStrength >= 4 ? 'bg-green-700' : 'bg-gray-300 dark:bg-gray-600'"></div>
    </div>
    
    <div class="flex items-center justify-between mt-1">
        <p class="text-xs text-help" x-show="!hasStartedTyping">Use 8+ characters with mix of letters, numbers & symbols</p>
        <p class="text-xs font-medium" 
           x-show="hasStartedTyping"
           :class="{
               'text-red-600 dark:text-red-400': localStrength === 1,
               'text-orange-600 dark:text-orange-400': localStrength === 2,
               'text-green-600 dark:text-green-400': localStrength === 3,
               'text-green-700 dark:text-green-500': localStrength === 4
           }"
           x-text="localStrength === 1 ? 'Weak' : localStrength === 2 ? 'Fair' : localStrength === 3 ? 'Good' : localStrength === 4 ? 'Strong' : ''">
        </p>
    </div>
</div>
