<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Edit Category" gradient="from-indigo-500 to-purple-500">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                </svg>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Category Name *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', $category->name) }}"
                                   class="app-input" 
                                   required
                                   placeholder="e.g., Health, Fitness">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Current slug: {{ $category->slug }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Icon (emoji)
                                </label>
                                <select name="icon" class="app-input">
                                    <option value="">No icon</option>
                                    <option value="❤️" {{ old('icon', $category->icon) === '❤️' ? 'selected' : '' }}>❤️ Heart</option>
                                    <option value="💪" {{ old('icon', $category->icon) === '💪' ? 'selected' : '' }}>💪 Flexed Biceps</option>
                                    <option value="📚" {{ old('icon', $category->icon) === '📚' ? 'selected' : '' }}>📚 Books</option>
                                    <option value="⚡" {{ old('icon', $category->icon) === '⚡' ? 'selected' : '' }}>⚡ Lightning</option>
                                    <option value="🧘" {{ old('icon', $category->icon) === '🧘' ? 'selected' : '' }}>🧘 Meditation</option>
                                    <option value="👥" {{ old('icon', $category->icon) === '👥' ? 'selected' : '' }}>👥 People</option>
                                    <option value="🎯" {{ old('icon', $category->icon) === '🎯' ? 'selected' : '' }}>🎯 Target</option>
                                    <option value="🏃" {{ old('icon', $category->icon) === '🏃' ? 'selected' : '' }}>🏃 Running</option>
                                    <option value="🍎" {{ old('icon', $category->icon) === '🍎' ? 'selected' : '' }}>🍎 Apple</option>
                                    <option value="💼" {{ old('icon', $category->icon) === '💼' ? 'selected' : '' }}>💼 Briefcase</option>
                                    <option value="🎨" {{ old('icon', $category->icon) === '🎨' ? 'selected' : '' }}>🎨 Art</option>
                                    <option value="🌱" {{ old('icon', $category->icon) === '🌱' ? 'selected' : '' }}>🌱 Seedling</option>
                                    <option value="✨" {{ old('icon', $category->icon) === '✨' ? 'selected' : '' }}>✨ Sparkles</option>
                                    <option value="🔥" {{ old('icon', $category->icon) === '🔥' ? 'selected' : '' }}>🔥 Fire</option>
                                    <option value="🌟" {{ old('icon', $category->icon) === '🌟' ? 'selected' : '' }}>🌟 Star</option>
                                </select>
                                @error('icon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Color
                                </label>
                                <select name="color" class="app-input">
                                    <option value="">Default</option>
                                    <option value="red" {{ old('color', $category->color) === 'red' ? 'selected' : '' }}>Red</option>
                                    <option value="orange" {{ old('color', $category->color) === 'orange' ? 'selected' : '' }}>Orange</option>
                                    <option value="yellow" {{ old('color', $category->color) === 'yellow' ? 'selected' : '' }}>Yellow</option>
                                    <option value="green" {{ old('color', $category->color) === 'green' ? 'selected' : '' }}>Green</option>
                                    <option value="blue" {{ old('color', $category->color) === 'blue' ? 'selected' : '' }}>Blue</option>
                                    <option value="indigo" {{ old('color', $category->color) === 'indigo' ? 'selected' : '' }}>Indigo</option>
                                    <option value="purple" {{ old('color', $category->color) === 'purple' ? 'selected' : '' }}>Purple</option>
                                    <option value="pink" {{ old('color', $category->color) === 'pink' ? 'selected' : '' }}>Pink</option>
                                    <option value="gray" {{ old('color', $category->color) === 'gray' ? 'selected' : '' }}>Gray</option>
                                </select>
                                @error('color')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Order
                            </label>
                            <input type="number" 
                                   name="order" 
                                   value="{{ old('order', $category->order) }}"
                                   min="0"
                                   class="app-input"
                                   placeholder="0">
                            @error('order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea name="description" 
                                      rows="3" 
                                      class="app-input"
                                      placeholder="Brief description of this category">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Active (visible to users)
                            </label>
                        </div>

                        @if($category->goalsLibrary()->count() > 0)
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <p class="text-sm text-blue-800 dark:text-blue-200">
                                    <strong>Note:</strong> This category is currently used by {{ $category->goalsLibrary()->count() }} goal(s).
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
