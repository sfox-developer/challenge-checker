@props(['activity', 'showLikeButton' => true])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200" x-data="{ showLikesModal: false }">
    <div class="p-6">
        <!-- User Info -->
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <img src="{{ $activity->user->getAvatarUrl() }}" alt="{{ $activity->user->name }}" class="h-12 w-12 rounded-full ring-2 ring-white shadow-sm">
                </div>
                <div>
                    <a href="{{ route('users.show', $activity->user) }}" class="font-semibold text-gray-900 hover:text-blue-600">
                        {{ $activity->user->name }}
                    </a>
                    <p class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <div class="{{ $activity->getColorClass() }} p-2 rounded-lg">
                <span class="text-2xl">{!! $activity->getIcon() !!}</span>
            </div>
        </div>

        <!-- Activity Description -->
        <div class="mb-4">
            <p class="text-gray-700">{!! $activity->getDescription() !!}</p>
            @if($activity->challenge)
                <a href="{{ route('challenges.show', $activity->challenge) }}" class="inline-block mt-2 text-sm text-blue-600 hover:text-blue-500 font-medium">
                    View challenge →
                </a>
            @endif
        </div>

        <!-- Activity Actions -->
        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <div class="flex items-center space-x-3">
                @if($showLikeButton)
                    <form action="{{ route('feed.toggleLike', $activity) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center space-x-1 px-3 py-1 rounded-lg transition-colors duration-200 {{ $activity->isLikedBy(auth()->user()) ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 {{ $activity->isLikedBy(auth()->user()) ? 'fill-current' : '' }}" fill="{{ $activity->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span class="text-sm font-medium">{{ $activity->likes_count > 0 ? $activity->likes_count : '' }}</span>
                        </button>
                    </form>
                @else
                    <div class="flex items-center space-x-1 px-3 py-1 rounded-lg bg-gray-50 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="text-sm font-medium">{{ $activity->likes_count > 0 ? $activity->likes_count : '' }}</span>
                    </div>
                @endif
                
                @if($activity->likes_count > 0)
                    <button @click="showLikesModal = true" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-150">
                        {{ $activity->likes_count }} {{ Str::plural('like', $activity->likes_count) }}
                    </button>
                @endif
            </div>
            <span class="text-xs text-gray-400">{{ $activity->created_at->format('M d, Y') }}</span>
        </div>
    </div>

    <!-- Likes Modal -->
    @if($activity->likes_count > 0)
        <div x-show="showLikesModal" 
             x-cloak
             @keydown.escape.window="showLikesModal = false"
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity" @click="showLikesModal = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Liked by {{ $activity->likes_count }} {{ Str::plural('person', $activity->likes_count) }}
                        </h3>
                        <button type="button" @click="showLikesModal = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-150">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @foreach($activity->likes as $like)
                            <a href="{{ route('users.show', $like->user) }}" 
                               @click="showLikesModal = false"
                               class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors duration-150 group">
                                <div class="flex-shrink-0">
                                    <img src="{{ $like->user->getAvatarUrl() }}" 
                                         alt="{{ $like->user->name }}" 
                                         class="h-12 w-12 rounded-full ring-2 ring-gray-200 group-hover:ring-blue-400 transition-all duration-150">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 group-hover:text-blue-600">{{ $like->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $like->user->email }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    <div class="mt-5 sm:mt-6">
                        <button type="button" 
                                @click="showLikesModal = false" 
                                class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm transition-colors duration-150">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
