<x-dashboard-layout>
    <x-slot name="title">Create New Challenge</x-slot>

    <x-dashboard.page-header 
        eyebrow="New Challenge"
        title="Create Challenge"
        description="Set up your new time-bound challenge" />

    {{-- Pass goals library data to JavaScript --}}
    <script>
        window.goalsLibraryData = @json($goals);
        window.goalStoreRoute = '{{ route("goals.store") }}';
    </script>

    {{-- Main Create Form Section --}}
    <div class="section pt-0" x-data="challengeCreateForm()" x-id="['challenge-form']">
        <div class="container max-w-4xl">
            <div class="step-form">
                {{-- Top Accent Bar --}}
                <div class="modal-accent"></div>
                
                <div class="step-form-content">
                    <form action="{{ route('challenges.store') }}" method="POST" :id="$id('challenge-form')">
                            @csrf
                        
                        {{-- Step Progress Indicator --}}
                        <div class="step-progress">
                            <div class="step-progress-track">
                                {{-- Step 1 --}}
                                <div class="step-progress-circle-wrapper">
                                    <div class="step-progress-circle"
                                         :class="{
                                            'completed': 1 < step,
                                            'active': 1 === step,
                                            'inactive': 1 > step
                                         }">
                                        <svg x-show="1 < step" class="w-5 h-5 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span x-show="1 >= step">1</span>
                                    </div>
                                    <div class="step-progress-label" :class="1 === step ? 'active' : 'inactive'">
                                        Basic Info
                                    </div>
                                </div>
                                
                                {{-- Connector 1-2 --}}
                                <div class="step-progress-connector" :class="1 < step ? 'completed' : 'inactive'"></div>
                                
                                {{-- Step 2 --}}
                                <div class="step-progress-circle-wrapper">
                                    <div class="step-progress-circle"
                                         :class="{
                                            'completed': 2 < step,
                                            'active': 2 === step,
                                            'inactive': 2 > step
                                         }">
                                        <svg x-show="2 < step" class="w-5 h-5 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span x-show="2 >= step">2</span>
                                    </div>
                                    <div class="step-progress-label" :class="2 === step ? 'active' : 'inactive'">
                                        Schedule
                                    </div>
                                </div>
                                
                                {{-- Connector 2-3 --}}
                                <div class="step-progress-connector" :class="2 < step ? 'completed' : 'inactive'"></div>
                                
                                {{-- Step 3 --}}
                                <div class="step-progress-circle-wrapper">
                                    <div class="step-progress-circle"
                                         :class="{
                                            'completed': 3 < step,
                                            'active': 3 === step,
                                            'inactive': 3 > step
                                         }">
                                        <svg x-show="3 < step" class="w-5 h-5 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span x-show="3 >= step">3</span>
                                    </div>
                                    <div class="step-progress-label" :class="3 === step ? 'active' : 'inactive'">
                                        Goals
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Mobile: Current Step Label --}}
                            <div class="step-progress-mobile-label">
                                <span x-text="'Step ' + step + ': ' + (step === 1 ? 'Basic Info' : step === 2 ? 'Schedule' : 'Goals')"></span>
                            </div>
                        </div>
                        
                        {{-- Basic Information Section --}}
                        <div x-show="step === 1" x-cloak>
                            {{-- Header --}}
                            <div class="modal-header">
                                <div class="modal-eyebrow">STEP 1 OF 3</div>
                                <h3 class="modal-title">Basic Information</h3>
                            </div>
                            
                            {{-- Body --}}
                            <div class="modal-body">
                                
                                <!-- Challenge Name -->
                                <x-forms.form-input
                                    name="name"
                                    label="Challenge Name"
                                    placeholder="e.g., 30-Day Fitness Challenge"
                                    x-model="name"
                                    required />

                                <!-- Description -->
                                <x-forms.form-textarea
                                    name="description"
                                    label="Description"
                                    placeholder="Describe what this challenge is about..."
                                    x-model="description"
                                    optional
                                    rows="3" />

                                <!-- Public Checkbox -->
                                <x-forms.form-checkbox
                                    name="is_public"
                                    label="Make this challenge public"
                                    description="Other users will be able to see this challenge in their feed"
                                    x-model="is_public"
                                    :checked="old('is_public', true)" />
                            </div>

                            {{-- Footer --}}
                            <div class="modal-footer">
                                <button 
                                    type="button" 
                                    @click="nextStep()" 
                                    :disabled="!name.trim()"
                                    class="btn-primary">
                                    Next
                                    <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Schedule & Tracking Section --}}
                        <div x-show="step === 2" x-cloak>
                            {{-- Header --}}
                            <div class="modal-header">
                                <div class="modal-eyebrow">STEP 2 OF 3</div>
                                <h3 class="modal-title">Schedule & Tracking</h3>
                            </div>
                            
                            {{-- Body --}}
                            <div class="modal-body">
                                
                                <!-- Frequency Selection -->
                                <x-forms.frequency-selector />

                                <!-- Duration -->
                                <div class="mb-6">
                                    <label for="days_duration" class="form-label">
                                        <span>Duration (Days) <span class="form-label-required">*</span></span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="days_duration" id="days_duration" 
                                            x-model="days_duration"
                                            value="{{ old('days_duration', '') }}" 
                                            min="1" max="365"
                                            class="form-input pr-16" 
                                            placeholder="30"
                                            required>
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
                            </div>

                            {{-- Footer --}}
                            <div class="modal-footer">
                                <button type="button" @click="prevStep()" class="btn-secondary">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Back
                                </button>
                                <button 
                                    type="button" 
                                    @click="nextStep()" 
                                    :disabled="!days_duration || days_duration < 1 || days_duration > 365"
                                    class="btn-primary">
                                    Next
                                    <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>


                        {{-- Goals Section (Step 3) --}}
                        <div x-show="step === 3">
                            {{-- Header --}}
                            <div class="modal-header">
                                <div class="modal-eyebrow">STEP 3 OF 3</div>
                                <h3 class="modal-title">Goals <span class="form-label-required">*</span></h3>
                            </div>
                            
                            {{-- Body --}}
                            <div class="modal-body">
                                <x-goal-selector 
                                    allow-multiple="true" 
                                    field-name="goals" 
                                    :goals-data="$goals" 
                                    :categories="$categories" />
                            </div>
                            
                            {{-- Footer --}}
                            <div class="modal-footer">
                                <button type="button" @click="prevStep()" class="btn-secondary">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Back
                                </button>
                                <button 
                                    type="submit"
                                    class="btn-primary">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Create Challenge
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Tips & Best Practices Section (Bottom) --}}
    <x-challenges.tips-section />

</x-dashboard-layout>
