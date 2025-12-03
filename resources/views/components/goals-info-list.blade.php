@props(['goals'])

@if($goals->isNotEmpty())
    <div class="space-y-3">
        @foreach($goals as $index => $goal)
            <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <!-- Number Badge -->
                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                    {{ $index + 1 }}
                </div>
                
                <!-- Goal Content -->
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-gray-900 dark:text-white">
                        @if($goal->icon)
                            <span class="mr-2">{{ $goal->icon }}</span>
                        @endif
                        {{ $goal->name }}
                    </h4>
                    
                    @if($goal->description)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
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
