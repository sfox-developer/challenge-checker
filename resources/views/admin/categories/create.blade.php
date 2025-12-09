<x-app-layout>
    <x-slot name="header">
        <x-ui.page-header title="Create Category">
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
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <x-forms.form-input
                        name="name"
                        label="Category Name *"
                        placeholder="e.g., Health, Fitness"
                        hint="Slug will be auto-generated from name"
                        required />

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <x-forms.emoji-picker 
                            id="category-icon"
                            name="icon" 
                            :value="old('icon')"
                            label="Icon (emoji)" />
                        
                        <x-forms.form-select
                            name="color"
                            label="Color"
                            placeholder="Default">
                            <option value="red">Red</option>
                            <option value="orange">Orange</option>
                            <option value="yellow">Yellow</option>
                            <option value="green">Green</option>
                            <option value="blue">Blue</option>
                            <option value="indigo">Indigo</option>
                            <option value="purple">Purple</option>
                            <option value="pink">Pink</option>
                            <option value="gray">Gray</option>
                        </x-forms.form-select>
                    </div>

                    <x-forms.form-input
                        name="order"
                        type="number"
                        label="Order"
                        :value="0"
                        min="0"
                        placeholder="0"
                        hint="Lower numbers appear first" />

                    <x-forms.form-textarea
                        name="description"
                        label="Description"
                        placeholder="Brief description of this category"
                        rows="3" />

                    <x-forms.form-checkbox
                        name="is_active"
                        label="Active (visible to users)"
                        :checked="true" />

                    <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
