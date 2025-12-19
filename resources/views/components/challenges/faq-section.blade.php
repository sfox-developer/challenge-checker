<div class="section">
    <div class="container max-w-4xl">
        <div class="section-header animate animate-hidden-fade-up"
             x-data="{}"
             x-intersect="$el.classList.remove('animate-hidden-fade-up')">
            <div class="eyebrow text-center">FAQ</div>
            <h2 class="section-title">Frequently asked questions</h2>
            <p class="section-subtitle">
                Everything you need to know about challenges
            </p>
        </div>

        <div class="space-y-4 mt-12" x-data="{ activeQuestion: null }">
            <x-ui.faq-item 
                :index="1"
                question="How long should a challenge be?"
                answer="Most successful challenges are 30-90 days. This timeframe is long enough to build new habits but short enough to maintain focus and motivation." />

            <x-ui.faq-item 
                :index="2"
                question="Can I pause a challenge?"
                answer="Yes! Life happens. You can pause any active challenge and resume it later. Your progress is preserved." />

            <x-ui.faq-item 
                :index="3"
                question="What's the difference between challenges and habits?"
                answer="Challenges are time-bound (30, 60, 90 days) with specific end dates, while habits are ongoing practices you maintain indefinitely. Use challenges for focused sprints and habits for long-term consistency." />
        </div>
    </div>
</div>
