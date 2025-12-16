<div class="section section-bg-light">
    <div class="container max-w-4xl">
        <div class="section-header animate animate-hidden-fade-up"
             x-data="{}"
             x-intersect="$el.classList.remove('animate-hidden-fade-up')">
            <div class="eyebrow text-center">Benefits</div>
            <h2 class="section-title">Why track habits?</h2>
            <p class="section-subtitle">
                Daily habit tracking helps you build consistency and create lasting positive change in your life
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <div class="feature-card animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 100)">
                <div class="feature-icon">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="feature-title">Build Streaks</h3>
                <p class="feature-description">
                    Track your consistency with visual streak counters that motivate you to maintain daily momentum.
                </p>
            </div>

            <div class="feature-card animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 200)">
                <div class="feature-icon">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="feature-title">Flexible Frequency</h3>
                <p class="feature-description">
                    Set custom frequencies like daily, 3 times per week, or monthly to match your lifestyle and goals.
                </p>
            </div>

            <div class="feature-card animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 300)">
                <div class="feature-icon">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="feature-title">Simple Tracking</h3>
                <p class="feature-description">
                    Quick daily check-ins make it easy to log progress and see your habits compound over time.
                </p>
            </div>
        </div>
    </div>
</div>
