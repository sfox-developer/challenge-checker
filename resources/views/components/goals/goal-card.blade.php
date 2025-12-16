@props(['goal', 'index', 'categories'])

<a href="{{ route('goals.show', $goal) }}" class="goal-card group animate animate-hidden-fade-up-sm" 
   x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), {{ $index % 6 * 100 }})">
    <div class="goal-card-content">
        <div class="goal-card-link">
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
        </div>

        <!-- Arrow -->
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-gray-400 group-hover:text-slate-600 dark:group-hover:text-slate-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </div>
</a>

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


<!-- Delete Confirmation Modal -->
<x-ui.modal 
    name="delete-goal-{{ $goal->id }}"
    eyebrow="Delete Goal" 
    title="Are you sure?"
    maxWidth="md">
    <div class="space-y-4">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            This goal will be permanently deleted from your library. This action cannot be undone.
        </p>
    </div>

    <div class="modal-footer">
        <button type="button" 
                @click="$dispatch('close-modal', 'delete-goal-{{ $goal->id }}')"
                class="btn-secondary">
            Cancel
        </button>
        <form method="POST" action="{{ route('goals.destroy', $goal) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-primary">
                Delete Goal
            </button>
        </form>
    </div>
</x-ui.modal>