document.addEventListener('DOMContentLoaded', function() {
  const searchToggle = document.getElementById('search-toggle');
  const searchPopup = document.querySelector('.search-popup');
  const searchClose = document.querySelector('.search-close');
  const searchInput = document.querySelector('.search-input');
  const searchResults = document.createElement('div');
  searchResults.className = 'search-results';
  document.querySelector('.search-container').appendChild(searchResults);

  /**
   * Initialize empty search data
   */
  let searchData = [];

  /**
   * (Regular)Load search data from JSON file
   * Explanation of this Pormula: 
   * fanktion for seaching and collecting  into data it's either data from getDefaultSearchData() || fetched from JSON file
   * it's like using if statement but (then is used) if response||searched is ok then goods to go else throw new errror
   * then data must have or used by http && / && # to take the item with than corresponded link.
   * 
   * if the JSON didn't work the the getDefaultSearchData() is used as seachdata (\_* *_/)
   */
  function loadSearchData() {
    fetch('/assets/data/search-data.json')
      .then(response => {
        if (!response.ok) throw new Error('Failed to load search data');
        return response.json();
      })


      .then(data => {
        searchData = data.map(item => {
          if (!item.link.startsWith('http') && !item.link.startsWith('/') && !item.link.startsWith('#')) {
            item.link = `/${item.link}`; 
          }
          return item;
        });
      })


      .catch(error => {
        console.error('Error loading search data:', error);
        // Fallback to default data if JSON fails to load
        searchData = getDefaultSearchData();
      });
  }


  /**
   * Default data if JSON fails to load
   */
  function getDefaultSearchData() {
    return [
      { 
        title: 'About', 
        content: 'Learn about COMSA and our mission', 
        link: '/index.html#about',
        keywords: 'about comsa mission vision' 
      },
      { 
        title: 'Portfolio', 
        content: 'View our past events and activities', 
        link: '/index.html#portfolio',
        keywords: 'portfolio events activities work' 
      },
      { 
        title: 'Team', 
        content: 'Meet our hardworking team members', 
        link: '/index.html#team',
        keywords: 'team members people' 
      },
      { 
        title: 'Contact', 
        content: 'Get in touch with us', 
        link: '/index.html#contact',
        keywords: 'contact email address phone' 
      },
      { 
        title: 'Calendar', 
        content: 'View upcoming COMSA events', 
        link: '/features/calendar.html#calendar-hero',
        keywords: 'calendar events schedule dates' 
      }
    ];
  }

  /**
   * Lf data
   */
  loadSearchData();


  /**
   * Commonsnese fanktion
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
    if (searchTerm.length > 0 && searchData.length > 0) {
      const results = searchData.filter(item => 
        item.title.toLowerCase().includes(searchTerm) || 
        item.content.toLowerCase().includes(searchTerm) ||
        item.keywords.toLowerCase().includes(searchTerm)
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
      // External link
      window.location.href = link;
    } else if (link.startsWith('#')) {
      // Anchor on current page
      window.location.hash = link;
      // Smooth scroll to section
      const target = document.querySelector(link);
      if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
      }
    } else {
      // Internal page link
      window.location.href = link;
    }
    closeSearch();
  }
  
  // To clear your history in incognito I mean in the search container
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

