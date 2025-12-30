<x-dashboard-layout>
    <x-slot name="title">Goal Display Variants - Step 3</x-slot>

    <div class="section">
        <div class="container max-w-6xl">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Goal Display Design Variants</h1>
                <p class="text-gray-600 dark:text-gray-400">Compare different ways to display selected and new goals in Step 3</p>
            </div>

            <!-- Sample Data -->
            <div x-data="{
                sampleLibraryGoals: [
                    { id: 1, name: 'Read 30 Books', icon: '📚', category: 'Personal Growth' },
                    { id: 2, name: 'Run a Marathon', icon: '🏃', category: 'Fitness' },
                    { id: 3, name: 'Learn Spanish', icon: '🇪🇸', category: 'Education' }
                ],
                sampleNewGoals: [
                    { name: 'Master TypeScript', icon: '💻', description: 'Complete advanced TypeScript course' },
                    { name: 'Drink 2L Water Daily', icon: '💧', description: null }
                ]
            }">

                <!-- Current Design (for reference) -->
                <div class="card mb-8">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Current Design</h2>
                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400 text-sm font-semibold rounded-full">Reference</span>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">From Library:</h4>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="goal in sampleLibraryGoals" :key="goal.id">
                                    <div class="inline-flex items-center space-x-2 px-3 py-2 bg-slate-100 dark:bg-slate-800 rounded-lg border border-slate-300 dark:border-slate-600">
                                        <span class="text-lg" x-text="goal.icon"></span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="goal.name"></span>
                                        <button type="button" class="text-gray-500 hover:text-red-600 dark:hover:text-red-400">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">New Goals:</h4>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="(goal, index) in sampleNewGoals" :key="index">
                                    <div class="inline-flex items-center space-x-2 px-3 py-2 bg-green-100 dark:bg-green-900/30 rounded-lg border border-green-300 dark:border-green-600">
                                        <span class="text-lg" x-text="goal.icon"></span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="goal.name"></span>
                                        <button type="button" class="text-gray-500 hover:text-red-600 dark:hover:text-red-400">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Issues:</strong> Basic pill/badge design, lacks visual hierarchy, no preview of goal details</p>
                    </div>
                </div>

                <!-- Option 1: Card-Style with Accent Bar (matching modal design) -->
                <div class="card mb-8">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Option 1: Card-Style with Accent Bar</h2>
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-sm font-semibold rounded-full">Recommended</span>
                    </div>

                    <div class="space-y-4">
                        <!-- Library Goals -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                                From Library
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <template x-for="goal in sampleLibraryGoals" :key="goal.id">
                                    <div class="goal-display-card">
                                        <div class="goal-display-accent-bar"></div>
                                        <div class="p-4">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="flex items-start gap-3 flex-1 min-w-0">
                                                    <div class="text-3xl flex-shrink-0" x-text="goal.icon"></div>
                                                    <div class="flex-1 min-w-0">
                                                        <h5 class="font-semibold text-gray-900 dark:text-white truncate" x-text="goal.name"></h5>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="goal.category"></p>
                                                    </div>
                                                </div>
                                                <button type="button" class="flex-shrink-0 p-1 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- New Goals -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                                New Goals
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <template x-for="(goal, index) in sampleNewGoals" :key="index">
                                    <div class="goal-display-card">
                                        <div class="goal-display-accent-bar"></div>
                                        <div class="p-4">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="flex items-start gap-3 flex-1 min-w-0">
                                                    <div class="text-3xl flex-shrink-0" x-text="goal.icon"></div>
                                                    <div class="flex-1 min-w-0">
                                                        <h5 class="font-semibold text-gray-900 dark:text-white truncate" x-text="goal.name"></h5>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-show="goal.description" x-text="goal.description"></p>
                                                    </div>
                                                </div>
                                                <button type="button" class="flex-shrink-0 p-1 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Features:</strong> Card design matching modal system, accent gradient bar, better hierarchy, shows category/description, grid layout for better organization</p>
                    </div>
                </div>

                <!-- Option 2: Compact List with Icons -->
                <div class="card mb-8">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Option 2: Compact List with Icons</h2>
                    </div>

                    <div class="space-y-4">
                        <!-- Combined List -->
                        <div class="space-y-2">
                            <!-- Library Goals -->
                            <template x-for="goal in sampleLibraryGoals" :key="goal.id">
                                <div class="flex items-center gap-3 p-3 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 transition-all group">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30" x-text="goal.icon"></div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2">
                                                <h5 class="font-semibold text-gray-900 dark:text-white truncate" x-text="goal.name"></h5>
                                                <span class="flex-shrink-0 text-xs px-2 py-0.5 rounded bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">Library</span>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="goal.category"></p>
                                        </div>
                                    </div>
                                    <button type="button" class="flex-shrink-0 p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <!-- New Goals -->
                            <template x-for="(goal, index) in sampleNewGoals" :key="'new-' + index">
                                <div class="flex items-center gap-3 p-3 rounded-lg bg-white dark:bg-gray-800 border border-green-200 dark:border-green-800 hover:border-green-300 dark:hover:border-green-700 transition-all group">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30" x-text="goal.icon"></div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2">
                                                <h5 class="font-semibold text-gray-900 dark:text-white truncate" x-text="goal.name"></h5>
                                                <span class="flex-shrink-0 text-xs px-2 py-0.5 rounded bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400">New</span>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400" x-show="goal.description" x-text="goal.description"></p>
                                        </div>
                                    </div>
                                    <button type="button" class="flex-shrink-0 p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Features:</strong> Space-efficient list design, gradient icon backgrounds, hover-reveal remove button, unified view of all goals</p>
                    </div>
                </div>

                <!-- Option 3: Enhanced Pills with More Detail -->
                <div class="card mb-8">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Option 3: Enhanced Pills with More Detail</h2>
                    </div>

                    <div class="space-y-4">
                        <!-- Library Goals -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">From Library</h4>
                            <div class="flex flex-wrap gap-3">
                                <template x-for="goal in sampleLibraryGoals" :key="goal.id">
                                    <div class="group relative">
                                        <div class="flex items-center gap-2 pl-3 pr-10 py-2.5 rounded-xl bg-white dark:bg-gray-800 border-2 border-blue-200 dark:border-blue-800 shadow-sm hover:shadow transition-all">
                                            <span class="text-xl" x-text="goal.icon"></span>
                                            <div>
                                                <div class="font-semibold text-sm text-gray-900 dark:text-white" x-text="goal.name"></div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400" x-text="goal.category"></div>
                                            </div>
                                        </div>
                                        <button type="button" class="absolute top-1/2 -translate-y-1/2 right-2 p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- New Goals -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">New Goals</h4>
                            <div class="flex flex-wrap gap-3">
                                <template x-for="(goal, index) in sampleNewGoals" :key="index">
                                    <div class="group relative">
                                        <div class="flex items-center gap-2 pl-3 pr-10 py-2.5 rounded-xl bg-white dark:bg-gray-800 border-2 border-green-200 dark:border-green-800 shadow-sm hover:shadow transition-all">
                                            <span class="text-xl" x-text="goal.icon"></span>
                                            <div>
                                                <div class="font-semibold text-sm text-gray-900 dark:text-white" x-text="goal.name"></div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400" x-show="goal.description" x-text="goal.description ? (goal.description.length > 30 ? goal.description.substring(0, 30) + '...' : goal.description) : ''"></div>
                                            </div>
                                        </div>
                                        <button type="button" class="absolute top-1/2 -translate-y-1/2 right-2 p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Features:</strong> Improved pill design with two-line content, larger icons, better borders, still maintains compact flow</p>
                    </div>
                </div>

                <!-- Option 4: Minimal Tags with Tooltip Preview -->
                <div class="card mb-8">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Option 4: Minimal Tags with Tooltip Preview</h2>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <!-- Library Goals -->
                        <template x-for="goal in sampleLibraryGoals" :key="goal.id">
                            <div class="relative group">
                                <div class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 border border-blue-200 dark:border-blue-800 hover:shadow-md transition-all cursor-pointer">
                                    <span class="text-base" x-text="goal.icon"></span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="goal.name"></span>
                                    <button type="button" class="ml-1 text-gray-400 hover:text-red-600 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Tooltip (shown on hover) -->
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 dark:bg-gray-700 text-white text-xs rounded-lg shadow-lg opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity whitespace-nowrap z-10">
                                    <div class="font-semibold" x-text="'📚 ' + goal.name"></div>
                                    <div class="text-gray-300" x-text="goal.category"></div>
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-900 dark:bg-gray-700 rotate-45 -mt-1"></div>
                                </div>
                            </div>
                        </template>

                        <!-- New Goals -->
                        <template x-for="(goal, index) in sampleNewGoals" :key="'new-' + index">
                            <div class="relative group">
                                <div class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 border border-green-200 dark:border-green-800 hover:shadow-md transition-all cursor-pointer">
                                    <span class="text-base" x-text="goal.icon"></span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="goal.name"></span>
                                    <span class="px-1.5 py-0.5 text-xs font-semibold rounded bg-green-600 text-white">NEW</span>
                                    <button type="button" class="ml-1 text-gray-400 hover:text-red-600 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Tooltip -->
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 dark:bg-gray-700 text-white text-xs rounded-lg shadow-lg opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity whitespace-nowrap z-10">
                                    <div class="font-semibold" x-text="goal.icon + ' ' + goal.name"></div>
                                    <div class="text-gray-300" x-show="goal.description" x-text="goal.description"></div>
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-900 dark:bg-gray-700 rotate-45 -mt-1"></div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Features:</strong> Most compact design, gradient backgrounds, hover tooltips for details, clean unified flow</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-dashboard-layout>
