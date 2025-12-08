 document.addEventListener('DOMContentLoaded', function() {
  // Initialize DataTables
  $('#studentsTable').DataTable({
    responsive: true,
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50]
  });

  // Initialize charts
  const engagementCtx = document.getElementById('engagementChart').getContext('2d');
  const engagementChart = new Chart(engagementCtx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'User Engagement',
        data: [65, 59, 80, 81, 76, 85],
        backgroundColor: 'rgba(125, 184, 50, 0.2)',
        borderColor: 'rgba(125, 184, 50, 1)',
        borderWidth: 2,
        tension: 0.3,
        fill: true
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  const userDistributionCtx = document.getElementById('userDistributionChart').getContext('2d');
  const userDistributionChart = new Chart(userDistributionCtx, {
    type: 'doughnut',
    data: {
      labels: ['Computer Science', 'IT', 'Software Eng', 'Cybersecurity', 'Data Science'],
      datasets: [{
        data: [35, 25, 20, 15, 5],
        backgroundColor: [
          'rgba(125, 184, 50, 0.8)',
          'rgba(54, 162, 235, 0.8)',
          'rgba(255, 206, 86, 0.8)',
          'rgba(75, 192, 192, 0.8)',
          'rgba(153, 102, 255, 0.8)'
        ],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'right'
        }
      }
    }
  });

  // Dark mode toggle
  const darkModeToggle = document.getElementById('darkModeToggle');
  if (darkModeToggle) {
    darkModeToggle.addEventListener('change', function() {
      document.body.classList.toggle('dark-mode');
      localStorage.setItem('darkMode', this.checked);
      
      // Update charts for dark mode
      updateChartsForDarkMode(this.checked);
    });
    
    // Check for saved dark mode preference
    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark-mode');
      darkModeToggle.checked = true;
      updateChartsForDarkMode(true);
    }
  }
  
  function updateChartsForDarkMode(isDark) {
    const textColor = isDark ? '#e0e0e0' : '#666';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
    
    engagementChart.options.scales.x.grid.color = gridColor;
    engagementChart.options.scales.y.grid.color = gridColor;
    engagementChart.options.scales.x.ticks.color = textColor;
    engagementChart.options.scales.y.ticks.color = textColor;
    engagementChart.update();
    
    userDistributionChart.options.plugins.legend.labels.color = textColor;
    userDistributionChart.update();
  }
});