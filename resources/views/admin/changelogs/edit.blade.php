<x-dashboard-layout>
    <x-dashboard.page-header 
        eyebrow="Admin" 
        title="Edit Changelog" 
    />

    <div class="pb-12 md:pb-20">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg">
                    <h3 class="font-semibold mb-2">Please fix the following errors:</h3>
                    <ul class="list-styled-compact">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <form action="{{ route('admin.changelogs.update', $changelog) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <x-forms.form-input
                            name="version"
                            label="Version *"
                            :value="$changelog->version"
                            placeholder="e.g., v1.2.0"
                            required />

                        <x-forms.form-input
                            name="release_date"
                            type="date"
                            label="Release Date *"
                            :value="$changelog->release_date->format('Y-m-d')"
                            required />
                    </div>

                    <x-forms.form-input
                        name="title"
                        label="Title *"
                        :value="$changelog->title"
                        placeholder="e.g., New Features and Bug Fixes"
                        required />

                    <x-forms.form-textarea
                        name="description"
                        label="Description"
                        :value="$changelog->description"
                        placeholder="Brief summary of this release"
                        rows="2"
                        optional />

                    <x-forms.form-textarea
                        name="changes"
                        label="Changes *"
                        :value="$changelog->changes"
                        placeholder="List changes here, one per line:&#10;- Added new feature X&#10;- Fixed bug Y&#10;- Improved performance of Z"
                        hint="Use markdown syntax for formatting. Each change should start with a dash (-) or bullet point."
                        rows="8"
                        required
                        class="font-mono text-sm" />

                    <div class="flex items-center space-x-6 mb-6">
                        <x-forms.form-checkbox
                            name="is_published"
                            label="Publish"
                            :checked="$changelog->is_published"
                            class="mb-0" />

                        <x-forms.form-checkbox
                            name="is_major"
                            label="Major release"
                            :checked="$changelog->is_major"
                            class="mb-0" />
                    </div>

                    <x-forms.form-actions
                        :cancelRoute="route('admin.changelogs.index')"
                        submitText="Update Changelog"
                        class="mt-8" />
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
