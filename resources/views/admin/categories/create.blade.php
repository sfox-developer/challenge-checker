<x-dashboard-layout>
    <x-dashboard.page-header 
        eyebrow="Admin" 
        title="Create Category" 
    />

    <div class="pb-12 md:pb-20">
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
</x-dashboard-layout>
