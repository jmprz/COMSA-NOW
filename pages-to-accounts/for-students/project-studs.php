<?php
  require_once "../../../backend/config/session.php";

  if (!isset($_SESSION["user_id"])) {
    // Redirect to login page if not logged in
    header("Location: ../../index.html");
    exit();
  }

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
  <link href="../../assets/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/project-studs-design.css">
  <link rel="stylesheet" href="../../assets/css/search.css">
  <link rel="stylesheet" href="../../assets/css/student-dash.css">
  <link rel="stylesheet" href="../../assets/css/dark-mode.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="index-page">

  <!-- Main Content -->
  <div class="main-content d-flex justify-content-center">
    <div class="container-fluid">
      <div class="row">
        <!-- Side Navigation -->
        <div class="col-md-2 d-none d-lg-block bg-light min-vh-100">
          <div class="side-nav py-4 px-3 d-flex flex-column justify-content-between h-100">

            <!-- Side Nav Header -->
            <div>
              <div class="text-center mb-5 side-nav-header">
                <img src="../../assets/img/logo.png" class="img-fluid" alt="COMSA Logo">
                <h3 class="fw-bold">COMSA-NOW</h3>
              </div>

              <!-- Nav Menu -->
              <div class="side-nav-menu d-flex flex-column gap-3">
                <a href="../../pages-to-accounts/for-students/student-dashboard.php" class="btn text-start d-flex align-items-center gap-2">
                  <i class="ri-home-9-line"></i> <span>Home</span>
                </a>
                <a href="../../pages-to-accounts/for-students/project-studs.php" class="btn text-start d-flex align-items-center gap-2 btn-active">
                  <i class="ri-shapes-line"></i> <span>Projects</span>
                </a>
                <a href="#" id="search-toggle" class="btn text-start d-flex align-items-center gap-2">
                  <i class="ri-search-line"></i> <span>Search</span>
                </a>
                <a href="#" class="btn text-start d-flex align-items-center gap-2">
                  <i class="ri-notification-3-line"></i> <span>Notification</span>
                </a>
                <a href="../../pages-to-accounts/for-students/settings-studs.php" class="btn text-start d-flex align-items-center gap-2">
                  <i class="ri-settings-line"></i> <span>Settings</span>
                </a>
              </div>
            </div>
            <!-- Side Nav Footer -->
            <div class="text-muted small text-center mt-4">
              Experimental Nav
            </div>
          </div>
        </div>

        <!-- Projects Column -->
        <div class="col-lg-7">
          <div class="posts-column">


            <!-- Mobile Only Header -->
            <div class="d-lg-none d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
              <div class="d-flex align-items-center">
                <h5 class="ms-2 mb-0 fw-bold">COMSA-NOW</h5>
              </div>

              <div class="d-flex align-items-center gap-2">
                <!-- Search Button -->
                <button class="btn p-2" type="button" id="search-toggle">
                  <i class="ri-search-line fs-1"></i>
                </button>

                <!-- Profile Icon Button -->
                <button type="button" class="btn p-0 border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#profileModal">
                  <img src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle" alt="Profile" style="width: 40px; height: 40px;">
                </button>
              </div>
            </div>

            <!-- Mobile Navigation Options -->
            <div class="d-md-none bg-white shadow-sm border-top">
              <div class="container-fluid py-2">
                <div class="row text-center small">
                  <div class="col">
                    <a href="#" class="text-decoration-none text-dark d-block" data-bs-toggle="modal" data-bs-target="#categoriesModal">
                      <i class="bi bi-tags fs-4 mb-1"></i><br>Categories
                    </a>
                  </div>
                  <div class="col">
                    <a href="#" class="text-decoration-none text-dark d-block" data-bs-toggle="modal" data-bs-target="#trendingModal">
                      <i class="bi bi-fire fs-4 mb-1"></i><br>Trending
                    </a>
                  </div>
                  <div class="col">
                    <a href="#" class="text-decoration-none text-dark d-block" data-bs-toggle="modal" data-bs-target="#resourcesModal">
                      <i class="bi bi-folder2-open fs-4 mb-1"></i><br>Resources
                    </a>
                  </div>
                </div>
              </div>
            </div>


            <!-- Project 1 - Game -->
            <div class="project-container">
              <div class="project-header">
                <img src="../../assets/img/team/sampleTeam.jpg" class="project-avatar" alt="User Avatar">
                <div class="project-author">
                  <p class="project-username">Valexore</p>
                  <p class="project-date">2 days ago</p>
                </div>
                <span class="project-badge game-badge" id="game">Game</span>
              </div>

              <div class="project-content">
                <h3 class="project-title">Cave Tactic RPG</h3>
                <p class="project-description">
                  Darmnn if it happens, it happens...
                </p>
                <div class="project-media">
                  <img src="../../assets/img/events/project-game-example.png" class="project-image" alt="Game Screenshot">
                  <div class="project-links">
                    <a href="#" class="project-link"><i class="bi bi-download"></i> Executable</a>
                    <a href="#" class="project-link"><i class="bi bi-github"></i> Source Code</a>
                  </div>
                </div>

                <div class="project-tech">
                  <span class="tech-tag">Godot</span>
                  <span class="tech-tag">Python</span>
                  <span class="tech-tag">Pixel Graphics</span>
                </div>
              </div>

              <div class="project-stats">
                <div class="stat">
                  <button class="post-action like-btn" data-post="2">
                    <i class="bi bi-star"></i>
                    <span style="font-size: 18px;">67 Likes</span>
                  </button>
                </div>
              </div>
            </div>

            <!-- Project 2 - Website -->
            <div class="project-container">
              <div class="project-header">
                <img src="../../assets/img/team/sampleTeam.jpg" class="project-avatar" alt="User Avatar">
                <div class="project-author">
                  <p class="project-username">Valexore</p>
                  <p class="project-date">1 week ago</p>
                </div>
                <span class="project-badge web-badge" id="website">Website</span>
              </div>

              <div class="project-content">
                <h3 class="project-title">Vanstastic</h3>
                <p class="project-description">
                  it was fustrating to received dos even tho you did all the best to create a fascinating website such as Vantastic.
                </p>

                <div class="project-media">
                  <img src="../../assets/img/events/project-web-example.png" class="project-image" alt="Website Screenshot">
                  <div class="project-links">
                    <a href="#" class="project-link"><i class="bi bi-globe"></i> Live Demo</a>
                    <a href="#" class="project-link"><i class="bi bi-github"></i> Source Code</a>
                  </div>
                </div>

                <div class="project-tech">
                  <span class="tech-tag">Php</span>
                  <span class="tech-tag">MySql</span>
                  <span class="tech-tag">Html</span>
                  <span class="tech-tag">Css</span>
                  <span class="tech-tag">Bootstrap</span>
                </div>
              </div>

              <div class="project-stats">
                <div class="stat">
                  <button class="post-action like-btn" data-post="2">
                    <i class="bi bi-star"></i>
                    <span style="font-size: 18px;">67 Likes</span>
                  </button>
                </div>
              </div>
            </div>

            <!-- Project 3 - Console App -->
            <div class="project-container">
              <div class="project-header">
                <img src="../../assets/img/team/sampleTeam.jpg" class="project-avatar" alt="User Avatar">
                <div class="project-author">
                  <p class="project-username">Valexore</p>
                  <p class="project-date">3 weeks ago</p>
                </div>
                <span class="project-badge console-badge" id="console">Console App</span>
              </div>

              <div class="project-content">
                <h3 class="project-title">Scientific Calculator</h3>
                <p class="project-description">
                  A executable console application that performs advanced mathematical
                  calculations with a unique spiral design.
                </p>

                <div class="project-media">
                  <img src="../../assets/img/events/project-console-example.png" class="project-image" alt="Console Screenshot">
                  <div class="project-links">
                    <a href="#" class="project-link"><i class="bi bi-download"></i> Executable</a>
                    <a href="#" class="project-link"><i class="bi bi-github"></i> Source Code</a>
                  </div>
                </div>

                <div class="project-tech">
                  <span class="tech-tag">Visual Basic</span>
                  <span class="tech-tag">dotNet</span>
                  <span class="tech-tag">Algorithms</span>
                </div>
              </div>

              <div class="project-stats">
                <div class="stat">
                  <button class="post-action like-btn" data-post="2">
                    <i class="bi bi-star"></i>
                    <span style="font-size: 18px;">67 Likes</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-3 d-none d-sm-block">
          <div class="right-sidebar">

            <!-- Project Upload -->
            <div class="sidebar-card mb-3">
              <h2>Student Projects</h2>
              <button class="btn btn-primary" id="uploadProjectBtn">
                <i class="bi bi-upload me-2"></i>Upload New Project
              </button>
            </div>

            <!-- Accordion Starts Here -->
            <div class="accordion" id="rightSidebarAccordion">

              <!-- Project Categories Accordion -->
              <div class="accordion-item sidebar-card">
                <h2 class="accordion-header" id="headingCategories">
                  <button class="accordion-button custom-accordion collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="false" aria-controls="collapseCategories">
                    Project Categories
                  </button>
                </h2>
                <div id="collapseCategories" class="accordion-collapse collapse" aria-labelledby="headingCategories" data-bs-parent="#rightSidebarAccordion">
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

              <!-- Trending Projects Accordion -->
              <div class="accordion-item sidebar-card">
                <h2 class="accordion-header" id="headingTrending">
                  <button class="accordion-button custom-accordion collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTrending" aria-expanded="false" aria-controls="collapseTrending">
                    Top 3 Trending Projects
                  </button>
                </h2>
                <div id="collapseTrending" class="accordion-collapse collapse" aria-labelledby="headingTrending" data-bs-parent="#rightSidebarAccordion">
                  <div class="accordion-body">
                    <!-- Trending project items -->
                    <div class="trending-project">
                      <div class="trending-project-info">
                        <h5>Virtual Campus Tour</h5>
                        <p class="trending-project-author">by vr_enthusiast</p>
                        <div class="trending-project-stats">
                          <span><i class="bi bi-star-fill"></i> 210</span>
                        </div>
                      </div>
                      <img src="../../assets/img/team/tung-tung-tung-sahur.png" alt="Trending Project" class="project-avatar">
                    </div>
                    <div class="trending-project">
                      <div class="trending-project-info">
                        <h5>Code Collab Platform</h5>
                        <p class="trending-project-author">by team_coders</p>
                        <div class="trending-project-stats">
                          <span><i class="bi bi-star-fill"></i> 187</span>
                        </div>
                      </div>
                      <img src="../../assets/img/team/sampleTeam.jpg" class="project-avatar" alt="User Avatar">
                    </div>
                    <div class="trending-project">
                      <div class="trending-project-info">
                        <h5>AR Chemistry Lab</h5>
                        <p class="trending-project-author">by science_tech</p>
                        <div class="trending-project-stats">
                          <span><i class="bi bi-star-fill"></i> 156</span>
                        </div>
                      </div>
                      <img src="../../assets/img/team/sampleTeam.jpg" class="project-avatar" alt="User Avatar">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Resources Accordion -->
              <div class="accordion-item sidebar-card">
                <h2 class="accordion-header" id="headingResources">
                  <button class="accordion-button custom-accordion fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseResources" aria-expanded="false" aria-controls="collapseResources">
                    Project Resources
                  </button>
                </h2>
                <div id="collapseResources" class="accordion-collapse collapse" aria-labelledby="headingResources" data-bs-parent="#rightSidebarAccordion">
                  <div class="accordion-body">
                    <!-- Resource items -->
                    <div class="resource-item">
                      <i class="bi bi-book resource-icon"></i>
                      <div class="resource-info">
                        <h5>Project Guidelines</h5>
                        <p>How to structure your student project</p>
                      </div>
                    </div>
                    <div class="resource-item">
                      <i class="bi bi-tools resource-icon"></i>
                      <div class="resource-info">
                        <h5>Development Tools</h5>
                        <p>Recommended tools for students</p>
                      </div>
                    </div>
                    <div class="resource-item">
                      <i class="bi bi-lightbulb resource-icon"></i>
                      <div class="resource-info">
                        <h5>Project Ideas</h5>
                        <p>Inspiration for your next project</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div> <!-- End Accordion -->

          </div>
        </div>

      </div>

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

      <!-- Bottom Navigation Bar (for md and below) -->
      <nav class="d-lg-none fixed-bottom bg-light border-top">
        <div class="d-flex justify-content-around py-2">
          <a href="../../pages-to-accounts/for-students/student-dashboard.php" class="text-center mt-2">
            <i class="ri-home-9-line fs-1"></i>
          </a>
          <a href="../../pages-to-accounts/for-students/project-studs.php" class="text-center mt-2 btn-active-mobile">
            <i class="ri-shapes-line fs-1"></i>
          </a>
          <a id="uploadProjectBtn" class="text-center mt-2">
            <i class="ri-add-circle-line fs-1"></i>
          </a>
          <a href="#" id="createPostTrigger" class="text-center mt-2">
            <i class="ri-notification-3-line fs-1"></i>
          </a>
          <a href="../../pages-to-accounts/for-students/settings-studs.php" class="text-center mt-2">
            <i class="ri-settings-line fs-1"></i>
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
                <img src="../../assets/img/team/sampleTeam.jpg" class="project-avatar me-2" alt="User Avatar">
                <div>
                  <h6 class="mb-0">Code Collab Platform</h6>
                  <small>by team_coders</small><br>
                  <i class="bi bi-star-fill text-warning"></i> 187
                </div>
              </div>
              <div class="trending-project d-flex mb-3">
                <img src="../../assets/img/team/sampleTeam.jpg" class="project-avatar me-2" alt="User Avatar">
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
      <!-- Search modal -->
      <div class="search-popup">
        <div class="search-container">
          <div class="search-input-container">
            <input type="text" placeholder="Search projects..." class="search-input">
            <button class="search-button"><i class="bi bi-search"></i></button>
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
      <script src="../for-students/js/studs-search.js"></script>
      <script src="../for-students/js/project-upload.js"></script>

      <!-- Main JS File -->
      <script src="../for-students/js/project-studs.js"></script>
</body>

</html>