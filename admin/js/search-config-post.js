  // Post Search Functionality
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('postSearchInput');
  const searchButton = document.getElementById('postSearchButton');
  
  // Search when button is clicked
  searchButton.addEventListener('click', performPostSearch);
  
  // Search when Enter key is pressed
  searchInput.addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
      performPostSearch();
    }
  });

  function performPostSearch() {
    const searchTerm = searchInput.value.toLowerCase().trim();
    const tables = [
      document.getElementById('allPostsTable'),
      document.getElementById('publishedPostsTable'),
      document.getElementById('scheduledPostsTable'),
      document.getElementById('draftsTable'),
      document.getElementById('archivedTable')
    ];
    
    tables.forEach(table => {
      if (table) {
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
          const title = row.querySelector('td:nth-child(2) span').textContent.toLowerCase();
          const status = row.querySelector('td:nth-child(4) span').textContent.toLowerCase();
          const matches = title.includes(searchTerm) || status.includes(searchTerm);
          
          row.style.display = matches ? '' : 'none';
        });
      }
    });
  }

  // Clear search when switching tabs
  document.querySelectorAll('.nav-tabs .nav-link').forEach(tab => {
    tab.addEventListener('click', function() {
      searchInput.value = '';
      const tables = document.querySelectorAll('.table-hover');
      tables.forEach(table => {
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
          row.style.display = '';
        });
      });
    });
  });
});