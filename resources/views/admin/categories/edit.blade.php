<x-app-layout>
    <x-slot name="header">
        <x-ui.page-header title="Edit Category">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                </svg>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <x-forms.form-input
                        name="name"
                        label="Category Name *"
                        :value="$category->name"
                        placeholder="e.g., Health, Fitness"
                        hint="Current slug: {{ $category->slug }}"
                        required />

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <x-forms.emoji-picker 
                            id="category-icon-edit"
                            name="icon" 
                            :value="old('icon', $category->icon)"
                            label="Icon (emoji)" />
                        
                        <x-forms.form-select
                            name="color"
                            label="Color"
                            :value="$category->color"
                            placeholder="Default">
                            <option value="red" {{ old('color', $category->color) === 'red' ? 'selected' : '' }}>Red</option>
                            <option value="orange" {{ old('color', $category->color) === 'orange' ? 'selected' : '' }}>Orange</option>
                            <option value="yellow" {{ old('color', $category->color) === 'yellow' ? 'selected' : '' }}>Yellow</option>
                            <option value="green" {{ old('color', $category->color) === 'green' ? 'selected' : '' }}>Green</option>
                            <option value="blue" {{ old('color', $category->color) === 'blue' ? 'selected' : '' }}>Blue</option>
                            <option value="indigo" {{ old('color', $category->color) === 'indigo' ? 'selected' : '' }}>Indigo</option>
                            <option value="purple" {{ old('color', $category->color) === 'purple' ? 'selected' : '' }}>Purple</option>
                            <option value="pink" {{ old('color', $category->color) === 'pink' ? 'selected' : '' }}>Pink</option>
                            <option value="gray" {{ old('color', $category->color) === 'gray' ? 'selected' : '' }}>Gray</option>
                        </x-forms.form-select>
                    </div>

                    <x-forms.form-input
                        name="order"
                        type="number"
                        label="Order"
                        :value="$category->order"
                        min="0"
                        placeholder="0"
                        hint="Lower numbers appear first" />

                    <x-forms.form-textarea
                        name="description"
                        label="Description"
                        :value="$category->description"
                        placeholder="Brief description of this category"
                        rows="3" />

                    <x-forms.form-checkbox
                        name="is_active"
                        label="Active (visible to users)"
                        :checked="$category->is_active" />

                    @if($category->goalsLibrary()->count() > 0)
                        <div class="info-box info-box-primary">
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                <strong>Note:</strong> This category is currently used by {{ $category->goalsLibrary()->count() }} goal(s).
                            </p>
                        </div>
                    @endif

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
