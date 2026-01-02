/**
 * Analytics Charts Initialization
 * 
 * Handles Chart.js initialization for goal analytics visualizations:
 * - Monthly Trend Line Chart
 * - Milestone Progress Doughnut Chart
 */

export function initializeAnalyticsCharts() {
    // First check if any chart elements exist on the page
    const monthlyChartCanvas = document.getElementById('monthly-trend-chart');
    const milestoneChartCanvas = document.getElementById('milestone-progress-chart');
    
    if (!monthlyChartCanvas && !milestoneChartCanvas) {
        // No chart elements found, silently return without logging
        return;
    }
    
    console.log('Chart initialization started...');
    console.log('Chart.js available:', typeof Chart !== 'undefined');
    
    // Verify Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js not available. Make sure it\'s loaded.');
        return;
    }
    
    // Get chart data from global window object (set by Blade template)
    const chartData = window.analyticsChartData;
    if (!chartData) {
        console.error('Chart data not found. Make sure analyticsChartData is set.');
        return;
    }
    
    // Helper function to safely create charts
    function createChart(canvasId, chartConfig) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) {
            console.error(`Canvas with ID "${canvasId}" not found`);
            return null;
        }
        
        console.log(`Creating chart for ${canvasId}...`);
        
        // Clear any existing chart
        const existingChart = Chart.getChart(canvas);
        if (existingChart) {
            existingChart.destroy();
        }
        
        const ctx = canvas.getContext('2d');
        if (!ctx) {
            console.error(`Could not get 2D context for "${canvasId}"`);
            return null;
        }
        
        try {
            const chart = new Chart(ctx, chartConfig);
            console.log(`Chart "${canvasId}" created successfully`);
            return chart;
        } catch (error) {
            console.error(`Error creating chart for "${canvasId}":`, error);
            return null;
        }
    }
    
    // Monthly Trend Chart
    if (chartData.monthly_trend && monthlyChartCanvas) {
        const monthlyData = chartData.monthly_trend;
        console.log('Monthly data:', monthlyData);
        
        createChart('monthly-trend-chart', {
            type: 'line',
            data: {
                labels: monthlyData.labels,
                datasets: [{
                    label: 'Completions',
                    data: monthlyData.data,
                    borderColor: 'rgb(71, 85, 105)',
                    backgroundColor: 'rgba(71, 85, 105, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: 'rgb(71, 85, 105)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Milestone Progress Chart
    if (chartData.milestone_progress && milestoneChartCanvas) {
        const milestoneData = chartData.milestone_progress;
        console.log('Milestone data:', milestoneData);
        
        createChart('milestone-progress-chart', {
            type: 'doughnut',
            data: {
                labels: milestoneData.labels,
                datasets: [{
                    data: milestoneData.data,
                    backgroundColor: ['rgb(71, 85, 105)', 'rgb(229, 231, 235)'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { legend: { display: false } }
            }
        });
    }
    
    console.log('Chart initialization completed');
}

// Auto-initialize when DOM is ready
function autoInitialize() {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeAnalyticsCharts);
    } else {
        // DOM is already loaded
        setTimeout(initializeAnalyticsCharts, 100);
    }
    
    // Fallback initialization
    window.addEventListener('load', function() {
        setTimeout(initializeAnalyticsCharts, 500);
    });
}

// Initialize automatically when this module is loaded
autoInitialize();