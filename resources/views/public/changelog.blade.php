<x-public-layout>
    <x-slot name="title">Changelog - {{ config('app.name') }}</x-slot>
    
    <div class="section">
        <div class="container max-w-3xl">

            <h1 class="animate animate-hidden-fade-up" 
                x-data="{}" 
                x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">Changelog</h1>
            <p class="subtitle mb-10 animate animate-hidden-fade-up animate-delay-100" 
               x-data="{}" 
               x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">Latest updates and new features</p>

            <div class="changelog-list">
                @forelse($changelogs as $index => $changelog)
                    <article class="changelog-item animate animate-hidden-fade-up" 
                             :class="'animate-delay-' + ({{ $index }} % 3 * 100)" 
                             x-data="{}" 
                             x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                        <header class="changelog-header">
                            <div class="changelog-version">
                                <h2 class="changelog-version-number">
                                    {{ $changelog->version }}
                                </h2>
                                @if($changelog->is_major)
                                    <span class="changelog-badge">
                                        🚀 Major Release
                                    </span>
                                @endif
                            </div>
                            <h3 class="changelog-title">
                                {{ $changelog->title }}
                            </h3>
                            <div class="changelog-date">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span>Released on {{ $changelog->release_date->format('F d, Y') }}</span>
                            </div>
                        </header>

                        @if($changelog->description)
                            <div class="changelog-description">
                                {{ $changelog->description }}
                            </div>
                        @endif

                        <div class="changelog-changes">
                            @foreach(explode("\n", $changelog->changes) as $line)
                                @if(trim($line))
                                    <div class="changelog-change-item">
                                        @if(str_starts_with(trim($line), '-') || str_starts_with(trim($line), '•'))
                                            <span class="bullet">•</span>
                                            <span>{{ trim(ltrim(trim($line), '-•')) }}</span>
                                        @else
                                            <span>{{ $line }}</span>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </article>
                @empty
                    <div class="changelog-empty">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3>No changelogs yet</h3>
                        <p class="text-help">
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
</x-public-layout>
