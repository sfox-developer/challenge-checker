<div class="section">
    <div class="container max-w-4xl">
        <div class="section-header animate animate-hidden-fade-up"
             x-data="{}"
             x-intersect="$el.classList.remove('animate-hidden-fade-up')">
            <div class="eyebrow text-center">FAQ</div>
            <h2 class="section-title">Common questions</h2>
            <p class="section-subtitle">
                Everything you need to know about connecting with others
            </p>
        </div>

        <div class="space-y-4 mt-12" x-data="{ activeQuestion: null }">
            <x-ui.faq-item 
                :index="1"
                question="How do I find users to follow?"
                answer="Use the search bar to find specific users by name or email. The Discover section shows active community members you can follow. You can also find users through the activity feed and their public challenges." />

            <x-ui.faq-item 
                :index="2"
                question="What happens when I follow someone?"
                answer="When you follow someone, their public activities will appear in your feed. You'll see when they complete challenges, achieve milestones, or share updates. This helps you stay motivated and connected with your community." />

            <x-ui.faq-item 
                :index="3"
                question="Can others see my challenges and habits?"
                answer="You have full control over your privacy. When creating or editing challenges and habits, you can mark them as public or private. Only public challenges and habits are visible to others. By default, new challenges and habits are private." />

            <x-ui.faq-item 
                :index="4"
                question="How do I unfollow someone?"
                answer="Simply click the 'Following' button on their profile or user card. It will change back to 'Follow' and you'll stop seeing their activities in your feed. You can follow them again anytime." />
        </div>
    </div>
</div>
