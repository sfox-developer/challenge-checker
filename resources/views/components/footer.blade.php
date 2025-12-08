<footer class="app-footer">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
            <div class="text-center sm:text-left">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </div>
            
            <div class="flex items-center space-x-6 text-sm">
                <a href="{{ route('changelog') }}" class="text-gray-600 dark:text-gray-400 hover:text-slate-700 dark:hover:text-slate-400 transition-colors">
                    Changelog
                </a>
                <a href="{{ route('privacy.policy') }}" class="text-gray-600 dark:text-gray-400 hover:text-slate-700 dark:hover:text-slate-400 transition-colors">
                    Privacy Policy
                </a>
                <a href="{{ route('terms.service') }}" class="text-gray-600 dark:text-gray-400 hover:text-slate-700 dark:hover:text-slate-400 transition-colors">
                    Terms of Service
                </a>
            </div>
        </div>
    </div>
</footer>
