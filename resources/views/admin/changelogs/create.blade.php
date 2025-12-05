<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Create Changelog" gradient="from-indigo-500 to-purple-500">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg">
                    <h3 class="font-semibold mb-2">Please fix the following errors:</h3>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <form action="{{ route('admin.changelogs.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Version *
                                </label>
                                <input type="text" 
                                       name="version" 
                                       value="{{ old('version') }}"
                                       class="app-input" 
                                       required
                                       placeholder="e.g., v1.2.0">
                                @error('version')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Release Date *
                                </label>
                                <input type="date" 
                                       name="release_date" 
                                       value="{{ old('release_date', now()->format('Y-m-d')) }}"
                                       class="app-input" 
                                       required>
                                @error('release_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Title *
                            </label>
                            <input type="text" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   class="app-input" 
                                   required
                                   placeholder="e.g., New Features and Bug Fixes">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea name="description" 
                                      rows="2" 
                                      class="app-input"
                                      placeholder="Brief summary of this release">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Changes *
                            </label>
                            <textarea name="changes" 
                                      rows="8" 
                                      class="app-input font-mono text-sm"
                                      required
                                      placeholder="List changes here, one per line:&#10;- Added new feature X&#10;- Fixed bug Y&#10;- Improved performance of Z">{{ old('changes') }}</textarea>
                            @error('changes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Use markdown syntax for formatting. Each change should start with a dash (-) or bullet point.</p>
                        </div>

                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_published" 
                                       id="is_published"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                       {{ old('is_published') ? 'checked' : '' }}>
                                <label for="is_published" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Publish immediately
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_major" 
                                       id="is_major"
                                       class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                       {{ old('is_major') ? 'checked' : '' }}>
                                <label for="is_major" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Major release
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <x-app-button variant="secondary" :href="route('admin.changelogs.index')">
                            Cancel
                        </x-app-button>
                        <x-app-button variant="primary" type="submit">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Create Changelog
                        </x-app-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
