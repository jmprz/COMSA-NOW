<?php
require_once '../../../backend/middleware/admin_middleware.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>COMSA-NOW - Project Configuration</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/favicon/site.webmanifest">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../../assets/vendor/glightbox/js/glightbox.min.css" rel="stylesheet">
  <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../../assets/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/admin-dash.css">
  <link rel="stylesheet" href="../../assets/css/project-studs-design.css">
  <link rel="stylesheet" href="../../assets/css/dark-mode.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    .project-container-admin {
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 15px;
      background-color: #fff;
      margin-bottom: 20px;
    }

    .dark-mode .project-container-admin {
      background-color: #1e1e1e;
      border-color: #333;
    }

    .project-badge {
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    .game-badge {
      background-color: #ffc107;
      color: #212529;
    }

    .web-badge {
      background-color: #0d6efd;
      color: white;
    }

    .console-badge {
      background-color: #6c757d;
      color: white;
    }

    .mobile-badge {
      background-color: #6f42c1;
      color: white;
    }

    .ai-badge {
      background-color: #20c997;
      color: white;
    }

    .database-badge {
      background-color: #fd7e14;
      color: white;
    }

    .tech-tag {
      display: inline-block;
      background-color: #e9ecef;
      color: #495057;
      padding: 2px 8px;
      border-radius: 10px;
      font-size: 0.8rem;
      margin-right: 5px;
      margin-bottom: 5px;
    }

    .dark-mode .tech-tag {
      background-color: #333;
      color: #e0e0e0;
    }

    .project-link {
      display: inline-flex;
      align-items: center;
      color: #0d6efd;
      text-decoration: none;
      margin-right: 15px;
    }

    .dark-mode .project-link {
      color: #4dabf7;
    }

    .tab-content {
      padding: 20px 0;
    }

    .nav-tabs .nav-link.active {
      color: #7db832;
      border-bottom: 2px solid #7db832;
      background-color: transparent;
    }

    .dark-mode .nav-tabs .nav-link {
      color: #aaa;
    }

    .dark-mode .nav-tabs .nav-link.active {
      color: #7db832;
    }

    .project-image-admin {
      max-width: 100%;
      border-radius: 8px;
      margin: 10px 0;
    }

    .admin-actions {
      margin-top: 15px;
      padding-top: 15px;
      border-top: 1px solid #dee2e6;
    }

    .dark-mode .admin-actions {
      border-top-color: #333;
    }
  </style>
</head>

<body class="index-page">
  <!-- Main Content -->
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
              <span class="badge bg-success">Admin Panel</span>
            </div>

            <!-- Nav Menu -->
            <div class="side-nav-menu d-flex flex-column gap-3">
              <a href="admin-dashboard.php" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-dashboard-line"></i> <span>Dashboard</span>
              </a>
              <a href="account-for-students.php" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-group-line"></i> <span>Students</span>
              </a>
              <a href="posting-config-admin.php" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-file-text-line"></i> <span>Posts</span>
              </a>
              <a href="project-config-admin.php" class="btn text-start d-flex align-items-center gap-2 btn-active active">
                <i class="ri-projector-line"></i> <span>Projects</span>
              </a>
              <a href="admin-dashboard.php#settings-section" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-settings-line"></i> <span>Settings</span>
              </a>
              <a href="">
                <br>
                <button class="btn btn-sm btn-outline-danger" id="logoutBtn">Logout</button>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content Area -->
      <div class="col-lg-10">
        <!-- Mobile Only Header -->
        <div class="d-lg-none d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
          <div class="d-flex align-items-center">
            <h5 class="ms-2 mb-0 fw-bold">COMSA-NOW Admin</h5>
          </div>
          <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn p-0 border-0 bg-transparent" data-bs-toggle="modal"
              data-bs-target="#adminProfileModal">
              <img src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle" alt="Profile"
                style="width: 40px; height: 40px;">
            </button>
          </div>
        </div>

        <!-- Dashboard Content -->
        <div class="admin-content p-4">
          <!-- Project Management Header -->
          <!-- Project Management Header - Updated with Search Bar -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">Project Management</h2>
                <div class="d-flex gap-2">
                  <!-- Search Bar -->
                  <div class="input-group" style="width: 250px;">
                    <input type="text" class="form-control" placeholder="Search projects...">
                    <button class="btn btn-outline-secondary" type="button">
                      <i class="ri-search-line"></i>
                    </button>
                  </div>

                  <!-- Filter Button -->
                  <button class="btn btn-outline-secondary" data-bs-toggle="modal"
                    data-bs-target="#filterProjectsModal">
                    <i class="ri-filter-line"></i> Filter
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Project Management Tabs -->
          <div class="card mb-4">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs" id="projectManagementTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="all-projects-tab" data-bs-toggle="tab"
                    data-bs-target="#all-projects" type="button" role="tab">All Projects</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="games-tab" data-bs-toggle="tab" data-bs-target="#games" type="button"
                    role="tab">Games</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="websites-tab" data-bs-toggle="tab" data-bs-target="#websites"
                    type="button" role="tab">Websites</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="mobile-tab" data-bs-toggle="tab" data-bs-target="#mobile" type="button"
                    role="tab">Mobile Apps</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="console-tab" data-bs-toggle="tab" data-bs-target="#console" type="button"
                    role="tab">Console Apps</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="console-tab" data-bs-toggle="tab" data-bs-target="#aiml" type="button"
                    role="tab">Ai/ML</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="console-tab" data-bs-toggle="tab" data-bs-target="#database" type="button"
                    role="tab">Database</button>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="projectManagementTabsContent">

                <div id="editProjectDashUploadOverlay" class="position-absolute d-flex flex-column justify-content-center start-0 w-100 h-100 bg-light bg-opacity-75 d-none justify-content-center align-items-center" style="z-index: 1051;">
                  <div id="editProjectDashUploadLoader" class="text-center">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="mt-2 fw-semibold">Editing...</p>
                  </div>
                  <div id="editProjectDashUploadSuccess" class="text-center d-none">
                    <i class="bi bi-check-circle-fill text-success fs-1"></i>
                    <p class="mt-2 fw-semibold">Edit Successful!</p>
                  </div>
                </div>

                <div id="editProjectDashGeneralUploadError" class="text-danger fw-semibold text-center d-none mt-2"></div>
                <!-- All Projects Tab -->
                <div class="tab-pane fade show active" id="all-projects" role="tabpanel">
                  <!-- Project 1 - Game -->
                  <!-- <div class="project-container-admin">
                    <div class="project-header d-flex justify-content-between align-items-start">
                      <div class="d-flex align-items-center">
                        <img src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle me-2" width="40" height="40"
                          alt="User Avatar">
                        <div>
                          <h6 class="mb-0">Valexore</h6>
                          <small class="text-muted">2 days ago</small>
                        </div>
                      </div>
                      <span class="project-badge game-badge">Game</span>
                    </div>

                    <div class="project-content mt-3">
                      <h4 class="project-title">Cave Tactic RPG</h4>
                      <p class="project-description">
                        Darmnn if it happens, it happens...
                      </p>

                      <img src="../../assets/img/events/project-game-example.png" class="project-image-admin"
                        alt="Game Screenshot">

                      <div class="project-links mt-2">
                        <a href="#" class="project-link"><i class="ri-download-line"></i> Executable</a>
                        <a href="#" class="project-link"><i class="ri-github-fill"></i> Source Code</a>
                      </div>

                      <div class="project-tech mt-2">
                        <span class="tech-tag">Godot</span>
                        <span class="tech-tag">Python</span>
                        <span class="tech-tag">Pixel Graphics</span>
                      </div>

                      <div class="project-stats mt-2">
                        <div class="stat">
                          <i class="ri-star-fill text-success"></i>
                          <span>67 Likes</span>
                        </div>
                      </div>

                      <div class="admin-actions d-flex justify-content-end gap-2">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                          data-bs-target="#viewProjectModal">
                          <i class="ri-eye-line"></i> View
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                          data-bs-target="#editProjectModal">
                          <i class="ri-edit-line"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                          <i class="ri-delete-bin-line"></i> Delete
                        </button>
                      </div>
                    </div>
                  </div> -->
                </div>

                <!-- Games Tab -->
                <div class="tab-pane fade" id="games" role="tabpanel">
                  <!-- <div class="project-container-admin">
                    <div class="project-header d-flex justify-content-between align-items-start">
                      <div class="d-flex align-items-center">
                        <img src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle me-2" width="40" height="40"
                          alt="User Avatar">
                        <div>
                          <h6 class="mb-0">Valexore</h6>
                          <small class="text-muted">2 days ago</small>
                        </div>
                      </div>
                      <span class="project-badge game-badge">Game</span>
                    </div>

                    <div class="project-content mt-3">
                      <h4 class="project-title">Cave Tactic RPG</h4>
                      <p class="project-description">
                        Darmnn if it happens, it happens...
                      </p>

                      <img src="../../assets/img/events/project-game-example.png" class="project-image-admin"
                        alt="Game Screenshot">

                      <div class="project-links mt-2">
                        <a href="#" class="project-link"><i class="ri-download-line"></i> Executable</a>
                        <a href="#" class="project-link"><i class="ri-github-fill"></i> Source Code</a>
                      </div>

                      <div class="project-tech mt-2">
                        <span class="tech-tag">Godot</span>
                        <span class="tech-tag">Python</span>
                        <span class="tech-tag">Pixel Graphics</span>
                      </div>

                      <div class="project-stats mt-2">
                        <div class="stat">
                          <i class="ri-star-fill text-success"></i>
                          <span>67 Likes</span>
                        </div>
                      </div>

                      <div class="admin-actions d-flex justify-content-end gap-2">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                          data-bs-target="#viewProjectModal">
                          <i class="ri-eye-line"></i> View
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                          data-bs-target="#editProjectModal">
                          <i class="ri-edit-line"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                          <i class="ri-delete-bin-line"></i> Delete
                        </button>
                      </div>
                    </div>
                  </div> -->
                </div>

                <!-- Websites Tab -->
                <div class="tab-pane fade" id="websites" role="tabpanel">
                  <!-- <div class="project-container-admin">
                    <div class="project-header d-flex justify-content-between align-items-start">
                      <div class="d-flex align-items-center">
                        <img src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle me-2" width="40" height="40"
                          alt="User Avatar">
                        <div>
                          <h6 class="mb-0">Valexore</h6>
                          <small class="text-muted">1 week ago</small>
                        </div>
                      </div>
                      <span class="project-badge web-badge">Website</span>
                    </div>

                    <div class="project-content mt-3">
                      <h4 class="project-title">Vanstastic</h4>
                      <p class="project-description">
                        it was fustrating to received dos even tho you did all the best to create a fascinating website
                        such as Vantastic.
                      </p>

                      <img src="../../assets/img/events/project-web-example.png" class="project-image-admin"
                        alt="Website Screenshot">

                      <div class="project-links mt-2">
                        <a href="#" class="project-link"><i class="ri-global-line"></i> Live Demo</a>
                        <a href="#" class="project-link"><i class="ri-github-fill"></i> Source Code</a>
                      </div>

                      <div class="project-tech mt-2">
                        <span class="tech-tag">Php</span>
                        <span class="tech-tag">MySql</span>
                        <span class="tech-tag">Html</span>
                        <span class="tech-tag">Css</span>
                        <span class="tech-tag">Bootstrap</span>
                      </div>

                      <div class="project-stats mt-2">
                        <div class="stat">
                          <i class="ri-star-fill text-success"></i>
                          <span>67 Likes</span>
                        </div>
                      </div>

                      <div class="admin-actions d-flex justify-content-end gap-2">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                          data-bs-target="#viewProjectModal">
                          <i class="ri-eye-line"></i> View
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                          data-bs-target="#editProjectModal">
                          <i class="ri-edit-line"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                          <i class="ri-delete-bin-line"></i> Delete
                        </button>
                      </div>
                    </div>
                  </div> -->
                </div>

                <!-- Mobile Apps Tab -->
                <div class="tab-pane fade" id="mobile" role="tabpanel">
                  <!-- <div class="alert alert-info">
                    No mobile app projects found.
                  </div> -->
                </div>

                <!-- Console Apps Tab -->
                <div class="tab-pane fade" id="console" role="tabpanel">
                  <!-- <div class="project-container-admin">
                    <div class="project-header d-flex justify-content-between align-items-start">
                      <div class="d-flex align-items-center">
                        <img src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle me-2" width="40" height="40"
                          alt="User Avatar">
                        <div>
                          <h6 class="mb-0">Valexore</h6>
                          <small class="text-muted">3 weeks ago</small>
                        </div>
                      </div>
                      <span class="project-badge console-badge">Console App</span>
                    </div>

                    <div class="project-content mt-3">
                      <h4 class="project-title">Scientific Calculator</h4>
                      <p class="project-description">
                        A executable console application that performs advanced mathematical
                        calculations with a unique spiral design.
                      </p>

                      <img src="../../assets/img/events/project-console-example.png" class="project-image-admin"
                        alt="Console Screenshot">

                      <div class="project-links mt-2">
                        <a href="#" class="project-link"><i class="ri-download-line"></i> Executable</a>
                        <a href="#" class="project-link"><i class="ri-github-fill"></i> Source Code</a>
                      </div>

                      <div class="project-tech mt-2">
                        <span class="tech-tag">Visual Basic</span>
                        <span class="tech-tag">dotNet</span>
                        <span class="tech-tag">Algorithms</span>
                      </div>

                      <div class="project-stats mt-2">
                        <div class="stat">
                          <i class="ri-star-fill text-success"></i>
                          <span>67 Likes</span>
                        </div>
                      </div>

                      <div class="admin-actions d-flex justify-content-end gap-2">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                          data-bs-target="#viewProjectModal">
                          <i class="ri-eye-line"></i> View
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                          data-bs-target="#editProjectModal">
                          <i class="ri-edit-line"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                          <i class="ri-delete-bin-line"></i> Delete
                        </button>
                      </div>
                    </div>
                  </div> -->
                </div>


                <!-- Ai/ML Tab -->
                <div class="tab-pane fade" id="aiml" role="tabpanel">
                  <!-- <div class="alert alert-info">
                    No Ai/ML projects found.
                  </div> -->
                </div>


                <!-- database Tab -->
                <div class="tab-pane fade" id="database" role="tabpanel">
                  <!-- <div class="alert alert-info">
                    No Database projects found.
                  </div> -->
                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Navigation Bar (for md and below) -->
  <nav class="d-lg-none fixed-bottom bg-light border-top">
    <div class="d-flex justify-content-around py-2">
      <a href="admin-dashboard.php" class="text-center mt-2">
        <i class="ri-dashboard-line fs-1"></i>
      </a>
      <a href="admin-dashboard.php#students-section" class="text-center mt-2">
        <i class="ri-group-line fs-1"></i>
      </a>
      <a href="posting-config-admin.php" class="text-center mt-2">
        <i class="ri-file-text-line fs-1"></i>
      </a>
      <a href="project-config-admin.php" class="text-center mt-2 btn-active-mobile">
        <i class="ri-projector-line fs-1"></i>
      </a>
      <a href="admin-dashboard.php#settings-section" class="text-center mt-2">
        <i class="ri-settings-line fs-1"></i>
      </a>
    </div>
  </nav>

  <!-- Filter Projects Modal -->
  <div class="modal fade" id="filterProjectsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Filter Projects</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="filterType" class="form-label">Project Type</label>
              <select class="form-select" id="filterType">
                <option value="">All Types</option>
                <option value="game">Game</option>
                <option value="website">Website</option>
                <option value="mobile">Mobile App</option>
                <option value="console">Console App</option>
                <option value="ai">AI/ML</option>
                <option value="database">Database</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="filterAuthor" class="form-label">Author</label>
              <input type="text" class="form-control" id="filterAuthor" placeholder="Search by author">
            </div>

            <div class="mb-3">
              <label for="filterDate" class="form-label">Date Range</label>
              <div class="input-group">
                <input type="date" class="form-control" id="filterDateFrom">
                <span class="input-group-text">to</span>
                <input type="date" class="form-control" id="filterDateTo">
              </div>
            </div>

            <div class="mb-3">
              <label for="filterTech" class="form-label">Technology</label>
              <input type="text" class="form-control" id="filterTech" placeholder="e.g. React, Python">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Apply Filters</button>
        </div>
      </div>
    </div>
  </div>

  <!-- View Project Modal -->
  <div class="modal fade" id="viewProjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Project Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="project-header d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-center">
                  <img src="../../assets/img/team/sampleTeam.jpg" id="userAvatar" class="rounded-circle me-2" width="40" height="40"
                    alt="User Avatar">
                  <div>
                    <h6 class="mb-0" id="name">Valexore</h6>
                    <small class="text-muted" id="datePosted">2 days ago</small>
                  </div>
                </div>
                <span class="project-badge game-badge" id="category">Game</span>
              </div>

              <h3 id="title">Cave Tactic RPG</h3>

              <p id="description">Darmnn if it happens, it happens...</p>

              <div class="imageContainer">
                <img id="" src="../../assets/img/events/project-game-example.png" class="img-fluid rounded mb-3"
                  alt="Game Screenshot">
              </div>

              <div class="project-links mb-3" id="projectLinks">
                <a href="#" class="project-link"><i class="ri-download-line"></i> Executable</a>
                <a href="#" class="project-link"><i class="ri-github-fill"></i> Source Code</a>
              </div>

              <h5>Technologies Used</h5>
              <div class="mb-3" id="technologies">
              </div>

              <div class="project-stats mb-3">
                <div>
                  <i class="ri-star-fill text-success"></i>
                  <span id="viewLikeCount">67 Likes</span>
                </div>
                <div>
                  <i class="bi bi-chat-left text-success"></i>
                  <span id="viewCommentCount">67 Comments</span>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <h6 class="mb-0">Admin Actions</h6>
                </div>
                <div class="card-body">
                  <button class="btn btn-outline-secondary w-100 mb-2 editViewProjectBtn" id="editViewProjectBtn" data-bs-toggle="modal"
                    data-bs-target="#editProjectModal" data-bs-dismiss="modal">
                    <i class="ri-edit-line me-1"></i> Edit Project
                  </button>
                  <button class="btn btn-outline-danger w-100 deleteViewProjectBtn" id="deleteViewProjectBtn">
                    <i class="ri-delete-bin-line me-1"></i> Delete Project
                  </button>

                  <hr>

                  <!-- <div class="mb-3">
                    <label class="form-label">Project Visibility</label>
                    <select class="form-select">
                      <option>Public</option>
                      <option>Unlisted</option>
                      <option>Hidden</option>
                    </select>
                  </div> -->

                  <!-- <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="featuredToggle" checked>
                    <label class="form-check-label" for="featuredToggle">Featured Project</label>
                  </div> -->

                  <!-- <button class="btn btn-success w-100">
                    <i class="ri-save-line me-1"></i> Save Changes
                  </button> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Project Modal -->
  <div class="modal fade" id="editProjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Project</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="editProjectUploadOverlay" class="position-absolute d-flex flex-column justify-content-center start-0 w-100 h-100 bg-light bg-opacity-75 d-none justify-content-center align-items-center" style="z-index: 1051;">
            <div id="editProjectUploadLoader" class="text-center">
              <div class="spinner-border text-success" role="status"></div>
              <p class="mt-2 fw-semibold">Editing...</p>
            </div>
            <div id="editProjectUploadSuccess" class="text-center d-none">
              <i class="bi bi-check-circle-fill text-success fs-1"></i>
              <p class="mt-2 fw-semibold">Edit Successful!</p>
            </div>
          </div>

          <div id="editProjectGeneralUploadError" class="text-danger fw-semibold text-center d-none mt-2"></div>
          <form id="editProjectForm" enctype="multipart/form-data">
            <input type="hidden" name="projectId" id="editprojectId">
            <div class="row">
              <div class="col-md-8">
                <div class="mb-3">
                  <label for="editProjectTitle" class="form-label">Project Title</label>
                  <input type="text" class="form-control" name="editProjectTitle" id="editProjectTitle" value="Cave Tactic RPG">
                </div>

                <div class="mb-3">
                  <label for="editProjectDescription" class="form-label">Description</label>
                  <textarea class="form-control" name="editProjectDescription" id="editProjectDescription"
                    rows="3">Darmnn if it happens, it happens...</textarea>
                </div>

                <div class="mb-3">
                  <label for="editProjectType" class="form-label">Project Type</label>
                  <select class="form-select" name="editProjectType" id="editProjectType">
                    <option value="Games">Games</option>
                    <option value="Websites">Websites</option>
                    <option value="Mobile">Mobile App</option>
                    <option value="Console">Console App</option>
                    <option value="AI/ML">AI/ML</option>
                    <option value="Databases">Databases</option>
                    <option value="Others">Others</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="editProjectTech" class="form-label">Technologies Used</label>
                  <input type="text" name="editProjectTech" class="form-control" id="editProjectTech">
                  <div class="mt-2" id="techTagsContainer"><!-- JS will render here --></div>
                  <input type="hidden" id="hiddenTechInput" name="technologies"> <!-- store comma list -->
                </div>


                <div class="mb-3">
                  <label class="form-label">Project Images</label>
                  <div id="editImagesContainer" class="d-flex flex-wrap gap-2 mb-2">
                    <!-- JS will insert previews here -->
                  </div>
                  <input type="file" id="editProjectImageUpload" accept="image/*" multiple style="display: none;">
                  <button type="button" class="btn btn-sm btn-outline-secondary" id="changeProjectImageBtn">
                    <i class="ri-image-edit-line me-1"></i> Add Images
                  </button>
                  <small class="text-muted d-block">Max 8 images allowed</small>
                  <input type="hidden" id="hiddenImagesInput" name="project_images">
                </div>
              </div>

              <div class="col-md-4">
                <div class="card">
                  <div class="card-header">
                    <h6 class="mb-0">Project Settings</h6>
                  </div>
                  <div class="card-body">
                    <div class="mb-3">
                      <label class="form-label">Visibility</label>
                      <select id="editVisibility" name="editVisibility" class="form-select">
                        <option value="public">Public</option>
                        <option value="hidden">Hidden</option>
                      </select>
                    </div>

                    <div class="form-check form-switch mb-3">
                      <input class="form-check-input" name="editFeaturedToggle" type="checkbox" id="editFeaturedToggle">
                      <label class="form-check-label" for="editFeaturedToggle">Featured Project</label>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Project Links</label>
                      <div class="input-group mb-2">
                        <span class="input-group-text"><i class="ri-download-line"></i></span>
                        <input name="editDownload" id="editDownload" type="url" class="form-control" placeholder="Executable URL"
                          value="https://example.com/download">
                      </div>
                      <div class="input-group">
                        <span class="input-group-text"><i class="ri-github-fill"></i></span>
                        <input name="editGithub" id="editGithub" type="url" class="form-control" placeholder="Source Code URL"
                          value="https://github.com/example">
                      </div>
                      <div class="input-group mb-2">
                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                        <input name="editLive" id="editLive" type="url" class="form-control" placeholder="Executable URL"
                          value="https://example.com/download">
                      </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                      <i class="ri-save-line me-2"></i> Save Changes
                    </button>

                  </div>
                </div>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- Admin Profile Modal for Mobile -->
  <div class="modal fade" id="adminProfileModal" tabindex="-1" aria-labelledby="adminProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout modal-sm m-0 ms-auto">
      <div class="modal-content vh-100">
        <div class="modal-header">
          <h5 class="modal-title" id="adminProfileModalLabel">Admin Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-4">
            <img src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle mb-3" width="100" height="100"
              alt="Admin Profile">
            <h5>Admin User</h5>
            <p class="text-muted">System Administrator</p>
          </div>

          <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">
              <i class="ri-user-line me-2"></i> My Profile
            </a>
            <a href="#settings-section" class="list-group-item list-group-item-action" data-bs-dismiss="modal">
              <i class="ri-settings-line me-2"></i> Settings
            </a>
            <a href="#" class="list-group-item list-group-item-action">
              <i class="ri-notification-line me-2"></i> Notifications
            </a>
            <a href="#" class="list-group-item list-group-item-action text-danger">
              <i class="ri-logout-box-line me-2" id="logoutBtn"></i> Logout
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/aos/aos.js"></script>
  <script src="../../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


  <!-- main -->
  <script src="./js/admin-logout.js"></script>
  <script src="./js/project.js"></script>


  <!-- <script>
    // Project Search Functionality
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.querySelector('.input-group input[type="text"]');
      const searchButton = document.querySelector('.input-group button');
      const projectContainers = document.querySelectorAll('.project-container-admin');

      // Search when button is clicked
      searchButton.addEventListener('click', performSearch);

      // Search when Enter key is pressed
      searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
          performSearch();
        }
      });

      function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();

        projectContainers.forEach(project => {
          const title = project.querySelector('.project-title').textContent.toLowerCase();
          const description = project.querySelector('.project-description').textContent.toLowerCase();
          const author = project.querySelector('.project-header h6').textContent.toLowerCase();
          const techTags = Array.from(project.querySelectorAll('.tech-tag')).map(tag => tag.textContent.toLowerCase());

          const matches = title.includes(searchTerm) ||
            description.includes(searchTerm) ||
            author.includes(searchTerm) ||
            techTags.some(tag => tag.includes(searchTerm));

          project.style.display = matches ? 'block' : 'none';
        });
      }

      // Clear search when filter modal is opened (optional)
      document.getElementById('filterProjectsModal').addEventListener('show.bs.modal', function() {
        searchInput.value = '';
        projectContainers.forEach(project => {
          project.style.display = 'block';
        });
      });
    });
  </script> -->

  <!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Handle image change in edit project modal
      const changeProjectImageBtn = document.getElementById('changeProjectImageBtn');
      const editProjectImageUpload = document.getElementById('editProjectImageUpload');
      const editProjectImagePreview = document.getElementById('editProjectImagePreview');


      editProjectImageUpload.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
          const file = e.target.files[0];
          const reader = new FileReader();

          reader.onload = function(event) {
            editProjectImagePreview.src = event.target.result;
          };

          reader.readAsDataURL(file);
        }
      });

      // Handle technologies input
      const editProjectTech = document.getElementById('editProjectTech');
      const techTagsContainer = document.getElementById('techTagsContainer');

      editProjectTech.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
          e.preventDefault();
          const tech = this.value.trim();
          if (tech) {
            addTechnology(tech);
            this.value = '';
          }
        }
      });

      function addTechnology(tech) {
        const techElement = document.createElement('span');
        techElement.className = 'tech-tag';
        techElement.textContent = tech;
        techTagsContainer.appendChild(techElement);
      }

      // Form submission
      document.getElementById('editProjectForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Here you would normally send the form data to the server
        alert('Project updated successfully!');
        const editProjectModal = bootstrap.Modal.getInstance(document.getElementById('editProjectModal'));
        editProjectModal.hide();
      });

      // Dark mode toggle
      const darkModeToggle = document.getElementById('darkModeToggle');
      if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function() {
          document.body.classList.toggle('dark-mode');
          localStorage.setItem('darkMode', this.checked);
        });

        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
          document.body.classList.add('dark-mode');
          darkModeToggle.checked = true;
        }
      }
    });
  </script> -->
</body>

</html>