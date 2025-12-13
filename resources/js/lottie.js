/**
 * Lottie Animation Helper
 * 
 * Provides a reusable Alpine.js directive for Lottie animations
 * Usage: x-lottie="{ path: '/animations/loader-cat.json', loop: true }"
 * Interval: x-lottie="{ path: '/animations/cat.json', interval: 6000 }" - plays every 6 seconds
 */

import lottie from 'lottie-web';

export function initLottie(Alpine) {
    Alpine.directive('lottie', (el, { expression }, { evaluate }) => {
        const config = evaluate(expression);
        
        const defaultConfig = {
            container: el,
            renderer: 'svg',
            loop: !config.interval, // Don't loop if interval is set
            autoplay: true,
            rendererSettings: {
                preserveAspectRatio: config.stretch ? 'none' : 'xMidYMid meet',
                ...(config.rendererSettings || {})
            },
            ...config
        };

        // Initialize Lottie animation
        const animation = lottie.loadAnimation(defaultConfig);

        // If stretch is enabled, force SVG to not preserve aspect ratio
        if (config.stretch) {
            setTimeout(() => {
                const svg = el.querySelector('svg');
                if (svg) {
                    svg.setAttribute('preserveAspectRatio', 'none');
                }
            }, 0);
        }

        // Set up scroll-based animation if specified
        let scrollHandler = null;
        if (config.scrollProgress) {
            animation.autoplay = false;
            
            scrollHandler = () => {
                const rect = el.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                
                // Calculate element center position
                const elementCenter = rect.top + rect.height / 2;
                const viewportCenter = windowHeight / 2;
                
                // Calculate progress based on element center reaching viewport center
                // Progress is 0 when element center is at bottom of viewport
                // Progress is 1 when element center reaches viewport center
                // Progress stays at 1 when element is above center
                const distanceFromCenter = elementCenter - viewportCenter;
                const maxDistance = windowHeight / 2;
                
                let progress;
                if (distanceFromCenter <= 0) {
                    // Element center is at or above viewport center
                    progress = 1;
                } else if (distanceFromCenter >= maxDistance) {
                    // Element center hasn't entered viewport yet
                    progress = 0;
                } else {
                    // Element center is between viewport bottom and center
                    progress = 1 - (distanceFromCenter / maxDistance);
                }
                
                // Map progress to animation frames
                const frame = progress * (animation.totalFrames - 1);
                animation.goToAndStop(frame, true);
            };
            
            window.addEventListener('scroll', scrollHandler, { passive: true });
            window.addEventListener('resize', scrollHandler, { passive: true });
            
            // Initial call
            setTimeout(scrollHandler, 100);
        }
        
        // Set up interval replay if specified
        let intervalId = null;
        if (config.interval) {
            intervalId = setInterval(() => {
                animation.goToAndPlay(0);
            }, config.interval);
        }

        // Store animation, interval, and scroll handler for cleanup
        el._lottieAnimation = animation;
        el._lottieInterval = intervalId;
        el._lottieScrollHandler = scrollHandler;
        
        // Alpine cleanup hook
        Alpine.onAttributeRemoved(el, 'x-lottie', () => {
            if (el._lottieInterval) {
                clearInterval(el._lottieInterval);
            }
            if (el._lottieScrollHandler) {
                window.removeEventListener('scroll', el._lottieScrollHandler);
                window.removeEventListener('resize', el._lottieScrollHandler);
            }
            if (el._lottieAnimation) {
                el._lottieAnimation.destroy();
            }
        });
    });
}
