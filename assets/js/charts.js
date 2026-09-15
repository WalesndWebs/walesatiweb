// ========================================
// WALES & WEBS - DASHBOARD CHARTS
// ========================================

document.addEventListener('DOMContentLoaded', function() {

  // Check if Chart.js is available
  if (typeof Chart === 'undefined') {
    console.warn('Chart.js not loaded');
    return;
  }

  // Common chart options
  const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: '#111118',
        titleColor: '#fff',
        bodyColor: '#a1a1aa',
        borderColor: 'rgba(255,255,255,0.1)',
        borderWidth: 1,
        padding: 10,
        displayColors: false,
      }
    },
    scales: {
      x: { display: false },
      y: { display: false }
    },
    elements: {
      point: { radius: 0, hoverRadius: 4 }
    }
  };

  // Project Performance Line Chart
  const perfCtx = document.getElementById('projectPerformanceChart');
  if (perfCtx) {
    new Chart(perfCtx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        datasets: [{
          data: [30, 45, 35, 55, 48, 65, 58],
          borderColor: '#10b981',
          backgroundColor: (context) => {
            const ctx = context.chart.ctx;
            const gradient = ctx.createLinearGradient(0, 0, 0, 140);
            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
            gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');
            return gradient;
          },
          borderWidth: 2,
          fill: true,
          tension: 0.4
        }]
      },
      options: commonOptions
    });
  }

  // Top Services Donut Chart
  const servicesCtx = document.getElementById('topServicesChart');
  if (servicesCtx) {
    new Chart(servicesCtx, {
      type: 'doughnut',
      data: {
        labels: ['Web Systems', 'Automation', 'Mobile Apps', 'Consulting'],
        datasets: [{
          data: [45, 25, 15, 15],
          backgroundColor: [
            '#10b981',
            '#8b5cf6',
            '#3b82f6',
            '#f59e0b'
          ],
          borderWidth: 0,
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#111118',
            titleColor: '#fff',
            bodyColor: '#a1a1aa',
            borderColor: 'rgba(255,255,255,0.1)',
            borderWidth: 1,
            padding: 10,
          }
        }
      }
    });
  }

});
