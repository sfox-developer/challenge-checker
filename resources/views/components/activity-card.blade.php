@props(['activity', 'showLikeButton' => true])

<div class="card card-hover" 
     x-data="activityCard({{ $activity->isLikedBy(auth()->user()) ? 'true' : 'false' }}, {{ $activity->likes_count }}, {{ $activity->id }}, '{{ route('feed.toggleLike', $activity) }}')">
    <!-- User Info -->
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <img src="{{ $activity->user->getAvatarUrl() }}" alt="{{ $activity->user->name }}" class="h-12 w-12 rounded-full ring-2 ring-white dark:ring-gray-700 shadow-sm">
            </div>
            <div>
                <a href="{{ route('users.show', $activity->user) }}" class="font-semibold text-gray-800 dark:text-gray-100 dark:text-gray-100 hover:text-slate-700 dark:hover:text-slate-400">
                    {{ $activity->user->name }}
                </a>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <div class="{{ $activity->getColorClass() }} p-2 rounded-lg">
            <span class="text-2xl">{!! $activity->getIcon() !!}</span>
        </div>
    </div>

    <!-- Activity Description -->
    <div class="mb-4">
        <p class="text-gray-700 dark:text-gray-100">{!! $activity->getDescription() !!}</p>
        @if($activity->challenge)
            <a href="{{ route('challenges.show', $activity->challenge) }}" class="inline-block mt-2 text-sm text-slate-700 dark:text-slate-400 hover:text-slate-600 dark:hover:text-blue-300 font-medium">
                View challenge →
            </a>
        @endif
    </div>

    <!-- Activity Actions -->
    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
        <div class="flex items-center space-x-3">
            @if($showLikeButton)
                <button @click="toggleLike()" 
                        :disabled="isLiking"
                        :class="liked ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30' : 'bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600'"
                        class="flex items-center space-x-1 px-3 py-1 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5 transition-all duration-200" 
                            :class="liked ? 'fill-current' : ''" 
                            :fill="liked ? 'currentColor' : 'none'" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span class="text-sm font-medium" x-text="likesCount > 0 ? likesCount : ''"></span>
                </button>
            @else
                <div class="flex items-center space-x-1 px-3 py-1 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span class="text-sm font-medium" x-text="likesCount > 0 ? likesCount : ''"></span>
                </div>
            @endif
            
            <button @click="openLikesModal()" 
                    x-show="likesCount > 0"
                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-slate-700 dark:hover:text-slate-400 transition-colors duration-150">
                <span x-text="likesCount + ' ' + (likesCount === 1 ? 'like' : 'likes')"></span>
            </button>
        </div>
        <span class="text-xs text-gray-400 dark:text-gray-500">{{ $activity->created_at->format('M d, Y') }}</span>
    </div>

    <!-- Likes Modal -->
    <div x-show="showLikesModal" 
         x-cloak
         @keydown.escape.window="closeLikesModal()"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" @click="closeLikesModal()">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
            </div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="h3">
                        <span x-text="'Liked by ' + likesCount + ' ' + (likesCount === 1 ? 'person' : 'people')"></span>
                    </h3>
                        <button type="button" @click="closeLikesModal()" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 transition-colors duration-150">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        <!-- Loading state -->
                        <div x-show="loadingLikes" class="text-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-slate-700 mx-auto mb-3"></div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Loading likes...</p>
                        </div>

                        <!-- Likes list -->
                        <template x-for="like in likes" :key="like.id">
                            <a :href="like.user.profile_url" 
                               @click="closeLikesModal()"
                               class="flex items-start space-x-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-150 group">
                                <div class="flex-shrink-0">
                                    <img :src="like.user.avatar_url" 
                                         :alt="like.user.name" 
                                         class="h-12 w-12 rounded-full ring-2 ring-gray-200 dark:ring-gray-700 group-hover:ring-blue-400 transition-all duration-150">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-800 dark:text-gray-100 group-hover:text-slate-700 dark:group-hover:text-slate-400" x-text="like.user.name"></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="like.user.email"></p>
                                </div>
                            </a>
                        </template>

                        <!-- Empty state -->
                        <div x-show="!loadingLikes && likes.length === 0" class="text-center py-8">
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                <p class="text-sm">No likes yet</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-5 sm:mt-6">
                        <button type="button" 
                                @click="closeLikesModal()" 
                                class="w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 sm:text-sm transition-colors duration-150">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
</div>
