<x-public-layout>
    <x-slot name="title">Challenge Checker - Build Better Habits, Achieve Your Goals</x-slot>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1 class="hero-title animate animate-hidden-fade-up-sm" 
                x-data="{}" 
                x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up-sm') }, 100)">
                Turn Goals Into Habits.<br>Habits Into Results.
            </h1>
            
            <p class="hero-subtitle animate animate-hidden-fade-up-sm animate-delay-100" 
               x-data="{}" 
               x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up-sm') }, 100)">
                Track daily challenges, build lasting habits, and achieve your goals with a supportive community. Simple. Powerful. Effective.
            </p>

            <div class="hero-cta animate animate-hidden-fade-up-sm animate-delay-200" 
                 x-data="{}" 
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up-sm') }, 100)">
                @auth
                    <a href="{{ route('feed.index') }}" class="btn btn-primary btn-lg">
                        Go to Your Feed
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        Start Free Today
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Hero Visual Showcase -->
    <div class="section">
        <div class="hero-visual animate animate-hidden-scale-up" 
             x-data="{}" 
             x-intersect="$el.classList.remove('animate-hidden-scale-up')">
            <!-- Main Screenshot/Image -->
            <div class="hero-video-container">
                <!-- Replace with your actual video -->
                <video class="hero-video" autoplay playsinline preload="auto" loop muted poster="/images/placeholder-dashboard.jpg">
                    <source src="/videos/dashboard-demo.mp4" type="video/mp4">
                </video>
                
                {{-- Alternative: Static image placeholder --}}
                {{-- <img src="/images/dashboard-screenshot.png" alt="Challenge Checker Dashboard" class="hero-image"> --}}
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="section features">
        <div class="container">
            <div class=\"section-header animate animate-hidden-fade-up\" 
                 x-data=\"{}\" 
                 x-intersect=\"$el.classList.remove('animate-hidden-fade-up')\">
                <h2 class="section-title">Everything You Need to Succeed</h2>
                <p class="section-subtitle">
                    Powerful features designed to help you build habits that stick and achieve goals that matter.
                </p>
            </div>

            <div class="features-grid">
                <!-- Feature 1: Challenges -->
                <div class="feature-card animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                    <div class="feature-icon">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Time-Bound Challenges</h3>
                    <p class="feature-description">
                        Create 30, 60, or 90-day challenges with multiple daily goals. Stay focused with clear deadlines.
                    </p>
                </div>

                <!-- Feature 2: Habits -->
                <div class="feature-card animate animate-hidden-fade-up animate-delay-100" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                    <div class="feature-icon">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Flexible Habit Tracking</h3>
                    <p class="feature-description">
                        Track daily, weekly, monthly, or yearly habits. Build streaks and watch your consistency grow.
                    </p>
                </div>

                <!-- Feature 3: Analytics -->
                <div class="feature-card animate animate-hidden-fade-up animate-delay-200" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                    <div class="feature-icon">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Progress Analytics</h3>
                    <p class="feature-description">
                        Visualize your journey with detailed stats, streak tracking, and completion reports.
                    </p>
                </div>

                <!-- Feature 4: Social -->
                <div class="feature-card animate animate-hidden-fade-up animate-delay-300" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                    <div class="feature-icon">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Social Accountability</h3>
                    <p class="feature-description">
                        Follow friends, share progress, and stay motivated together with an inspiring community.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="section how-it-works">
        <div class="container">
            <div class="section-header animate animate-hidden-fade-up" 
                 x-data="{}" 
                 x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="section-title">How It Works</h2>
                <p class="section-subtitle">
                    Get started in minutes. See results in days. Build lasting change in weeks.
                </p>
            </div>

            <div class="steps-grid">
                <!-- Step 1 -->
                <div class="step-card animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Set Your Goals</h3>
                    <p class="step-description">
                        Create a challenge with specific daily goals or build habits you want to track. Choose from your personal goals library or create new ones.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="step-card animate animate-hidden-fade-up animate-delay-100" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Track Daily Progress</h3>
                    <p class="step-description">
                        Check off completed goals each day. Watch your streaks grow and your progress bars fill. Add notes and track your mood along the way.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="step-card animate animate-hidden-fade-up animate-delay-200" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Celebrate Success</h3>
                    <p class="step-description">
                        Complete challenges, hit milestones, and share your wins. See your transformation through detailed analytics and celebrate with your community.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Benefits Section with Visual -->
    <div class="section benefits">
        <div class="container">
            <div class="benefits-grid">
                <!-- Content -->
                <div class="benefit-content">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6 animate animate-hidden-fade-up" 
                        x-data="{}" 
                        x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                        Why Challenge Checker Works
                    </h2>

                    <div class="space-y-6">
                        <div class="benefit-item animate animate-hidden-slide-left" 
                             x-data="{}" 
                             x-intersect="$el.classList.remove('animate-hidden-slide-left')">
                            <div class="benefit-icon">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="benefit-text">
                                <h3>Clear Structure</h3>
                                <p>Time-bound challenges give you deadlines and urgency. No more endless "someday" goals.</p>
                            </div>
                        </div>

                        <div class="benefit-item animate animate-hidden-slide-left animate-delay-100" 
                             x-data="{}" 
                             x-intersect="$el.classList.remove('animate-hidden-slide-left')">
                            <div class="benefit-icon">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="benefit-text">
                                <h3>Streak Power</h3>
                                <p>Build momentum with visual streak tracking. Miss a day? Your progress is still saved.</p>
                            </div>
                        </div>

                        <div class="benefit-item animate animate-hidden-slide-left animate-delay-200" 
                             x-data="{}" 
                             x-intersect="$el.classList.remove('animate-hidden-slide-left')">
                            <div class="benefit-icon">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="benefit-text">
                                <h3>Social Support</h3>
                                <p>Follow friends, share wins, and stay accountable. Seeing others succeed motivates you to keep going.</p>
                            </div>
                        </div>

                        <div class="benefit-item animate animate-hidden-slide-left animate-delay-300" 
                             x-data="{}" 
                             x-intersect="$el.classList.remove('animate-hidden-slide-left')">
                            <div class="benefit-icon">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="benefit-text">
                                <h3>Data-Driven Insights</h3>
                                <p>Track completion rates, best streaks, and progress over time. See what works and what doesn't.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visual Placeholder -->
                <div class="benefit-visual animate animate-hidden-slide-right" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-slide-right')">
                    <div class="placeholder-image">
                        [SCREENSHOT: Dashboard with active challenge showing daily goals, progress bars, and streak counter]
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section (Social Proof Placeholder) -->
    <div class="section stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item animate animate-hidden-scale-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-scale-up')">
                    <div class="stat-value">10,000+</div>
                    <div class="stat-label">Goals Completed</div>
                </div>
                <div class="stat-item animate animate-hidden-scale-up animate-delay-100" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-scale-up')">
                    <div class="stat-value">500+</div>
                    <div class="stat-label">Active Users</div>
                </div>
                <div class="stat-item animate animate-hidden-scale-up animate-delay-200" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-scale-up')">
                    <div class="stat-value">1,200+</div>
                    <div class="stat-label">Challenges Created</div>
                </div>
                <div class="stat-item animate animate-hidden-scale-up animate-delay-300" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-scale-up')">
                    <div class="stat-value">85%</div>
                    <div class="stat-label">Success Rate</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Final CTA Section -->
    <div class="section final-cta">
        <div class="container">
            <h2 class="final-cta-title animate animate-hidden-fade-up" 
                x-data="{}" 
                x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                Ready to Build Better Habits?
            </h2>
            <p class="final-cta-subtitle animate animate-hidden-fade-up animate-delay-100" 
               x-data="{}" 
               x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                Join thousands of people transforming their goals into daily wins. Start your first challenge today — completely free.
            </p>
            <div class="hero-cta animate animate-hidden-fade-up animate-delay-200" 
                 x-data="{}" 
                 x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                @auth
                    <a href="{{ route('challenges.create') }}" class="btn btn-primary btn-lg">
                        Create Your First Challenge
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        Get Started Free
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-public-layout>
