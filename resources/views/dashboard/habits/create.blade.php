<x-dashboard-layout>
    <x-slot name="title">Create New Habit</x-slot>

    <x-dashboard.page-header 
        eyebrow="New Habit"
        title="Create Habit"
        description="Build a new recurring habit" />

    {{-- Pass goals library data to JavaScript --}}
    <script>
        window.goalsLibraryData = @json($goalsLibrary);
        window.goalStoreRoute = '{{ route("goals.store") }}';
    </script>

    {{-- Main Create Form Section --}}
    <div class="section pt-0" x-data="{ frequencyType: 'daily', frequencyCount: 1, is_public: false }">
        <div class="container max-w-4xl">
            <div class="card">
                <form action="{{ route('habits.store') }}" method="POST" id="habit-form">
                    @csrf
                    
                    <!-- Goal Selection Component -->
                    <x-goal-selector 
                        allow-multiple="false" 
                        field-name="goal_id" 
                        :goals-data="$goalsLibrary" 
                        :categories="$categories" />

                    <!-- Public Checkbox -->
                    <x-forms.form-checkbox
                        name="is_public"
                        label="Make this habit public"
                        description="Other users will be able to see this habit in their feed"
                        x-model="is_public"
                        :checked="old('is_public', false)"
                        class="mb-8" />

                    <x-forms.habit-frequency-form />

                    <!-- Submit Buttons -->
                    <div class="px-6 py-5 mt-2 flex flex-col sm:flex-row justify-center items-stretch sm:items-center gap-3">
                        <a href="{{ route('habits.index') }}" class="btn-secondary w-full sm:w-auto">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary w-full sm:w-auto">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Create Habit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tips & Best Practices Section (Bottom) --}}
    <x-habits.tips-section />

</x-dashboard-layout>
