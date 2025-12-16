@props(['goal', 'index', 'categories'])

<div class="goal-card animate animate-hidden-fade-up-sm" 
     x-data="{ showMenu: false }"
     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), {{ $index % 6 * 100 }})">
    <div class="goal-card-content">
        <a href="{{ route('goals.show', $goal) }}" class="goal-card-link">
            <div class="goal-card-icon">{{ $goal->icon ?? '🎯' }}</div>
            <div class="goal-card-body">
                <h3 class="goal-card-title">
                    {{ $goal->name }}
                </h3>
                
                @if($goal->description)
                    <p class="goal-card-description">
                        {{ Str::limit($goal->description, 100) }}
                    </p>
                @endif

                <div class="goal-card-badges">
                    @if($goal->category)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">
                            {{ $goal->category->icon }} {{ $goal->category->name }}
                        </span>
                    @endif

                    @if($goal->challenge_goals_count > 0)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                            {{ $goal->challenge_goals_count }} challenge{{ $goal->challenge_goals_count !== 1 ? 's' : '' }}
                        </span>
                    @endif

                    @if($goal->habits_count > 0)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                            {{ $goal->habits_count }} habit{{ $goal->habits_count !== 1 ? 's' : '' }}
                        </span>
                    @endif
                </div>
            </div>
        </a>

        <!-- Actions Menu -->
        <div class="goal-card-menu" x-data="{ open: false }">
            <button @click="open = !open" class="goal-card-menu-btn">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                </svg>
            </button>

            <div x-show="open" 
                 @click.away="open = false"
                 x-transition
                 class="goal-card-dropdown">
                <a href="{{ route('goals.show', $goal) }}" class="goal-card-dropdown-item">
                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    View Details
                </a>
                
                <button @click="$dispatch('open-modal', 'edit-goal-{{ $goal->id }}'); open = false"
                        class="goal-card-dropdown-item">
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
                        <button type="submit" class="goal-card-dropdown-item goal-card-dropdown-item-danger">
                            <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                @else
                    <div class="goal-card-dropdown-disabled">
                        In use - cannot delete
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<x-ui.modal 
    name="edit-goal-{{ $goal->id }}"
    eyebrow="Your Collection" 
    title="Edit Goal"
    maxWidth="lg">
    <form action="{{ route('goals.update', $goal) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <x-forms.form-input
                name="name"
                label="Goal Name"
                :value="$goal->name"
                required />

            <div class="grid grid-cols-2 gap-3">
                <x-forms.emoji-picker 
                    :id="'edit-goal-icon-' . $goal->id"
                    name="icon" 
                    :value="$goal->icon"
                    label="Icon (emoji)" />
                
                <x-forms.form-select
                    name="category_id"
                    label="Category"
                    :value="$goal->category_id"
                    placeholder="None">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $goal->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                    @endforeach
                </x-forms.form-select>
            </div>

            <x-forms.form-textarea
                name="description"
                label="Description"
                :value="$goal->description"
                rows="3" />
        </div>

        <div class="modal-footer">
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
</x-ui.modal>
