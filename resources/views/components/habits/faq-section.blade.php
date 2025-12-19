<div class="section">
    <div class="container max-w-4xl">
        <div class="section-header animate animate-hidden-fade-up"
             x-data="{}"
             x-intersect="$el.classList.remove('animate-hidden-fade-up')">
            <div class="eyebrow text-center">FAQ</div>
            <h2 class="section-title">Frequently asked questions</h2>
            <p class="section-subtitle">
                Everything you need to know about habits
            </p>
        </div>

        <div class="space-y-4 mt-12" x-data="{ activeQuestion: null }">
            <x-ui.faq-item 
                :index="1"
                question="How is a habit different from a challenge?"
                answer="Habits are ongoing practices without end dates, while challenges are time-bound (30-90 days). Use habits for long-term consistency and challenges for focused sprints toward specific goals." />

            <x-ui.faq-item 
                :index="2"
                question="What happens if I miss a day?"
                answer="Missing a day resets your streak counter, but your overall progress history remains. Don't let one missed day discourage you — just get back on track the next day!" />

            <x-ui.faq-item 
                :index="3"
                question="Can I track weekly or monthly habits?"
                answer="Yes! Set custom frequencies like 3 times per week or 4 times per month. The system tracks your progress based on your chosen frequency and shows completion rates." />
        </div>
    </div>
</div>
