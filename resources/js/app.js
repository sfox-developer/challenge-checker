import './bootstrap';

// Import Chart.js
import {
    Chart,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    ArcElement,
    BarController,
    LineController,
    DoughnutController,
    Title,
    Tooltip,
    Legend,
    Filler
} from 'chart.js';

// Import analytics charts
import './charts/analytics-charts.js';

Chart.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    ArcElement,
    BarController,
    LineController,
    DoughnutController,
    Title,
    Tooltip,
    Legend,
    Filler
);

// Make Chart.js available globally
window.Chart = Chart;

// Import component registry - follows Facade Pattern
// Components are organized by domain (theme, activity, modal, goals)
// following Single Responsibility Principle
import './components/index.js';

// Import goal toggle system (uses onclick handlers in Blade templates)
import './goal-toggle.js';

// Import toast notification system
import './toast.js';

// Import Lottie animation helper
import { initLottie } from './lottie.js';

// Import Alpine.js stores
import { registerStores } from './stores/index.js';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';

window.Alpine = Alpine;

Alpine.plugin(intersect);
Alpine.plugin(collapse);
initLottie(Alpine);

// Provide fallback highlight function for Laravel's error renderer
// This prevents console errors when error content is displayed in modals
if (!window.highlight) {
    window.highlight = function(code, language, truncate = false, editor = false, startingLine = 1, highlightedLine = null) {
        // Fallback: just return the code in a simple pre/code block
        const escapedCode = code
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
        
        return `<pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded text-sm overflow-auto"><code>${escapedCode}</code></pre>`;
    };
}

// Register global stores before starting Alpine
registerStores(Alpine);

Alpine.start();
