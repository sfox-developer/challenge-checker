<x-dashboard-layout>
    <x-slot name="title">Edit Challenge</x-slot>

    <x-dashboard.page-header 
        eyebrow="Edit Challenge"
        title="{{ $challenge->name }}"
        description="Update your challenge settings" />

    <div class="section">
        <div class="container max-w-4xl">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ request('back', route('challenges.show', $challenge)) }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-100 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ str_contains(request('back', ''), 'challenges/' . $challenge->id) ? 'Back to Challenge' : 'Back to Challenges' }}</span>
                </a>
            </div>

            <div class="card">
                <form action="{{ route('challenges.update', $challenge) }}" method="POST" id="challenge-form">
                        @csrf
                        @method('PUT')
                        @if(request('back'))
                            <input type="hidden" name="back" value="{{ request('back') }}">
                        @endif
                        
                        <!-- Challenge Name -->
                        <x-forms.form-input
                            name="name"
                            label="Challenge Name"
                            icon='<path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V7l-7-5z" clip-rule="evenodd"></path>'
                            iconColor="blue"
                            :value="$challenge->name"
                            placeholder="e.g., 30-Day Fitness Challenge"
                            required />

                        <!-- Description -->
                        <x-forms.form-textarea
                            name="description"
                            label="Description"
                            icon='<path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>'
                            iconColor="purple"
                            :value="$challenge->description"
                            placeholder="Describe what this challenge is about..."
                            optional
                            rows="3" />

                        <!-- Frequency Selection -->
                        <div x-data="habitEditForm('{{ $challenge->frequency_type?->value ?? 'daily' }}', {{ $challenge->frequency_count ?? 1 }})">
                            <x-forms.frequency-selector 
                                :frequency-type="$challenge->frequency_type?->value ?? 'daily'"
                                :frequency-count="$challenge->frequency_count ?? 1"
                            />
                        </div>

                        <!-- Duration -->
                        <div class="mb-6">
                            <label for="days_duration" class="form-label form-label-icon">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Duration (Days) <span class="form-label-required">*</span></span>
                            </label>
                            <div class="relative">
                                <input type="number" name="days_duration" id="days_duration" value="{{ old('days_duration', $challenge->days_duration) }}" 
                                       min="1" max="365"
                                       class="form-input pr-16" placeholder="30">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-500 text-sm">days</span>
                                </div>
                            </div>
                            @error('days_duration')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Public Checkbox -->
                        <x-forms.form-checkbox
                            name="is_public"
                            label="Make this challenge public"
                            description="Other users will be able to see this challenge in their feed"
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                            :checked="$challenge->is_public" />

                        <!-- Existing Goals Section -->
                        @if($challenge->goals->isNotEmpty())
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center space-x-2">
                                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Current Goals</span>
                                <span class="text-optional">(Read-only)</span>
                            </label>
                            
                            <div class="bg-blue-50 dark:bg-blue-900/30 border-2 border-blue-200 dark:border-blue-700 rounded-xl p-6">
                                <div id="existing-goals" class="space-y-4">
                                    @foreach($challenge->goals as $index => $goal)
                                        <div class="existing-goal-item bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                            <div class="flex items-start space-x-3">
                                                <div class="bg-slate-700 dark:bg-slate-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">
                                                    {{ $index + 1 }}
                                                </div>
                                                <div class="flex-1 space-y-2">
                                                    <div class="font-bold text-gray-800">{{ $goal->name }}</div>
                                                    @if($goal->description)
                                                        <div class="text-sm text-gray-600">{{ $goal->description }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="mt-4 text-sm text-gray-600 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <strong>Note:</strong> Existing goals cannot be modified once a challenge has been created to maintain progress tracking integrity.
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <x-ui.app-button variant="primary" type="submit">
                                <x-slot name="icon">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </x-slot>
                                Update Challenge
                            </x-ui.app-button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>