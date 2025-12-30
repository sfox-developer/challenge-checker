<x-dashboard-layout>
    <x-slot name="title">Edit Challenge</x-slot>

    <x-dashboard.page-header 
        eyebrow="Edit Challenge"
        title="{{ $challenge->name }}"
        :description="$challenge->description" />

    <!-- Action Buttons -->
    <div class="pb-6">
        <div class="container">
            <div class="flex justify-center">
                <div class="flex space-x-2">
                    <x-ui.app-button variant="secondary" href="{{ request('back', route('challenges.show', $challenge)) }}">
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

    <div class="section pt-0" x-data="challengeEditForm('{{ addslashes($challenge->name) }}', '{{ $challenge->days_duration }}')">
        <div class="container max-w-4xl">
            <div class="card">
                <form action="{{ route('challenges.update', $challenge) }}" method="POST" id="challenge-form">
                        @csrf
                        @method('PUT')
                        @if(request('back'))
                            <input type="hidden" name="back" value="{{ request('back') }}">
                        @endif
                        
                        {{-- Basic Information Section --}}
                        <div class="mb-8">
                            <div class="form-section-eyebrow">SECTION 1 OF 3</div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Basic Information</h3>
                            
                            <!-- Challenge Name -->
                            <x-forms.form-input
                                name="name"
                                label="Challenge Name"
                                iconColor="blue"
                                :value="$challenge->name"
                                placeholder="e.g., 30-Day Fitness Challenge"
                                x-model="name"
                                required />

                            <!-- Description -->
                            <x-forms.form-textarea
                                name="description"
                                label="Description"
                                iconColor="purple"
                                :value="$challenge->description"
                                placeholder="Describe what this challenge is about..."
                                optional
                                rows="3" />

                            <!-- Public Checkbox -->
                            <x-forms.form-checkbox
                                name="is_public"
                                label="Make this challenge public"
                                description="Other users will be able to see this challenge in their feed"
                                :checked="$challenge->is_public" />
                        </div>

                        {{-- Section Separator --}}
                        <div class="border-t border-gray-200 dark:border-gray-700 my-8"></div>

                        {{-- Schedule & Tracking Section --}}
                        <div class="">
                            <div class="form-section-eyebrow">SECTION 2 OF 3</div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Schedule & Tracking</h3>
                            
                            <!-- Frequency Selection -->
                            <div x-data="habitEditForm('{{ $challenge->frequency_type?->value ?? 'daily' }}', {{ $challenge->frequency_count ?? 1 }})">
                                <x-forms.frequency-selector 
                                    :frequency-type="$challenge->frequency_type?->value ?? 'daily'"
                                    :frequency-count="$challenge->frequency_count ?? 1"
                                />
                            </div>

                            <!-- Duration -->
                            <div class="mb-6">
                                <label for="days_duration" class="form-label">
                                    <span>Duration (Days) <span class="form-label-required">*</span></span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="days_duration" id="days_duration" value="{{ old('days_duration', $challenge->days_duration) }}" 
                                           min="1" max="365"
                                           x-model="days_duration"
                                           class="form-input pr-16" placeholder="30">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-500 text-sm">days</span>
                                    </div>
                                </div>
                                @error('days_duration')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Section Separator --}}
                        <div class="border-t border-gray-200 dark:border-gray-700 my-8"></div>

                        {{-- Goals Section --}}
                        @if($challenge->goals->isNotEmpty())
                        <div class="mb-8">
                            <div class="form-section-eyebrow">SECTION 3 OF 3</div>
                            <label class="form-section-label">
                                <span>Current Goals</span>
                                <span class="text-optional">(Read-only)</span>
                            </label>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                                @foreach($challenge->goals as $goal)
                                    <x-goal-card>
                                        <x-slot:icon>
                                            <div class="goal-display-card-icon">{{ $goal->library?->icon ?? '🎯' }}</div>
                                        </x-slot:icon>
                                        <x-slot:title>
                                            <h5 class="goal-display-card-title">{{ $goal->name }}</h5>
                                        </x-slot:title>
                                        @if($goal->description)
                                            <x-slot:subtitle>
                                                <p class="goal-display-card-description">{{ $goal->description }}</p>
                                            </x-slot:subtitle>
                                        @endif
                                    </x-goal-card>
                                @endforeach
                            </div>

                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-3">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Note:</strong> Existing goals cannot be modified once a challenge has been created to maintain progress tracking integrity.
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3 divider-top-md">
                            <x-ui.app-button variant="secondary" href="{{ request('back', route('challenges.show', $challenge)) }}">
                                Cancel
                            </x-ui.app-button>
                            <button 
                                type="submit" 
                                :disabled="!name.trim() || !days_duration || days_duration < 1 || days_duration > 365"
                                class="btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Save Changes
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>