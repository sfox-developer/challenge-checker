@props(['totalChallenges', 'completedCount'])

<div class="section pt-0">
    <div class="container max-w-4xl">
        <div class="grid grid-cols-2 gap-4 md:gap-6">
            <div class="animate animate-hidden-fade-up-sm"
                 x-data="{ 
                    counter: 0, 
                    target: {{ $totalChallenges }},
                    startCounting() {
                        if (this.counter >= this.target) return;
                        const duration = 1500;
                        const steps = 60;
                        const increment = this.target / steps;
                        const stepDuration = duration / steps;
                        
                        let current = 0;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= this.target) {
                                this.counter = this.target;
                                clearInterval(timer);
                            } else {
                                this.counter = Math.floor(current);
                            }
                        }, stepDuration);
                    }
                 }"
                 x-intersect="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up-sm'); startCounting(); }, 100)">
                <x-ui.stat-card 
                    variant="top"
                    label="Total Challenges" 
                    :value="$totalChallenges"
                    :animate="true" />
            </div>

            <div class="animate animate-hidden-fade-up-sm"
                 x-data="{ 
                    counter: 0, 
                    target: {{ $completedCount }},
                    startCounting() {
                        if (this.counter >= this.target) return;
                        const duration = 1500;
                        const steps = 60;
                        const increment = this.target / steps;
                        const stepDuration = duration / steps;
                        
                        let current = 0;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= this.target) {
                                this.counter = this.target;
                                clearInterval(timer);
                            } else {
                                this.counter = Math.floor(current);
                            }
                        }, stepDuration);
                    }
                 }"
                 x-intersect="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up-sm'); startCounting(); }, 200)">
                <x-ui.stat-card 
                    variant="top"
                    label="Completed" 
                    :value="$completedCount"
                    :animate="true" />
            </div>
        </div>
    </div>
</div>
