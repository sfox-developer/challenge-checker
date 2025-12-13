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
            ...config
        };

        // Initialize Lottie animation
        const animation = lottie.loadAnimation(defaultConfig);

        // Set up interval replay if specified
        let intervalId = null;
        if (config.interval) {
            intervalId = setInterval(() => {
                animation.goToAndPlay(0);
            }, config.interval);
        }

        // Store animation and interval for cleanup
        el._lottieAnimation = animation;
        el._lottieInterval = intervalId;
        
        // Alpine cleanup hook
        Alpine.onAttributeRemoved(el, 'x-lottie', () => {
            if (el._lottieInterval) {
                clearInterval(el._lottieInterval);
            }
            if (el._lottieAnimation) {
                el._lottieAnimation.destroy();
            }
        });
    });
}
