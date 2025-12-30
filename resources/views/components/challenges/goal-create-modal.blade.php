@props(['categories' => []])

<!-- Goal Creation Modal -->
<div x-show="showGoalCreateModal" 
     x-cloak
     @keydown.escape.window="showGoalCreateModal && closeGoalCreateModal()"
     class="modal-wrapper">
    
    {{-- Backdrop --}}
    <div x-show="showGoalCreateModal"
         @click="closeGoalCreateModal()"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="modal-backdrop"></div>
    
    {{-- Modal Content --}}
    <div @click.stop 
         x-show="showGoalCreateModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="modal-content max-w-lg w-full">
            
            {{-- Top Accent Bar --}}
            <div class="modal-accent"></div>
            
            {{-- Close Button --}}
            <button type="button" @click="closeGoalCreateModal()" class="modal-close-button">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            {{-- Modal Header --}}
            <div class="modal-header">
                <div class="modal-eyebrow">New Goal</div>
                <h3 class="modal-title">Create Goal</h3>
                <p class="modal-description">Add a custom goal for this challenge</p>
            </div>
            
            {{-- Form --}}
            <div class="modal-body space-y-4">
                <!-- Goal Name -->
                <div>
                    <label class="form-label">Goal Name <span class="text-red-500">*</span></label>
                    <input type="text" 
                           x-model="newGoal.name"
                           @keydown.enter="newGoal.name.trim() && addNewGoalToList()"
                           class="form-input" 
                           placeholder="e.g., Exercise daily"
                           maxlength="100"
                           required>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Give your goal a clear, descriptive name</p>
                </div>
                
                <!-- Icon & Category Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Icon -->
                    <div>
                        <x-forms.emoji-picker 
                            label="Icon"
                            :value="''"
                            placeholder="🎯"
                            ::value="newGoal.icon"
                            @input="newGoal.icon = $event.target.value" />
                    </div>
                    
                    <!-- Category -->
                    <div>
                        <label class="form-label">Category <span class="text-optional">(Optional)</span></label>
                        <select x-model="newGoal.category_id" class="form-input">
                            <option value="">None</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Description -->
                <div>
                    <label class="form-label">Description <span class="text-optional">(Optional)</span></label>
                    <textarea x-model="newGoal.description"
                              rows="3" 
                              class="form-input" 
                              placeholder="What does this goal involve?"
                              maxlength="500"></textarea>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <span x-text="newGoal.description.length"></span>/500 characters
                    </p>
                </div>
            </div>
            
            {{-- Modal Footer --}}
            <div class="modal-footer">
                <button @click="closeGoalCreateModal()" 
                        type="button"
                        class="btn-secondary">
                    Cancel
                </button>
                <button @click="addNewGoalToList()" 
                        type="button"
                        class="btn-primary"
                        :disabled="!newGoal.name.trim()"
                        :class="!newGoal.name.trim() ? 'opacity-50 cursor-not-allowed' : ''">
                    Add Goal
                </button>
            </div>
        </div>
</div>
