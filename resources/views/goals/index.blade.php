<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Goal Library" gradient="from-purple-500 to-pink-500">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"/>
                </svg>
            </x-slot>
            <x-slot name="action">
                <x-app-button variant="primary" @click="$dispatch('open-modal', 'create-goal')" class="w-full sm:w-auto">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                    <span class="hidden sm:inline">Add New Goal</span>
                    <span class="sm:hidden">New Goal</span>
                </x-app-button>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Search and Filter -->
            <div class="card">
                <form method="GET" action="{{ route('goals.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <!-- Search -->
                    <div class="flex-1">
                        <input type="text" 
                               name="search" 
                               value="{{ $search ?? '' }}"
                               placeholder="Search goals..." 
                               class="app-input">
                    </div>

                    <!-- Category Filter -->
                    <div class="sm:w-48">
                        <select name="category" class="app-input">
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

            <!-- Goals Grid -->
            @if($goals->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($goals as $goal)
                        <div class="card hover:shadow-lg transition-shadow duration-200" x-data="{ showMenu: false }">
                            <div class="flex items-start justify-between">
                                <a href="{{ route('goals.show', $goal) }}" class="flex items-start space-x-3 flex-1 min-w-0">
                                    <div class="text-3xl">{{ $goal->icon ?? '🎯' }}</div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-1 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                            {{ $goal->name }}
                                        </h3>
                                        
                                        @if($goal->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                                {{ Str::limit($goal->description, 100) }}
                                            </p>
                                        @endif

                                        <div class="flex flex-wrap items-center gap-2 mt-2">
                                            @if($goal->category)
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                                    {{ $goal->category->icon }} {{ $goal->category->name }}
                                                </span>
                                            @endif

                                            @if($goal->challenge_goals_count > 0)
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                    {{ $goal->challenge_goals_count }} challenge{{ $goal->challenge_goals_count !== 1 ? 's' : '' }}
                                                </span>
                                            @endif

                                            @if($goal->habits_count > 0)
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-teal-100 dark:bg-teal-900 text-teal-800 dark:text-teal-200">
                                                    {{ $goal->habits_count }} habit{{ $goal->habits_count !== 1 ? 's' : '' }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>

                                <!-- Actions Menu -->
                                <div class="relative ml-2" x-data="{ open: false }">
                                    <button @click="open = !open" 
                                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                        </svg>
                                    </button>

                                    <div x-show="open" 
                                         @click.away="open = false"
                                         x-transition
                                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                                        <a href="{{ route('goals.show', $goal) }}"
                                           class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                            View Details
                                        </a>
                                        
                                        <button @click="$dispatch('open-modal', 'edit-goal-{{ $goal->id }}'); open = false"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                            Edit
                                        </button>
                                        
                                        @if($goal->challenge_goals_count === 0 && $goal->habits_count === 0)
                                            <form action="{{ route('goals.destroy', $goal) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Delete this goal from your library?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-b-lg">
                                                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        @else
                                            <div class="px-4 py-2 text-xs text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700">
                                                In use - cannot delete
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal for this goal -->
                        <x-modal name="edit-goal-{{ $goal->id }}" :show="false">
                            <div class="p-6">
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Edit Goal</h2>
                                
                                <form action="{{ route('goals.update', $goal) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                Goal Name
                                            </label>
                                            <input type="text" 
                                                   name="name" 
                                                   value="{{ $goal->name }}"
                                                   class="app-input" 
                                                   required>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <x-emoji-picker 
                                                    :id="'edit-goal-icon-' . $goal->id"
                                                    name="icon" 
                                                    :value="$goal->icon"
                                                    label="Icon (emoji)" />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                    Category
                                                </label>
                                                <select name="category_id" class="app-input">
                                                    <option value="">None</option>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ $goal->category_id == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->icon }} {{ $cat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                Description
                                            </label>
                                            <textarea name="description" 
                                                      rows="3" 
                                                      class="app-input">{{ $goal->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="flex justify-end space-x-3 mt-6">
                                        <button type="button" 
                                                @click="$dispatch('close-modal', 'edit-goal-{{ $goal->id }}')"
                                                class="btn-secondary">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn-primary">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </x-modal>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="card text-center py-12">
                    <div class="text-6xl mb-4">📚</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                        @if($search || $categoryId)
                            No goals found
                        @else
                            Your goal library is empty
                        @endif
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        @if($search || $categoryId)
                            Try adjusting your search or filters.
                        @else
                            Create reusable goals to use in your habits and challenges.
                        @endif
                    </p>
                    @if(!$search && !$categoryId)
                        <div class="flex justify-center">
                            <x-app-button variant="primary" @click="$dispatch('open-modal', 'create-goal')">
                                Add Your First Goal
                            </x-app-button>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>

    <!-- Create Goal Modal -->
    <x-modal name="create-goal" :show="$errors->any()">
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Add New Goal</h2>
            
            <form action="{{ route('goals.store') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            Goal Name
                        </label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="app-input" 
                               placeholder="e.g., Exercise, Read, Meditate"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-emoji-picker 
                                id="create-goal-icon"
                                name="icon" 
                                :value="old('icon')"
                                placeholder="🎯"
                                label="Icon (emoji)" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                Category
                            </label>
                            <select name="category_id" class="app-input">
                                <option value="">None</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">
                                        {{ $cat->icon }} {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            Description <span class="text-xs text-gray-500 font-normal">(Optional)</span>
                        </label>
                        <textarea name="description" 
                                  rows="3" 
                                  class="app-input"
                                  placeholder="What is this goal about?">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
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
        </div>
    </x-modal>
</x-app-layout>
