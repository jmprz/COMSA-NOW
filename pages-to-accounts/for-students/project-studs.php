<?php
require_once "../../../backend/config/session.php";

require_once '../../../backend/middleware/student_middleware.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>COMSA-NOW - Student Projects</title>
  <meta name="description" content="Upload and showcase your student projects - games, websites, apps, and more">
  <meta name="keywords" content="student projects, project showcase, game development, web development">

  <!-- Favicons -->



  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/favicon/site.webmanifest">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet" />
  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <!-- <link href="../../assets/css/main.css" rel="stylesheet"> -->
   
  <link rel="stylesheet" href="../../assets/css/project-studs-design.css">
  <link rel="stylesheet" href="../../assets/css/search-profile-design.css">
  <link rel="stylesheet" href="../../assets/css/dark-mode.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
  .carousel {
    width: 100%;
    height: 400px;
    /* Adjust this height as needed */
    overflow: hidden;
    border-radius: 8px;
  }

  .carousel-inner {
    width: 100%;
    height: 100%;
  }

  .carousel-item {
    width: 100%;
    height: 100%;
  }

  .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* This ensures the image fits while maintaining aspect ratio */
    background-color: #f8f9fa;
    /* Background color for images with different aspect ratios */
  }
</style>

<body class="index-page">
  <!-- Navbar -->
<nav class="navbar navbar-light bg-white shadow-sm fixed-top">
  <div class="container-xxl d-flex align-items-center justify-content-between">

    <!-- Left: Logo -->
    <a class="navbar-brand fs-2 fw-bold d-flex align-items-center gap-2" href="#">
      <img src="../../assets/img/logo.png" alt="COMSA Logo" class="img-fluid" style="height:60px;">
      <span class="d-lg-inline">COMSA-NOW</span>
    </a>



      <!-- Right: Icon buttons -->
    <div class="d-flex align-items-center gap-3 d-none d-lg-flex">

      <a href="../../pages-to-accounts/for-students/student-dashboard.php" class="btn btn-light rounded-3 d-flex align-items-center justify-content-center"
         style="width:50px; height:50px;">
        <i class="ri-home-9-line fs-4"></i>
      </a>

      <a href="../../pages-to-accounts/for-students/project-studs.php"
         class="btn btn-active rounded-3 d-flex align-items-center justify-content-center"
         style="width:50px; height:50px;">
        <i class="ri-shapes-line fs-4"></i>
      </a>

      <a href="../../pages-to-accounts/for-students/settings-studs.php"
         class="btn btn-light rounded-3 d-flex align-items-center justify-content-center"
         style="width:50px; height:50px;">
        <i class="ri-settings-line fs-4"></i>
      </a>

      <!-- Profile -->
      <a href="../../pages-to-accounts/for-students/profile-studs.php" class="d-flex align-items-center">
        <img src="../../assets/img/team/default_user.png" alt="Profile"
             class="rounded-circle border" width="45" height="45">
      </a>

  </div>
</nav>

<!-- /Navbar -->

 <!-- Main Content -->
<main class="container-fluid" style="margin-top: 80px;">
  <div class="row g-4 justify-content-center">
    
    <!-- Left Sidebar (Cards) -->
    <aside class="col-lg-3 order-lg-1" style="margin-top: 50px;">
      
      <!-- Project Upload -->
      <div class="card shadow-sm mb-3 border-0">
        <div class="card-body">
          <h5 class="fw-bold">Student Projects</h5>
          <a class="btn btn-primary mt-2 w-100" href="profile-studs.php" 
             style="background: #7db832; border: none;">
            Upload New Project
          </a>
        </div>
      </div>

      <!-- Categories Card -->
      <div class="card shadow-sm mb-3 border-0">
        <div class="card-body">
          <h6 class="fw-bold mb-3">Project Categories</h6>
     <div class="accordion-body category-list">
                    <!-- Category items -->
                    <a href="#" class="category-item" id="category-all">
                      <i class="bi bi-recycle category-icon" style="color: green;"></i> <span>All</span> <span class="category-count">99+</span>
                    </a>
                    <a href="#" class="category-item" id="category-games">
                      <i class="bi bi-controller category-icon game-icon"></i> <span>Games</span> <span class="category-count">42</span>
                    </a>
                    <a href="#" class="category-item" id="category-websites">
                      <i class="bi bi-globe category-icon web-icon"></i> <span>Websites</span> <span class="category-count">76</span>
                    </a>
                    <a href="#" class="category-item" id="category-mobile">
                      <i class="bi bi-phone category-icon mobile-icon"></i> <span>Mobile Apps</span> <span class="category-count">35</span>
                    </a>
                    <a href="#" class="category-item" id="category-console">
                      <i class="bi bi-terminal category-icon console-icon"></i> <span>Console Apps</span> <span class="category-count">28</span>
                    </a>
                    <a href="#" class="category-item" id="category-ai">
                      <i class="bi bi-robot category-icon ai-icon"></i> <span>AI/ML</span> <span class="category-count">19</span>
                    </a>
                    <a href="#" class="category-item" id="category-databases">
                      <i class="bi bi-database category-icon db-icon"></i> <span>Databases</span> <span class="category-count">23</span>
                    </a>
                  </div>
        </div>
      </div>

      <!-- Trending Projects Card -->
      <div class="card shadow-sm mb-3 border-0">
        <div class="card-body">
          <h6 class="fw-bold mb-3">Top 3 Trending Projects</h6>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
              <h6 class="mb-0">Virtual Campus Tour</h6>
              <small class="text-muted">by vr_enthusiast</small>
            </div>
            <span class="badge bg-warning"><i class="bi bi-star-fill"></i> 210</span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
              <h6 class="mb-0">Code Collab Platform</h6>
              <small class="text-muted">by team_coders</small>
            </div>
            <span class="badge bg-warning"><i class="bi bi-star-fill"></i> 187</span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="mb-0">AR Chemistry Lab</h6>
              <small class="text-muted">by science_tech</small>
            </div>
            <span class="badge bg-warning"><i class="bi bi-star-fill"></i> 156</span>
          </div>
        </div>
      </div>



    </aside>

    <!-- Main Feed (Posts Section) -->
    <section class="col-lg-7 order-lg-2">
      <div id="projectFeed" class="posts-column">
        <!-- posts dynamically loaded here -->

           <!-- comment modal -->
            <div class="modal fade" id="commentModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalProjectHeader"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div id="modalPostContent" class="mb-3"></div>
                    <div id="modalComments">Loading comments...</div>
                  </div>
                  <div class="d-flex parent-comment-div p-2">
                    <input type="text" placeholder="Write a comment..." data-id="${post.id}" class="comment-input" />
                    <button class="add-comment" data-id="${post.id}"><i class="bi bi-send"></i></button>
                  </div>
                </div>
              </div>
            </div>

      </div>
    </section>

  </div>
</main>


            
      <!-- Project Upload Modal -->
      <div class="modal fade" id="projectUploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Upload Your Project</h5>
              <button type="button" class="close-uploadInfo btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="projectUploadForm" class="compact-form">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="projectTitle" class="form-label">Project Title*</label>
                    <input type="text" class="form-control" id="projectTitle" required>
                  </div>

                  <div class="col-md-6">
                    <label for="projectType" class="form-label">Project Type*</label>
                    <select class="form-select" id="projectType" required>
                      <option value="">Select type</option>
                      <option value="Games">Game</option>
                      <option value="Websites">Website</option>
                      <option value="Mobile Apps">Mobile App</option>
                      <option value="Console">Console App</option>
                      <option value="AI/ML">AI/ML</option>
                      <option value="Databases">Database</option>
                      <option value="Others">Other</option>
                    </select>
                  </div>

                  <div class="col-12">
                    <label for="projectDescription" class="form-label">Description*</label>
                    <textarea class="form-control" id="projectDescription" rows="3" required></textarea>
                  </div>

                  <div class="col-md-6">
                    <label for="projectTechnologies" class="form-label">Technologies Used</label>
                    <div class="border p-2 rounded" id="tagInputContainer" style="min-height: 50px;">
                      <input type="text" class="form-control" id="projectTechnologies" placeholder="JavaScript, React, Node.js">
                      <span id="tagsWrapper" class="mt-2 d-flex flex-wrap gap-1"></span>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="projectTeam" class="form-label">Team Members</label>
                    <div class="border p-2 rounded" id="tagInputContainer" style="min-height: 50px;">
                      <input type="text" class="form-control" id="projectTeam" placeholder="username1, username2">
                      <span id="tagsMemberWrapper" class="mt-2 d-flex flex-wrap gap-1"></span>
                    </div>
                  </div>

                  <div class="col-12">
                    <label class="form-label">Project Media (2-8 images)</label>
                    <div class="upload-area" id="mediaUploadArea">
                      <i class="bi bi-images upload-icon"></i>
                      <p class="mb-1">Drag & drop or click to upload</p>
                      <small class="text-muted">Max 8 images (800x600 recommended)</small>
                      <input type="file" id="mediaUpload" name="mediaFiles[]" multiple accept="image/*" style="display: none;" max="8">
                    </div>
                    <div id="mediaPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                    <div id="mediaCounter" class="text-muted small mt-1">0/8 images selected</div>
                  </div>

                  <div class="row-md-5">
                    <label class="form-label">Project Links</label>
                    <div class="input-group mb-2">
                      <span class="input-group-text"><i class="bi bi-download"></i></span>
                      <input type="url" id="downloadLink" class="form-control" placeholder="Executable Download URL">
                    </div>
                    <div class="input-group mb-2">
                      <span class="input-group-text"><i class="bi bi-globe"></i></span>
                      <input type="url" id="liveLink" class="form-control" placeholder="Live Demo URL">
                    </div>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-github"></i></span>
                      <input type="url" id="githubLink" class="form-control" placeholder="GitHub Repository">
                    </div>
                  </div>

                </div>
              </form>


            </div>
            <div id="uploadOverlay" class="position-absolute d-flex flex-column justify-content-center start-0 w-100 h-100 bg-light bg-opacity-75 d-none justify-content-center align-items-center" style="z-index: 1051;">
              <div id="uploadLoader" class="text-center">
                <div class="spinner-border text-success" role="status"></div>
                <p class="mt-2 fw-semibold">Uploading...</p>
              </div>
              <div id="uploadSuccess" class="text-center d-none">
                <i class="bi bi-check-circle-fill text-success fs-1"></i>
                <p class="mt-2 fw-semibold">Upload Successful!</p>
              </div>
            </div>

            <div id="generalUploadError" class="text-danger fw-semibold text-center d-none mt-2"></div>

            <div class="modal-footer">
              <button type="button" class="close-uploadInfo btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" form="projectUploadForm" class="btn btn-primary" style="background-color: green;">Upload Project</button>
            </div>
          </div>
        </div>
      </div>


      <!-- Project viewer Modal -->
      <div class="modal fade" id="projectImageViewer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0">
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
              <img id="projectImageView" src="" alt="Project Image" class="img-fluid">
            </div>
          </div>
        </div>
      </div>

  <!-- 📌 Bottom Navigation (mobile only) -->
<nav class="d-lg-none fixed-bottom bg-white border-top shadow-sm">
  <div class="d-flex justify-content-around py-2 mt-2">

    <a href="#" class="btn btn-active rounded-3 d-flex align-items-center justify-content-center"
       style="width:50px; height:50px;">
       <i class="ri-home-9-line fs-1"></i>
    </a>

    <a href="../../pages-to-accounts/for-students/project-studs.php" 
       class="btn d-flex align-items-center justify-content-center"
       style="width:50px; height:50px;">
       <i class="ri-shapes-line fs-1"></i>
    </a>

    <a href="../../pages-to-accounts/for-students/settings-studs.php" 
       class="btn d-flex align-items-center justify-content-center"
       style="width:50px; height:50px;">
       <i class="ri-settings-line fs-1"></i>
    </a>

    <a href="../../pages-to-accounts/for-students/profile-studs.php" 
       class="btn d-flex align-items-center justify-content-center"
       style="width:50px; height:50px;">
       <img src="../../assets/img/team/default_user.png" 
            alt="Profile"
            class="rounded-circle border"
            width="40" height="40">
    </a>

  </div>
</nav>


      <!-- Mobile Categories Modal -->
      <div class="modal fade" id="categoriesModal" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content p-3">
            <div class="modal-header border-0">
              <h5 class="modal-title" id="categoriesModalLabel">Project Categories</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body category-list">
              <!-- Paste your categories content here -->
              <a href="#" class="category-item"><i class="bi bi-recycle category-icon" style="color: green;"></i> All <span class="category-count">99+</span></a>
              <a href="#" class="category-item"><i class="bi bi-controller"></i> Games <span class="category-count">42</span></a>
              <a href="#" class="category-item"><i class="bi bi-globe"></i> Websites <span class="category-count">76</span></a>
              <a href="#" class="category-item"><i class="bi bi-phone"></i> Mobile Apps <span class="category-count">35</span></a>
              <a href="#" class="category-item"><i class="bi bi-terminal"></i> Console Apps <span class="category-count">28</span></a>
              <a href="#" class="category-item"><i class="bi bi-robot"></i> AI/ML <span class="category-count">19</span></a>
              <a href="#" class="category-item"><i class="bi bi-database"></i> Databases <span class="category-count">23</span></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Mobile Trending Modal -->
      <div class="modal fade" id="trendingModal" tabindex="-1" aria-labelledby="trendingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content p-3">
            <div class="modal-header border-0">
              <h5 class="modal-title" id="trendingModalLabel">Top 3 Trending Projects</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <!-- Paste trending project cards here -->
              <div class="trending-project d-flex mb-3">
                <img src="../../assets/img/team/tung-tung-tung-sahur.png" alt="Trending Project" class="project-avatar me-2">
                <div>
                  <h6 class="mb-0">Virtual Campus Tour</h6>
                  <small>by vr_enthusiast</small><br>
                  <i class="bi bi-star-fill text-warning"></i> 210
                </div>
              </div>
              <div class="trending-project d-flex mb-3">
                <img src="../../assets/img/team/default_user.png" class="project-avatar me-2" alt="User Avatar">
                <div>
                  <h6 class="mb-0">Code Collab Platform</h6>
                  <small>by team_coders</small><br>
                  <i class="bi bi-star-fill text-warning"></i> 187
                </div>
              </div>
              <div class="trending-project d-flex mb-3">
                <img src="../../assets/img/team/default_user.png" class="project-avatar me-2" alt="User Avatar">
                <div>
                  <h6 class="mb-0">AR Chemistry Lab</h6>
                  <small>by science_tech</small><br>
                  <i class="bi bi-star-fill text-warning"></i> 156
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Mobile Resources Modal -->
      <div class="modal fade" id="resourcesModal" tabindex="-1" aria-labelledby="resourcesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content p-3">
            <div class="modal-header border-0">
              <h5 class="modal-title" id="resourcesModalLabel">Project Resources</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="resource-item d-flex mb-3">
                <i class="bi bi-book fs-4 me-3 text-primary"></i>
                <div>
                  <h6>Project Guidelines</h6>
                  <p class="small text-muted mb-0">How to structure your student project</p>
                </div>
              </div>
              <div class="resource-item d-flex mb-3">
                <i class="bi bi-tools fs-4 me-3 text-success"></i>
                <div>
                  <h6>Development Tools</h6>
                  <p class="small text-muted mb-0">Recommended tools for students</p>
                </div>
              </div>
              <div class="resource-item d-flex mb-3">
                <i class="bi bi-lightbulb fs-4 me-3 text-warning"></i>
                <div>
                  <h6>Project Ideas</h6>
                  <p class="small text-muted mb-0">Inspiration for your next project</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Search Modal -->
      <div class="search-popup" id="searchPopup">
        <div class="search-container">
          <button class="search-close-button" id="searchCloseButton">
            <i class="ri-close-line"></i>
          </button>
          <div class="search-input-container">
            <input type="text" placeholder="Search students by name, nickname, or student number..."
              class="search-input" id="searchInput">
            <button class="search-button" id="searchButton">
              <i class="ri-search-line"></i>
            </button>
          </div>
          <div class="search-results-container">
            <div class="search-results-header">
              <span>Search Results</span>
              <span class="search-results-count">0 results</span>
            </div>
            <div class="search-results-list" id="searchResultsList">
              <!-- Results will be populated here -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>
  <script src="../../assets/vendor/aos/aos.js"></script>
  <script src="../../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="../../assets/js/main.js"></script>
  <script src="../for-students/js/project-upload.js" defer></script>

  <!-- Main JS File -->
  <script src="../for-students/js/project-studs.js"></script>


  <script src="../for-students/js/profile-search-studs.js" defer></script> <!-- For Handleling search engine -->


  <script>
    //session with disabilities haha
    const studentId = <?php echo json_encode($_SESSION['user_id']); ?>;
    const currentStudentId = <?php echo json_encode($_SESSION['user_id']); ?>;
  </script>


</body>

</html>