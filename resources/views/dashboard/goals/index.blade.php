<x-dashboard-layout>
    <x-slot name="title">Goal Library</x-slot>

    <x-dashboard.page-header 
        eyebrow="Your Collection"
        title="Goal Library"
        description="Reusable goals for your challenges and habits" />

    <div>
        {{-- Stats Section --}}
        <x-goals.stats-section 
            :totalGoals="$totalGoals" 
            :usedInChallenges="$usedInChallenges"
            :usedInHabits="$usedInHabits" />

        {{-- Hero Section --}}
        <x-goals.hero-section :isEmpty="$goals->isEmpty() && !$search && !$categoryId" />

        {{-- Goals List Section --}}
        <div class="section pt-0">
            <div class="container max-w-4xl">
                {{-- Create Goal CTA --}}
                @if($totalGoals > 0)
                    <div class="flex justify-center mb-8 animate animate-hidden-fade-up"
                         x-data="{}"
                         x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 500)">
                        <x-ui.app-button variant="primary" @click="$dispatch('open-modal', 'create-goal')">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                            </x-slot>
                            Create New Goal
                        </x-ui.app-button>
                    </div>
                @endif

                {{-- Search and Filter --}}
                @if($totalGoals > 0)
                    <div class="card animate animate-hidden-fade-up mb-8"
                         x-data="{}"
                         x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 600)">
                        <form method="GET" action="{{ route('goals.index') }}" class="flex flex-col sm:flex-row gap-3">
                            <!-- Search -->
                            <div class="flex-1">
                                <input type="text" 
                                       name="search" 
                                       value="{{ $search ?? '' }}"
                                       placeholder="Search goals..." 
                                       class="form-input">
                            </div>

                            <!-- Category Filter -->
                            <div class="sm:w-48">
                                <select name="category" class="form-input">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->icon }} {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Search Button -->
                            <button type="submit" class="btn-primary sm:w-auto">
                                <svg class="w-5 h-5 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                </svg>
                                <span class="hidden sm:inline">Search</span>
                            </button>

                            @if($search || $categoryId)
                                <a href="{{ route('goals.index') }}" class="btn-secondary sm:w-auto">
                                    Clear
                                </a>
                            @endif
                        </form>
                    </div>
                @endif

                {{-- Goals Grid or Empty State --}}
                @if($goals->count() > 0)
                    <div class="dashboard-grid-3-cols">
                        @foreach($goals as $index => $goal)
                            <x-goals.goal-card :goal="$goal" :index="$index" :categories="$categories" />
                        @endforeach
                    </div>
                @else
                    <x-goals.empty-state :search="$search" :categoryId="$categoryId" />
                @endif
            </div>
        </div>

        {{-- Benefits Section --}}
        <x-goals.benefits-section />

        {{-- FAQ Section --}}
        <x-goals.faq-section />
    </div>

    <!-- Create Goal Modal -->
    <x-ui.modal 
        name="create-goal" 
        :show="$errors->any()"
        eyebrow="Your Collection"
        title="Add New Goal"
        maxWidth="lg"
    >
        <form action="{{ route('goals.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <x-forms.form-input
                    name="name"
                    label="Goal Name"
                    placeholder="e.g., Exercise, Read, Meditate"
                    required />

                <div class="grid grid-cols-2 gap-3">
                    <x-forms.emoji-picker 
                        id="create-goal-icon"
                        name="icon" 
                        :value="old('icon')"
                        placeholder="🎯"
                        label="Icon (emoji)" />
                    
                    <x-forms.form-select
                        name="category_id"
                        label="Category"
                        placeholder="None">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">
                                {{ $cat->icon }} {{ $cat->name }}
                            </option>
                        @endforeach
                    </x-forms.form-select>
                </div>

                <x-forms.form-textarea
                    name="description"
                    label="Description"
                    placeholder="What is this goal about?"
                    rows="3"
                    optional />
            </div>

            <div class="modal-footer">
                <button type="button" 
                        @click="$dispatch('close-modal', 'create-goal')"
                        class="btn-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn-primary">
                    Add Goal
                </button>
            </div>
        </form>
    </x-ui.modal>
</x-dashboard-layout>
