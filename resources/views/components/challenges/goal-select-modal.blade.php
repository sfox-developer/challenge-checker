@props(['goals'])

<!-- Goal Selection Modal -->
<div x-show="showGoalSelectModal" 
     x-cloak
     @keydown.escape.window="showGoalSelectModal && closeGoalSelectModal()"
     class="modal-wrapper">
    
    {{-- Backdrop --}}
    <div x-show="showGoalSelectModal"
         @click="closeGoalSelectModal()"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="modal-backdrop"></div>
    
    {{-- Modal Content --}}
    <div @click.stop 
         x-show="showGoalSelectModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="modal-content max-w-2xl w-full max-h-[85vh] flex flex-col">
            
            {{-- Top Accent Bar --}}
            <div class="modal-accent"></div>
            
            {{-- Close Button --}}
            <button type="button" @click="closeGoalSelectModal()" class="modal-close-button">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            {{-- Modal Header --}}
            <div class="modal-header">
                <div class="modal-eyebrow">Goal Library</div>
                <h3 class="modal-title">Select Goals</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Choose goals that align with your challenge</p>
            </div>
            
            {{-- Goals List (scrollable) --}}
            <div class="modal-body flex-1 overflow-y-auto">
                @if($goals->count() > 0)
                    <div class="space-y-2">
                        @foreach($goals as $goal)
                        <label class="flex items-start p-3 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors border group"
                               :class="isGoalSelected({{ $goal->id }}) ? 'border-slate-500 bg-slate-50 dark:bg-slate-900/50' : 'border-gray-200 dark:border-gray-700'">
                            <input type="checkbox" 
                                   :checked="isGoalSelected({{ $goal->id }})"
                                   @change="toggleGoal({{ $goal->id }})"
                                   class="mt-1 rounded border-gray-300 text-slate-700 focus:ring-slate-500 dark:border-gray-600">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center space-x-2">
                                    @if($goal->icon)
                                        <span class="text-xl">{{ $goal->icon }}</span>
                                    @endif
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $goal->name }}</span>
                                    @if($goal->category)
                                        <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                            {{ $goal->category->name }}
                                        </span>
                                    @endif
                                </div>
                                @if($goal->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $goal->description }}</p>
                                @endif
                            </div>
                        </label>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-4xl mb-3">📚</div>
                        <p class="text-gray-600 dark:text-gray-400">No goals available in the library yet.</p>
                        <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Create a new goal to get started!</p>
                    </div>
                @endif
            </div>
            
            {{-- Modal Footer --}}
            <div class="modal-footer">
                <div class="flex justify-between items-center w-full">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        <span x-text="selectedGoalIds.length"></span>
                        <span x-text="selectedGoalIds.length === 1 ? 'goal' : 'goals'"></span>
                        selected
                    </span>
                    <button @click="closeGoalSelectModal()" 
                            type="button"
                            class="btn-primary">
                        Done
                    </button>
                </div>
            </div>
        </div>
</div>
