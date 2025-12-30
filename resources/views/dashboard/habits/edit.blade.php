<x-dashboard-layout>
    <x-slot name="title">Edit Habit</x-slot>

    <x-dashboard.page-header 
        eyebrow="Edit Habit"
        title="{{ $habit->goal->name }}"
        :description="$habit->goal->description" />

    <!-- Action Buttons -->
    <div class="pb-6">
        <div class="container">
            <div class="flex justify-center">
                <div class="flex space-x-2">
                    <x-ui.app-button variant="secondary" href="{{ route('habits.show', $habit) }}">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                            </svg>
                        </x-slot>
                        Back
                    </x-ui.app-button>
                </div>
            </div>
        </div>
    </div>

    <div class="section pt-0">
        <div class="container max-w-4xl">
            <div class="card">
                <form action="{{ route('habits.update', $habit) }}" method="POST" x-data="habitEditForm('{{ $habit->frequency_type->value }}', {{ $habit->frequency_count }})">
                    @csrf
                    @method('PUT')
                    
                    <!-- Current Goal Display -->
                    <div class="mb-6">
                        <label class="form-section-label">
                            <span>Current Goal</span>
                            <span class="text-optional">(Read-only)</span>
                        </label>
                        <x-goal-card>
                            <x-slot:icon>
                                <div class="goal-display-card-icon">{{ $habit->goal->icon ?? '🎯' }}</div>
                            </x-slot:icon>
                            <x-slot:title>
                                <h5 class="goal-display-card-title">{{ $habit->goal->name }}</h5>
                            </x-slot:title>
                            @if($habit->goal->description)
                                <x-slot:subtitle>
                                    <p class="goal-display-card-description">{{ $habit->goal->description }}</p>
                                </x-slot:subtitle>
                            @endif
                        </x-goal-card>
                    </div>

                    <!-- Public Checkbox -->
                    <x-forms.form-checkbox
                        name="is_public"
                        label="Make this habit public"
                        description="Other users will be able to see this habit in their feed"
                        :checked="$habit->is_public"
                        class="mb-8" />

                    <x-forms.habit-frequency-form 
                        :frequency-type="$habit->frequency_type->value"
                        :frequency-count="$habit->frequency_count"
                    />

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 divider-top-md">
                        <x-ui.app-button variant="secondary" href="{{ route('habits.show', $habit) }}">
                            Cancel
                        </x-ui.app-button>
                        <x-ui.app-button variant="primary" type="submit">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Save Changes
                        </x-ui.app-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-ui.modal 
        name="delete-habit"
        eyebrow="Delete Habit" 
        title="Are you sure?"
        maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                All completion history and statistics will be permanently deleted. This action cannot be undone.
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" 
                    @click="$dispatch('close-modal', 'delete-habit')"
                    class="btn-secondary">
                Cancel
            </button>
            <form method="POST" action="{{ route('habits.destroy', $habit) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700 focus:ring-red-500">
                    Delete Habit
                </button>
            </form>
        </div>
    </x-ui.modal>

</x-dashboard-layout>
