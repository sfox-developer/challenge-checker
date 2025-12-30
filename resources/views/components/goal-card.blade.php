@props([
    'variant' => 'default' // default, selectable, status
])

<div class="goal-display-card">
    <div class="goal-display-accent-bar"></div>
    <div class="goal-display-card-content">
        <div class="goal-display-card-layout{{ isset($rightAction) && !$rightAction->isEmpty() ? '-with-action' : '' }}">
            <div class="goal-display-card-main">
                @if(isset($icon) && !$icon->isEmpty())
                    {{ $icon }}
                @endif
                
                <div class="goal-display-card-text">
                    @if(isset($title) && !$title->isEmpty())
                        {{ $title }}
                    @endif
                    
                    @if(isset($subtitle) && !$subtitle->isEmpty())
                        {{ $subtitle }}
                    @endif
                </div>
            </div>
            
            @if(isset($rightAction) && !$rightAction->isEmpty())
                {{ $rightAction }}
            @endif
        </div>
    </div>
</div>
