<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Changelog">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse($changelogs as $changelog)
                    <div class="card hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $changelog->version }}
                                    </h2>
                                    @if($changelog->is_major)
                                        <span class="badge-accent">
                                            🚀 Major Release
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                    {{ $changelog->title }}
                                </h3>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    Released on {{ $changelog->release_date->format('F d, Y') }}
                                </div>
                            </div>
                        </div>

                        @if($changelog->description)
                            <div class="info-box info-box-primary info-box-bordered">
                                <p class="text-gray-700 dark:text-gray-300 italic">
                                    {{ $changelog->description }}
                                </p>
                            </div>
                        @endif

                        <div class="prose dark:prose-invert max-w-none">
                            <div class="text-gray-700 dark:text-gray-300 space-y-1 leading-relaxed">
                                @foreach(explode("\n", $changelog->changes) as $line)
                                    @if(trim($line))
                                        <div class="flex items-start">
                                            @if(str_starts_with(trim($line), '-') || str_starts_with(trim($line), '•'))
                                                <span class="text-slate-600 dark:text-slate-400 mr-2 mt-1">•</span>
                                                <span>{{ trim(ltrim(trim($line), '-•')) }}</span>
                                            @else
                                                <span>{{ $line }}</span>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card text-center py-16">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100 mb-2">No changelogs yet</h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            Check back later for updates and new features!
                        </p>
                    </div>
                @endforelse

                @if($changelogs->hasPages())
                    <div class="mt-8">
                        {{ $changelogs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
