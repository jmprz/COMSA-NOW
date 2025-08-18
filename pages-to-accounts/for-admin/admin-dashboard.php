<?php
require_once '../../../backend/middleware/admin_middleware.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>COMSA-NOW - Admin Dashboard</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../../assets/img/favicon/site.webmanifest">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../../assets/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/admin-dash.css">
  <link rel="stylesheet" href="../../assets/css/dark-mode.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    /* Admin Dashboard Specific Styles */
    /* Layout */
    .admin-content {
      background-color: #f8f9fa;
      min-height: 100vh;
    }

    /* Stats Cards */
    .stat-card {
      border-radius: 10px;
      border: none;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }

    .stat-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
    }

    .bg-primary-light {
      background-color: rgba(13, 110, 253, 0.1);
    }

    .bg-success-light {
      background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-warning-light {
      background-color: rgba(255, 193, 7, 0.1);
    }

    .bg-info-light {
      background-color: rgba(13, 202, 240, 0.1);
    }

    /* Tables */
    .table {
      font-size: 0.9rem;
    }

    .table th {
      font-weight: 600;
      color: #495057;
      border-bottom-width: 2px;
    }

    /* Cards */
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      margin-bottom: 20px;
    }

    .card-header {
      background-color: #fff;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      padding: 15px 20px;
    }

    .card-header h5 {
      font-weight: 600;
      font-size: 1.1rem;
      margin: 0;
    }

    /* Buttons */
    .btn-sm {
      padding: 0.25rem 0.5rem;
      font-size: 0.8rem;
    }

    /* Tabs */
    .nav-tabs {
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .nav-tabs .nav-link {
      border: none;
      color: #6c757d;
      font-weight: 500;
      padding: 0.5rem 1rem;
    }

    .nav-tabs .nav-link.active {
      color: #7db832;
      border-bottom: 2px solid #7db832;
      background-color: transparent;
    }

    /* Activity Feed */
    .activity-item {
      padding: 10px 0;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .activity-item:last-child {
      border-bottom: none;
    }

    .activity-icon {
      font-size: 1.2rem;
    }

    .activity-content p {
      margin-bottom: 0.2rem;
    }

    /* Badges */
    .badge {
      font-weight: 500;
      padding: 0.35em 0.5em;
    }

    /* Dark Mode Styles */
    body.dark-mode .admin-content {
      background-color: #121212;
    }

    body.dark-mode .side-nav {
      background-color: #1e1e1e;
      color: #e0e0e0;
    }

    body.dark-mode .card,
    body.dark-mode .stat-card,
    body.dark-mode .table {
      background-color: #1e1e1e;
      color: #e0e0e0;
    }

    body.dark-mode .card-header,
    body.dark-mode .table th {
      background-color: #252525;
      color: #e0e0e0;
      border-color: #333;
    }

    body.dark-mode .table td {
      border-color: #333;
    }

    body.dark-mode .nav-tabs {
      border-color: #333;
    }

    body.dark-mode .nav-tabs .nav-link {
      color: #aaa;
    }

    body.dark-mode .nav-tabs .nav-link.active {
      color: #7db832;
    }

    body.dark-mode .activity-item {
      border-color: #333;
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select {
      background-color: #252525;
      border-color: #333;
      color: #e0e0e0;
    }

    body.dark-mode .form-control:focus,
    body.dark-mode .form-select:focus {
      background-color: #252525;
      color: #e0e0e0;
    }

    body.dark-mode .list-group-item {
      background-color: #252525;
      border-color: #333;
      color: #e0e0e0;
    }

    body.dark-mode .text-muted {
      color: #999 !important;
    }

    /* Events Table Styles */
    #eventsTable img.img-thumbnail {
      max-width: 80px;
      height: auto;
    }

    .event-preview-img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .event-preview-title {
      font-size: 1.5rem;
      margin-bottom: 10px;
    }

    .event-preview-desc {
      white-space: pre-line;
      margin-bottom: 15px;
    }

    .event-preview-dates {
      color: #6c757d;
      font-size: 0.9rem;
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
              <a href="#" class="btn text-start d-flex align-items-center gap-2 btn-active active">
                <i class="ri-dashboard-line"></i> <span>Dashboard</span>
              </a>
              <a href="account-for-students.php" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-group-line"></i> <span>Students</span>
              </a>
              <a href="posting-config-admin.php" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-file-text-line"></i> <span>Posts</span>
              </a>
              <a href="project-config-admin.php" class="btn text-start d-flex align-items-center gap-2 btn-active">
                <i class="ri-projector-line"></i> <span>Projects</span>
              </a>
              <a href="#settings-section" class="btn text-start d-flex align-items-center gap-2">
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
            <button type="button" class="btn p-0 border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#adminProfileModal">
              <img src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle" alt="Profile" style="width: 40px; height: 40px;">
            </button>
          </div>
        </div>

        <!-- Dashboard Content -->
        <div class="admin-content p-4">
          <!-- Dashboard Overview -->
          <div class="row mb-4">
            <div class="col-12">
              <h2 class="fw-bold mb-4">Admin Dashboard</h2>
            </div>

            <!-- Stats Cards -->
            <div class="col-md-3 mb-4">
              <div class="card stat-card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h6 class="text-muted mb-2">Total Students</h6>
                      <h3 class="mb-0">1,245</h3>
                    </div>
                    <div class="stat-icon bg-primary-light">
                      <i class="ri-group-fill text-primary"></i>
                    </div>
                  </div>
                  <div class="mt-3">
                    <span class="text-success"><i class="ri-arrow-up-line"></i> 12.5%</span>
                    <span class="text-muted ms-2">vs last month</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3 mb-4">
              <div class="card stat-card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h6 class="text-muted mb-2">Active Posts</h6>
                      <h3 class="mb-0">24</h3>
                    </div>
                    <div class="stat-icon bg-success-light">
                      <i class="ri-file-text-fill text-success"></i>
                    </div>
                  </div>
                  <div class="mt-3">
                    <span class="text-success"><i class="ri-arrow-up-line"></i> 3.2%</span>
                    <span class="text-muted ms-2">vs last month</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3 mb-4">
              <div class="card stat-card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h6 class="text-muted mb-2">Active Events</h6>
                      <h3 class="mb-0">5</h3>
                    </div>
                    <div class="stat-icon bg-warning-light">
                      <i class="ri-calendar-event-fill text-warning"></i>
                    </div>
                  </div>
                  <div class="mt-3">
                    <span class="text-danger"><i class="ri-arrow-down-line"></i> 2.1%</span>
                    <span class="text-muted ms-2">vs last month</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3 mb-4">
              <div class="card stat-card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h6 class="text-muted mb-2">Engagement</h6>
                      <h3 class="mb-0">78%</h3>
                    </div>
                    <div class="stat-icon bg-info-light">
                      <i class="ri-line-chart-fill text-info"></i>
                    </div>
                  </div>
                  <div class="mt-3">
                    <span class="text-success"><i class="ri-arrow-up-line"></i> 5.7%</span>
                    <span class="text-muted ms-2">vs last month</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Management Section -->
          <div class="card mb-4" id="content-section">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Content Management</h5>
              <div>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addQuickLinkModal">
                  <i class="ri-link"></i> Add Quick Link
                </button>
                <button class="btn btn-success btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addEventModal">
                  <i class="ri-calendar-event-line"></i> Add Event
                </button>
              </div>
            </div>
            <div class="card-body">
              <ul class="nav nav-tabs mb-4" id="contentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="links-tab" data-bs-toggle="tab" data-bs-target="#links-tab-pane" type="button" role="tab">Quick Links</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="announcements-tab" data-bs-toggle="tab" data-bs-target="#announcements-tab-pane" type="button" role="tab">Announcements</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="events-tab" data-bs-toggle="tab" data-bs-target="#events-tab-pane" type="button" role="tab">Events</button>
                </li>
              </ul>

              <div class="tab-content" id="contentTabsContent">
                <div class="tab-pane fade" id="links-tab-pane" role="tabpanel">
                  <div class="table-responsive">
                    <table id="link-table" class="table table-hover">
                      <thead id="link-table-head" class="">
                        <tr>
                          <th>ID</th>
                          <th>Title</th>
                          <th>URL</th>
                          <th>Category</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody id="link-table-body">
                        <!-- this is where the quick links are inserted from database -->
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="announcements-tab-pane" role="tabpanel">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Title</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Priority</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>ANN001</td>
                          <td>System Maintenance</td>
                          <td>15 Jun 2024</td>
                          <td>16 Jun 2024</td>
                          <td><span class="badge bg-danger">High</span></td>
                          <td><span class="badge bg-success">Active</span></td>
                          <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="ri-edit-line"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td>ANN002</td>
                          <td>Registration Deadline</td>
                          <td>10 Jun 2024</td>
                          <td>10 Jun 2024</td>
                          <td><span class="badge bg-warning">Medium</span></td>
                          <td><span class="badge bg-secondary">Expired</span></td>
                          <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="ri-edit-line"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td>ANN003</td>
                          <td>New Scholarship Opportunity</td>
                          <td>1 Jul 2024</td>
                          <td>31 Jul 2024</td>
                          <td><span class="badge bg-info">Low</span></td>
                          <td><span class="badge bg-warning">Scheduled</span></td>
                          <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="ri-edit-line"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade show active" id="events-tab-pane" role="tabpanel">
                  <div class="table-responsive">
                    <table class="table table-hover" id="eventsTable">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Image</th>
                          <th>Title</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>EVT001</td>
                          <td>
                            <img src="../../assets/img/comsayep.jpg" class="img-thumbnail" width="80" alt="Event Image">
                          </td>
                          <td>COMSA YEP</td>
                          <td>15 May 2024</td>
                          <td>15 May 2024</td>
                          <td><span class="badge bg-success">Active</span></td>
                          <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="ri-edit-line"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                            <button class="btn btn-sm btn-outline-secondary"><i class="ri-eye-line"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td>EVT002</td>
                          <td>
                            <img src="../../assets/img/csexpo.jpg" class="img-thumbnail" width="80" alt="Event Image">
                          </td>
                          <td>CS Expo 2024</td>
                          <td>20 Apr 2024</td>
                          <td>21 Apr 2024</td>
                          <td><span class="badge bg-secondary">Ended</span></td>
                          <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="ri-edit-line"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                            <button class="btn btn-sm btn-outline-secondary"><i class="ri-eye-line"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td>EVT003</td>
                          <td>
                            <img src="../../assets/img/donationdrive.jpg" class="img-thumbnail" width="80" alt="Event Image">
                          </td>
                          <td>Donation Drive</td>
                          <td>10 Jun 2024</td>
                          <td>30 Jun 2024</td>
                          <td><span class="badge bg-warning">Upcoming</span></td>
                          <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="ri-edit-line"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                            <button class="btn btn-sm btn-outline-secondary"><i class="ri-eye-line"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td>EVT004</td>
                          <td>
                            <img src="../../assets/img/gawadkalinga.jpg" class="img-thumbnail" width="80" alt="Event Image">
                          </td>
                          <td>CCS Extension</td>
                          <td>15 Aug 2024</td>
                          <td>15 Aug 2024</td>
                          <td><span class="badge bg-info">Scheduled</span></td>
                          <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="ri-edit-line"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                            <button class="btn btn-sm btn-outline-secondary"><i class="ri-eye-line"></i></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
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
      <a href="#" class="text-center mt-2 btn-active-mobile">
        <i class="ri-dashboard-line fs-1"></i>
      </a>
      <a href="#students-section" class="text-center mt-2">
        <i class="ri-group-line fs-1"></i>
      </a>
      <a href="posts.html" class="text-center mt-2">
        <i class="ri-file-text-line fs-1"></i>
      </a>
      <a href="#content-section" class="text-center mt-2">
        <i class="ri-calendar-event-line fs-1"></i>
      </a>
      <a href="#settings-section" class="text-center mt-2">
        <i class="ri-settings-line fs-1"></i>
      </a>
    </div>
  </nav>

  <!-- Add Student Modal -->
  <div class="modal fade" id="addStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="studentFirstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="studentFirstName" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="studentLastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="studentLastName" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="studentEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="studentEmail" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="studentID" class="form-label">Student ID</label>
                <input type="text" class="form-control" id="studentID" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="studentPhoto" class="form-label">Profile Photo</label>
              <input class="form-control" type="file" id="studentPhoto">
            </div>

            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="sendWelcomeEmail">
              <label class="form-check-label" for="sendWelcomeEmail">Send welcome email with login details</label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Add Student</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Announcement Modal -->
  <div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create New Announcement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="announcementTitle" class="form-label">Title</label>
              <input type="text" class="form-control" id="announcementTitle" required>
            </div>

            <div class="mb-3">
              <label for="announcementContent" class="form-label">Content</label>
              <textarea class="form-control" id="announcementContent" rows="6" required></textarea>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="announcementStartDate" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="announcementStartDate" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="announcementEndDate" class="form-label">End Date</label>
                <input type="date" class="form-control" id="announcementEndDate" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="announcementPriority" class="form-label">Priority</label>
              <select class="form-select" id="announcementPriority" required>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="announcementStatus" class="form-label">Status</label>
              <select class="form-select" id="announcementStatus" required>
                <option value="draft">Draft</option>
                <option value="published">Published</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Create Announcement</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Quick Link Modal -->
  <div class="modal fade" id="addQuickLinkModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Quick Link</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="quickLinkForm">
            <div class="mb-3">
              <label for="linkTitle" class="form-label">Title</label>
              <input type="text" name="linkTitle" class="form-control" id="linkTitle" required>
            </div>

            <div class="mb-3">
              <label for="linkUrl" class="form-label">URL</label>
              <input type="url" name="linkUrl" class="form-control" id="linkUrl" required>
            </div>

            <div class="mb-3">
              <label for="linkCategory" class="form-label">Category</label>
              <select class="form-select" name="linkCategory" id="linkCategory" required>
                <option value="">Select Category</option>
                <option value="academic">Academic</option>
                <option value="support">Support</option>
                <option value="opportunity">Opportunity</option>
                <option value="resource">Resource</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="linkIcon" class="form-label">Icon (Optional)</label>
              <input type="text" name="linkIcon" class="form-control" id="linkIcon" placeholder="e.g., ri-book-line">
              <small class="text-muted">Use Remix Icon class names</small>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" form="quickLinkForm" id="quickBtn" class="btn btn-primary">Add Link</button>
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

      </div>
    </div>
  </div>

  <!-- Add/Edit Event Modal -->
  <div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="eventForm">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="eventTitle" class="form-label">Event Title</label>
                <input type="text" class="form-control" id="eventTitle" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="eventStatus" class="form-label">Status</label>
                <select class="form-select" id="eventStatus" required>
                  <option value="active">Active</option>
                  <option value="upcoming">Upcoming</option>
                  <option value="ended">Ended</option>
                  <option value="draft">Draft</option>
                </select>
              </div>
            </div>


            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="eventStartDate" class="form-label">Start Date</label>
                <input type="datetime-local" class="form-control" id="eventStartDate" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="eventEndDate" class="form-label">End Date</label>
                <input type="datetime-local" class="form-control" id="eventEndDate" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="eventImage" class="form-label">Event Image</label>
              <input type="file" class="form-control" id="eventImage" accept="image/*">
              <small class="text-muted">Recommended size: 1200x600px</small>
            </div>

            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="featureEvent">
                <label class="form-check-label" for="featureEvent">Feature this event in carousel</label>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="saveEventBtn">Save Event</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Preview Event Modal -->
  <div class="modal fade" id="previewEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Event Preview</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img src="../../assets/img/comsayep.jpg" class="event-preview-img" alt="Event Preview">
          <h4 class="event-preview-title">COMSA YEP: Tech Crews, First Quest</h4>
          <p class="event-preview-desc">The COMSA Year End Party celebrates the remarkable achievements of Computer Science Student Association leaders and imposes a deeper sense of leadership among them. It highlights the dedication of all student leaders under the program, recognizing their invaluable contributions to their respective roles. The event also focuses on strengthening the bonds within the community fostering a well connected and collaborative environment to each other.</p>
          <div class="event-preview-dates">
            <strong>Date:</strong> May 15, 2024<br>
            <strong>Time:</strong> 4:00 PM - 8:00 PM
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Admin Profile Modal for Mobile -->
  <div class="modal fade" id="adminProfileModal" tabindex="-1" aria-labelledby="adminProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout modal-sm m-0 ms-auto">
      <div class="modal-content vh-100">
        <div class="modal-header">
          <h5 class="modal-title" id="adminProfileModalLabel">Admin Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-4">
            <img src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle mb-3" width="100" height="100" alt="Admin Profile">
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

  <!-- Main JS File -->
  <script src="../../assets/js/main.js"></script>
  <script src="./js/admin-logout.js"></script>

  <!-- js modals api-->
  <script src="./js/quick-links.js"></script>

  <script>
    // Initialize DataTable for events
    $(document).ready(function() {
      $('#eventsTable').DataTable({
        responsive: true,
        columnDefs: [{
            responsivePriority: 1,
            targets: 0
          },
          {
            responsivePriority: 2,
            targets: 2
          },
          {
            responsivePriority: 3,
            targets: 7
          }
        ]
      });

      // Event form handling
      const eventForm = document.getElementById('eventForm');
      const saveEventBtn = document.getElementById('saveEventBtn');

      saveEventBtn.addEventListener('click', function() {
        if (eventForm.checkValidity()) {
          // Here you would typically send the data to your backend
          // For now, we'll just close the modal
          $('#addEventModal').modal('hide');

          // Show success message
          alert('Event saved successfully!');
        } else {
          eventForm.reportValidity();
        }
      });

      // Preview functionality
      document.querySelectorAll('.ri-eye-line').forEach(btn => {
        btn.addEventListener('click', function() {
          const row = this.closest('tr');
          const title = row.cells[2].textContent;
          const desc = row.cells[3].textContent;
          const imgSrc = row.cells[1].querySelector('img').src;

          // Update preview modal content
          document.querySelector('.event-preview-title').textContent = title;
          document.querySelector('.event-preview-img').src = imgSrc;

          // Show preview modal
          $('#previewEventModal').modal('show');
        });
      });

      // Dark mode toggle
      const darkModeToggle = document.createElement('button');
      darkModeToggle.className = 'btn btn-sm btn-outline-secondary ms-2';
      darkModeToggle.innerHTML = '<i class="ri-moon-line"></i>';
      darkModeToggle.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        this.innerHTML = document.body.classList.contains('dark-mode') ?
          '<i class="ri-sun-line"></i>' : '<i class="ri-moon-line"></i>';
      });
      document.querySelector('.card-header .d-flex').appendChild(darkModeToggle);
    });
  </script>
</body>

</html>