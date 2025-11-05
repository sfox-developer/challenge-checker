@props(['challenge', 'goals', 'compact' => false, 'showTodaysGoals' => false, 'isOwner' => true])

@php
    $pendingGoals = collect();
    $completedGoals = collect();
    
    // Use challenge owner's ID for checking completion status
    $checkUserId = $challenge->user_id;
    
    foreach($goals as $goal) {
        $isCompleted = $goal->isCompletedForDate(today()->toDateString(), $checkUserId);
        
        if ($isCompleted) {
            $completedGoals->push($goal);
        } else {
            $pendingGoals->push($goal);
        }
    }
    
    $canToggle = $isOwner && $challenge->started_at && !$challenge->completed_at && $challenge->is_active;
@endphp

@if($goals->isNotEmpty())
    <div class="todo-container">
        <!-- Always show header with icon - same style for both views -->
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center space-x-3">
            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
            </svg>
            <span>{{ $showTodaysGoals ? "Today's Goals" : 'Goals' }}</span>
        </h3>
        
        <!-- Pending Goals -->
        <div class="todo-section pending-goals">
            @foreach($pendingGoals as $goal)
                <div class="todo-item {{ $canToggle ? 'interactive' : '' }}"
                     data-goal-id="{{ $goal->id }}"
                     @if($canToggle) onclick="toggleGoalInstant({{ $goal->id }})" @endif>
                    
                    <!-- Checkbox -->
                    <div class="todo-checkbox {{ $canToggle ? '' : 'disabled' }}">
                        <!-- Empty for unchecked -->
                    </div>
                    
                    <!-- Content -->
                    <div class="todo-content">
                        <div class="todo-title text-lg font-bold">
                            {{ $goal->name }}
                        </div>
                        @if($goal->description)
                            <div class="todo-description">{{ $goal->description }}</div>
                        @endif
                    </div>
                    
                    <!-- Status -->
                    <div class="todo-status">
                        @if($challenge->started_at && !$challenge->completed_at)
                            @if(!$challenge->is_active)
                                <div class="status-badge paused">⏸️ Paused</div>
                            @else
                                <div class="status-badge pending">Pending</div>
                            @endif
                        @elseif($challenge->completed_at)
                            <div class="status-badge completed">Challenge Complete</div>
                        @elseif(!$challenge->started_at)
                            <div class="status-badge paused">Not Started</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Completed Goals -->
        @if($completedGoals->isNotEmpty())
            <div class="todo-section completed-section">
                <div class="section-header">
                    <span>Completed Today</span>
                    <span class="count">{{ $completedGoals->count() }}</span>
                </div>
                
                <div class="completed-goals">
                    @foreach($completedGoals as $goal)
                        <div class="todo-item completed {{ $canToggle ? 'interactive' : '' }}"
                             data-goal-id="{{ $goal->id }}"
                             @if($canToggle) onclick="toggleGoalInstant({{ $goal->id }})" @endif>
                            
                            <!-- Checkbox -->
                            <div class="todo-checkbox checked {{ $canToggle ? '' : 'disabled' }}">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            
                            <!-- Content -->
                            <div class="todo-content">
                                <div class="todo-title text-lg font-bold">
                                    {{ $goal->name }}
                                </div>
                                @if($goal->description)
                                    <div class="todo-description">{{ $goal->description }}</div>
                                @endif
                            </div>
                            
                            <!-- Status -->
                            <div class="todo-status">
                                <div class="status-badge completed">✓ Done</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endif