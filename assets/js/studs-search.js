


// Search only for student dashboard/Account and related features
// This script is specifically tailored for student-related features






// /assets/js/studs-search.js
document.addEventListener('DOMContentLoaded', function() {
  const searchToggle = document.getElementById('search-toggle');
  const searchPopup = document.querySelector('.search-popup');
  const searchInput = document.querySelector('.search-input');
  const searchResults = document.createElement('div');
  searchResults.className = 'search-results';
  document.querySelector('.search-container').appendChild(searchResults);

  /**
   * Student-specific search data
   */
  let studentSearchData = getStudentSearchData();

  /**
   * Default data for student dashboard
   */
  function getStudentSearchData() {
    return [
      { 
        title: 'My Projects', 
        content: 'View and manage your current projects', 
        link: '/features/project-studs.html',
        keywords: 'projects work assignments tasks' 
      },
      { 
        title: 'Messages', 
        content: 'Check your inbox and send messages', 
        link: '/features/studs-chat.html',
        keywords: 'messages chat inbox communication' 
      },
      { 
        title: 'Calendar', 
        content: 'View your academic schedule and events', 
        link: '/features/calendar.html',
        keywords: 'calendar schedule events dates' 
      },
      { 
        title: 'Settings', 
        content: 'Update your profile and preferences', 
        link: '/features/settings-studs.html',
        keywords: 'settings profile preferences account' 
      },
      { 
        title: 'Course Materials', 
        content: 'Access your course resources and files', 
        link: '#',
        keywords: 'courses materials resources files' 
      },
      { 
        title: 'Grades', 
        content: 'View your academic performance', 
        link: '#',
        keywords: 'grades scores marks results' 
      },
      { 
        title: 'Student Resources', 
        content: 'Access helpful resources for students', 
        link: '#',
        keywords: 'resources help guides tutorials' 
      },
        { 
        title: 'Upload Projects', 
        content: 'For uploading projects', 
        link: '/features/project-studs.html',
        keywords: 'upload projects assignments files documents' 
      }
    ];
  }

  /**
   * Event listeners
   */

  // Toggle search popup
  searchToggle.addEventListener('click', function(e) {
    e.preventDefault();
    searchPopup.classList.add('active');
    document.body.style.overflow = 'hidden';
    searchInput.focus();
  });

  // Close when clicking outside
  searchPopup.addEventListener('click', function(e) {
    if (e.target === searchPopup) {
      closeSearch();
    }
  });

  // Search functionality
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    if (searchTerm.length > 0) {
      const results = studentSearchData.filter(item => 
        item.title.toLowerCase().includes(searchTerm) || 
        item.content.toLowerCase().includes(searchTerm) ||
        (item.keywords && item.keywords.toLowerCase().includes(searchTerm))
      );
      displayResults(results);
    } else {
      clearResults();
    }
  });

  // display result items
  function displayResults(results) {
    searchResults.innerHTML = '';
    
    if (results.length > 0) {
      results.forEach(item => {
        const resultItem = document.createElement('div');
        resultItem.className = 'search-result-item';
        resultItem.innerHTML = `
          <h3>${item.title}</h3>
          <p>${item.content}</p>
        `;
        resultItem.addEventListener('click', function() {
          navigateToResult(item.link);
        });
        searchResults.appendChild(resultItem);
      });
      searchResults.style.display = 'block';
    } else {
      searchResults.innerHTML = '<div class="no-results">No results found</div>';
      searchResults.style.display = 'block';
    }
  }

  function navigateToResult(link) {
    if (link.startsWith('http') || link.startsWith('www')) {
      window.location.href = link;
    } else if (link.startsWith('#')) {
      window.location.hash = link;
      const target = document.querySelector(link);
      if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
      }
    } else {
      window.location.href = link;
    }
    closeSearch();
  }
  
  function clearResults() {
    searchResults.innerHTML = '';
    searchResults.style.display = 'none';
  }

  function closeSearch() {
    searchPopup.classList.remove('active');
    document.body.style.overflow = '';
    searchInput.value = '';
    clearResults();
  }
});