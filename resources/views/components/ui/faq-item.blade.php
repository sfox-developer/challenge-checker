@props(['question', 'answer', 'index' => 1])

<div class="faq-item animate animate-hidden-fade-up"
     x-data="{}"
     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), {{ $index * 100 }})"
     @click="activeQuestion = activeQuestion === {{ $index }} ? null : {{ $index }}">
    <div class="faq-header">
        <h3 class="faq-question">
            {{ $question }}
        </h3>
        <svg class="faq-icon"
             :class="{ 'rotate-180': activeQuestion === {{ $index }} }"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
    <div x-show="activeQuestion === {{ $index }}"
         x-collapse
         class="faq-answer">
        <p>{{ $answer }}</p>
    </div>
</div>
