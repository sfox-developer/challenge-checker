<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Edit Habit" gradient="success">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                </svg>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form action="{{ route('habits.update', $habit) }}" method="POST" x-data="habitEditForm('{{ $habit->frequency_type->value }}', {{ $habit->frequency_count }})">
                    @csrf
                    @method('PUT')
                    
                    <!-- Current Goal Display -->
                    <div class="info-box info-box-primary">
                        <div class="flex items-center space-x-3">
                            <div class="text-3xl">{{ $habit->goal->icon }}</div>
                            <div class="flex-1">
                                <div class="font-bold text-gray-900 dark:text-white">{{ $habit->goal_name }}</div>
                                @if($habit->goal->description)
                                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $habit->goal->description }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <x-habit-frequency-form 
                        :frequency-type="$habit->frequency_type->value"
                        :frequency-count="$habit->frequency_count"
                        :selected-days="$habit->frequency_config['days'] ?? []"
                    />

                    <!-- Submit Buttons -->
                    <div class="flex space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="flex-1 btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Save Changes
                        </button>
                        <a href="{{ route('habits.show', $habit) }}" class="btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
