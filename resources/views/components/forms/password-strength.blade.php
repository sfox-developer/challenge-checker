@props([
    'inputId' => 'password',
])

<div x-data="{ passwordStrength: 0 }" class="mt-2">
    <!-- Hidden input watcher -->
    <div x-init="
        $watch('passwordStrength', () => {});
        const input = document.getElementById('{{ $inputId }}');
        if (input) {
            input.addEventListener('input', (e) => {
                const password = e.target.value;
                let score = 0;
                if (password.length >= 8) score++;
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
                if (/\d/.test(password)) score++;
                if (/[^a-zA-Z\d]/.test(password)) score++;
                passwordStrength = score;
            });
        }
    "></div>

    <!-- Strength Bars -->
    <div class="flex gap-1">
        <div class="h-1 flex-1 rounded-full transition-colors duration-200"
             :class="passwordStrength >= 1 ? (passwordStrength === 1 ? 'bg-red-500' : passwordStrength === 2 ? 'bg-orange-500' : passwordStrength === 3 ? 'bg-blue-500' : 'bg-green-500') : 'bg-gray-300 dark:bg-gray-600'"></div>
        <div class="h-1 flex-1 rounded-full transition-colors duration-200"
             :class="passwordStrength >= 2 ? (passwordStrength === 2 ? 'bg-orange-500' : passwordStrength === 3 ? 'bg-blue-500' : 'bg-green-500') : 'bg-gray-300 dark:bg-gray-600'"></div>
        <div class="h-1 flex-1 rounded-full transition-colors duration-200"
             :class="passwordStrength >= 3 ? (passwordStrength === 3 ? 'bg-blue-500' : 'bg-green-500') : 'bg-gray-300 dark:bg-gray-600'"></div>
        <div class="h-1 flex-1 rounded-full transition-colors duration-200"
             :class="passwordStrength >= 4 ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600'"></div>
    </div>
    
    <p class="text-xs text-help mt-1">Use 8+ characters with mix of letters, numbers & symbols</p>
</div>
