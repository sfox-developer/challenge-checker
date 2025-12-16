<div class="section section-bg-light">
    <div class="container max-w-4xl">
        <div class="section-header animate animate-hidden-fade-up"
             x-data="{}"
             x-intersect="$el.classList.remove('animate-hidden-fade-up')">
            <div class="eyebrow text-center">Benefits</div>
            <h2 class="section-title">Why use challenges?</h2>
            <p class="section-subtitle">
                Time-bound challenges help you stay focused and motivated on your most important goals
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <div class="feature-card animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 100)">
                <div class="feature-icon">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="feature-title">Clear Deadlines</h3>
                <p class="feature-description">
                    Set specific timeframes (30, 60, 90 days) to create urgency and maintain momentum.
                </p>
            </div>

            <div class="feature-card animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 200)">
                <div class="feature-icon">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <h3 class="feature-title">Track Progress</h3>
                <p class="feature-description">
                    Monitor multiple goals within each challenge and see your completion rate improve over time.
                </p>
            </div>

            <div class="feature-card animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 300)">
                <div class="feature-icon">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                </div>
                <h3 class="feature-title">Build Habits</h3>
                <p class="feature-description">
                    Transform temporary challenges into permanent habits through consistent daily practice.
                </p>
            </div>
        </div>
    </div>
</div>
