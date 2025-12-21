<x-dashboard-layout>
    <x-slot name="title">Profile Settings</x-slot>

    <x-dashboard.page-header 
        eyebrow="Settings"
        title="Profile"
        description="Manage your account settings and preferences" />

    <div class="section">
        <div class="container max-w-4xl">
            <div class="space-y-6">
            <div class="card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('dashboard.profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('dashboard.profile.partials.update-password-form')
                </div>
            </div>

            <div class="card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('dashboard.profile.partials.delete-user-form')
                </div>
            </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
