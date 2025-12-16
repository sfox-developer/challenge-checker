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
                        What's the difference between goals in my library and goals in challenges?
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Your library stores reusable goal templates. When you add a library goal to a challenge, it creates a copy that you can track independently. Changes to library goals don't affect existing challenges.
                    </p>
                </div>
            </div>

            <div class="card animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 200)">
                <div class="card-body">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                        Can I delete a goal that's being used?
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        No, you can't delete goals that are currently in use by challenges or habits. This protects your active tracking data. Archive or complete those items first to remove the goal.
                    </p>
                </div>
            </div>

            <div class="card animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 300)">
                <div class="card-body">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                        How should I organize my goal library?
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Use categories to group related goals (Health, Productivity, Learning, etc.) and add descriptive icons. Keep goal names clear and specific so they're easy to find when building challenges.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
