document.addEventListener("DOMContentLoaded", function () {
  console.log("Search script loaded");

  // Get elements air, water, earth, fire...
  const searchToggleElements = document.querySelectorAll(
    "#search-toggle, .search-toggle-mobile"
  );
  const searchPopup = document.getElementById("searchPopup");
  const searchInput = document.getElementById("searchInput");
  const searchButton = document.getElementById("searchButton");
  const searchCloseButton = document.getElementById("searchCloseButton");
  const searchResultsList = document.getElementById("searchResultsList");
  const searchResultsCount = document.querySelector(".search-results-count");

  if (!searchPopup) {
    console.error("Search popup element not found!");
    return;
  }

  // Toggle search popup
  function toggleSearch() {
    searchPopup.classList.toggle("active");
    document.body.style.overflow = searchPopup.classList.contains("active")
      ? "hidden"
      : "";

    if (searchPopup.classList.contains("active")) {
      searchInput.focus();
      // Pre-load all students when opening search
      loadAllStudents();
    }
  }

  // Close search popup
  function closeSearch() {
    searchPopup.classList.remove("active");
    document.body.style.overflow = "";
    searchInput.value = "";
    clearResults();
  }

  // Clear search results
  function clearResults() {
    searchResultsList.innerHTML = "";
    searchResultsCount.textContent = "0 results";
  }

  // Load all students for initial display
  function loadAllStudents() {
    fetch("../backend/api/get_all_students.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          displayResults(data.students, "all students");
        } else {
          showMessage("Failed to load students");
        }
      })
      .catch((error) => {
        console.error("Error loading students:", error);
        showMessage("Error loading students");
      });
  }

  // Perform search using your backend API
  // Update your performSearch function:
  function performSearch(searchTerm) {
    if (searchTerm.length < 2) {
      showMessage("Please enter at least 2 characters");
      return;
    }

    // Show loading state
    searchResultsList.innerHTML =
      '<div class="search-message"><span class="search-loading"></span>Searching...</div>';

    // Debug the URL
    const apiUrl = `../backend/api/search_students.php?q=${encodeURIComponent(
      searchTerm
    )}`;
    console.log("Calling API:", apiUrl);

    // Call your search API
    fetch(apiUrl)
      .then((response) => {
        console.log("Response status:", response.status);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        console.log("API response:", data);
        if (data.success) {
          displayResults(data.students, searchTerm);
        } else {
          showMessage(data.message || "Search failed");
        }
      })
      .catch((error) => {
        console.error("Search error details:", error);
        showMessage("Search error occurred: " + error.message);
      });
  }

  // Display search results
  function displayResults(students, searchTerm) {
    if (!students || students.length === 0) {
      showMessage(`No students found for "${searchTerm}"`);
      searchResultsCount.textContent = "0 results";
      return;
    }

    searchResultsCount.textContent = `${students.length} result${
      students.length !== 1 ? "s" : ""
    }`;

    let resultsHTML = "";
    students.forEach((student) => {
      const profileImage = student.profile_picture
        ? `../backend/${student.profile_picture}`
        : "../../assets/img/team/default_user.png";

      const nickname = student.nickname || "No nickname";
      const totalStars = student.total_stars || 0;
      const totalProjects = student.total_projects || 0;

      resultsHTML += `
                <div class="search-result-item" data-student-id="${student.id}">
                    <img src="${profileImage}" 
                         alt="${student.username}" 
                         class="search-result-avatar"
                         onerror="this.src='../../assets/img/team/default_user.png'">
                    <div class="search-result-info">
                        <h6>${escapeHtml(student.username)}</h6>
                        <p class="mb-0 text-muted">${escapeHtml(nickname)}</p>
                        <div class="search-result-stats">
                            <span><i class="ri-folder-line"></i> ${totalProjects} projects</span>
                            <span><i class="ri-star-line"></i> ${totalStars} stars</span>
                        </div>
                    </div>
                    <div class="search-result-arrow">
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                </div>
            `;
    });

    searchResultsList.innerHTML = resultsHTML;

    // Add click events to result items
    document.querySelectorAll(".search-result-item").forEach((item) => {
      item.addEventListener("click", function () {
        const studentId = this.getAttribute("data-student-id");
        viewStudentProfile(studentId);
      });
    });
  }

  // Navigate to student profile
  function viewStudentProfile(studentId) {
    if (studentId == currentStudentId) {
      // Redirect to own profile
      window.location.href = "profile.php";
    } else {
      // Redirect to view other student's profile
      window.location.href = `view.php?id=${studentId}`;
    }

    closeSearch();
  }

  function showMessage(message) {
    searchResultsList.innerHTML = `<div class="search-message">${escapeHtml(
      message
    )}</div>`;
    searchResultsCount.textContent = "0 results";
  }

  // Utility function to escape HTML
  function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
  }

  // Event listeners
  searchToggleElements.forEach((toggle) => {
    toggle.addEventListener("click", function (e) {
      e.preventDefault();
      toggleSearch();
    });
  });

  searchCloseButton.addEventListener("click", closeSearch);

  searchButton.addEventListener("click", function () {
    performSearch(searchInput.value.trim());
  });

  searchInput.addEventListener("input", function () {
    const searchTerm = this.value.trim();

    if (searchTerm.length === 0) {
      // Show all students when search is cleared
      loadAllStudents();
      return;
    }

    if (searchTerm.length >= 2) {
      // Debounce the search to avoid too many API calls
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        performSearch(searchTerm);
      }, 300);
    }
  });

  searchInput.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      performSearch(this.value.trim());
    }
  });

  // Close when clicking outside
  searchPopup.addEventListener("click", function (e) {
    if (e.target === searchPopup) {
      closeSearch();
    }
  });

  // Close with Escape key
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && searchPopup.classList.contains("active")) {
      closeSearch();
    }
  });

  console.log("Search functionality initialized");
});
