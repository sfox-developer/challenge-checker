<x-dashboard-layout>
    <x-slot name="title">Edit Habit</x-slot>

    <x-dashboard.page-header 
        eyebrow="Edit Habit"
        title="{{ $habit->goal->name }}"
        description="Update your habit settings" />

    <div class="pb-12 md:pb-20">
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

                    <!-- Public Checkbox -->
                    <x-forms.form-checkbox
                        name="is_public"
                        label="Make this habit public"
                        description="Other users will be able to see this habit in their feed"
                        icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                        :checked="$habit->is_public"
                        class="mb-8" />

                    <x-forms.habit-frequency-form 
                        :frequency-type="$habit->frequency_type->value"
                        :frequency-count="$habit->frequency_count"
                        :selected-days="$habit->frequency_config['days'] ?? []"
                    />

                    <!-- Submit Buttons -->
                    <div class="flex justify-between items-center divider-top-md">
                        <x-ui.app-button variant="secondary" type="button" x-data="" @click="$dispatch('open-modal', 'delete-habit')">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Delete
                        </x-ui.app-button>
                        <div class="flex space-x-3">
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
