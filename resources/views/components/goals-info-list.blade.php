@props(['goals'])

@if($goals->isNotEmpty())
    <div class="space-y-3">
        @foreach($goals as $index => $goal)
            <div class="goal-info-item">
                <!-- Number Badge -->
                <div class="numbered-badge">
                    {{ $index + 1 }}
                </div>
                
                <!-- Goal Content -->
                <div class="goal-info-content">
                    <h4 class="goal-info-title">
                        @if($goal->icon)
                            <span class="mr-2">{{ $goal->icon }}</span>
                        @endif
                        {{ $goal->name }}
                    </h4>
                    
                    @if($goal->description)
                        <p class="goal-info-description">
                            {{ $goal->description }}
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-sm">No goals defined for this challenge</p>
    </div>
@endif
