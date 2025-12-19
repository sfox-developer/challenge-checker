<div class="section">
    <div class="container max-w-4xl">
        <div class="section-header animate animate-hidden-fade-up"
             x-data="{}"
             x-intersect="$el.classList.remove('animate-hidden-fade-up')">
            <div class="eyebrow text-center">FAQ</div>
            <h2 class="section-title">Frequently asked questions</h2>
            <p class="section-subtitle">
                Everything you need to know about goals
            </p>
        </div>

        <div class="space-y-4 mt-12" x-data="{ activeQuestion: null }">
            <x-ui.faq-item 
                :index="1"
                question="What's the difference between goals in my library and goals in challenges?"
                answer="Your library stores reusable goal templates. When you add a library goal to a challenge, it creates a copy that you can track independently. Changes to library goals don't affect existing challenges." />

            <x-ui.faq-item 
                :index="2"
                question="Can I delete a goal that's being used?"
                answer="No, you can't delete goals that are currently in use by challenges or habits. This protects your active tracking data. Archive or complete those items first to remove the goal." />

            <x-ui.faq-item 
                :index="3"
                question="How should I organize my goal library?"
                answer="Use categories to group related goals (Health, Productivity, Learning, etc.) and add descriptive icons. Keep goal names clear and specific so they're easy to find when building challenges." />
        </div>
    </div>
</div>
