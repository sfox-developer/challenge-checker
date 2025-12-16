<div class="section">
    <div class="container max-w-4xl">
        <div class="section-header animate animate-hidden-fade-up"
             x-data="{}"
             x-intersect="$el.classList.remove('animate-hidden-fade-up')">
            <div class="eyebrow text-center">FAQ</div>
            <h3 class="section-title">Frequently asked questions</h3>
        </div>
        
        <div class="space-y-4 max-w-3xl mx-auto mt-12">
            <div class="card animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 100)">
                <div class="card-body">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                        How is a habit different from a challenge?
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Habits are ongoing practices without end dates, while challenges are time-bound (30-90 days). Use habits for long-term consistency and challenges for focused sprints toward specific goals.
                    </p>
                </div>
            </div>

            <div class="card animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 200)">
                <div class="card-body">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                        What happens if I miss a day?
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Missing a day resets your streak counter, but your overall progress history remains. Don't let one missed day discourage you just get back on track the next day!
                    </p>
                </div>
            </div>

            <div class="card animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 300)">
                <div class="card-body">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                        Can I track weekly or monthly habits?
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Yes! Set custom frequencies like 3 times per week or 4 times per month. The system tracks your progress based on your chosen frequency and shows completion rates.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
