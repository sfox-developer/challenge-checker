<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Edit Changelog" gradient="primary">
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
                <form action="{{ route('admin.changelogs.update', $changelog) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <x-form-input
                            name="version"
                            label="Version *"
                            :value="$changelog->version"
                            placeholder="e.g., v1.2.0"
                            required />

                        <x-form-input
                            name="release_date"
                            type="date"
                            label="Release Date *"
                            :value="$changelog->release_date->format('Y-m-d')"
                            required />
                    </div>

                    <x-form-input
                        name="title"
                        label="Title *"
                        :value="$changelog->title"
                        placeholder="e.g., New Features and Bug Fixes"
                        required />

                    <x-form-textarea
                        name="description"
                        label="Description"
                        :value="$changelog->description"
                        placeholder="Brief summary of this release"
                        rows="2"
                        optional />

                    <x-form-textarea
                        name="changes"
                        label="Changes *"
                        :value="$changelog->changes"
                        placeholder="List changes here, one per line:&#10;- Added new feature X&#10;- Fixed bug Y&#10;- Improved performance of Z"
                        hint="Use markdown syntax for formatting. Each change should start with a dash (-) or bullet point."
                        rows="8"
                        required
                        class="font-mono text-sm" />

                    <div class="flex items-center space-x-6 mb-6">
                        <x-form-checkbox
                            name="is_published"
                            label="Publish"
                            :checked="$changelog->is_published"
                            class="mb-0" />

                        <x-form-checkbox
                            name="is_major"
                            label="Major release"
                            :checked="$changelog->is_major"
                            class="mb-0" />
                    </div>

                    <x-form-actions
                        :cancelRoute="route('admin.changelogs.index')"
                        submitText="Update Changelog"
                        class="mt-8" />
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
