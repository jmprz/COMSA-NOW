<?php
require_once "../../../backend/config/session.php";
require_once '../../../backend/middleware/student_middleware.php';


$name = htmlspecialchars($_SESSION['user_name']);
$email = htmlspecialchars($_SESSION['user_email']);
$studentNumber = htmlspecialchars($_SESSION['user_student_number']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>COMSA-NOW - Student Dashboard</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../..//assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/favicon/site.webmanifest">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
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
  <link rel="stylesheet" href="../../assets/css/login-form.css">
  <link rel="stylesheet" href="../../assets/css/search.css">
  <link rel="stylesheet" href="../../assets/css/student-dash.css">
  <link rel="stylesheet" href="../../assets/css/dark-mode.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>


<body class="index-page">


  <!-- Search modal -->
  </div>
  <div class="search-popup">
    <div class="search-container">
      <div class="search-input-container">
        <input type="text" placeholder="Search..." class="search-input">
        <button class="search-button"><i class="bi bi-search"></i></button>
      </div>
    </div>
  </div> <!-- search modal end -->


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
            </div>

            <!-- Nav Menu -->
            <div class="side-nav-menu d-flex flex-column gap-3">
              <a href="#" class="btn text-start d-flex align-items-center gap-2 btn-active">
                <i class="ri-home-9-line"></i> <span>Home</span>
              </a>
              <a href="../../pages-to-accounts/for-students/project-studs.php" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-shapes-line"></i> <span>Projects</span>
              </a>
              <a href="#" id="search-toggle" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-search-line"></i> <span>Search</span>
              </a>
              <a href="../../pages-to-accounts/for-students/profile-studs.php" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-user-line"></i> <span>Profile</span>
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

      <!-- Posts Column -->
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
                <img src="../assets/img/team/sampleTeam.jpg" class="rounded-circle" alt="Profile" style="width: 40px; height: 40px;">
              </button>
            </div>
          </div>

          <!-- Post 1 -->
          <div class="post-container">
            <div class="post-header">
              <img src="../../assets/img/team/sampleTeam.jpg" class="post-avatar" alt="User Avatar">
              <div class="d-flex row gy-0">
                <p class="project-username">john_perez</p>
                <p class="project-date">1 week ago</p>
              </div>
              <i class="bi bi-three-dots post-more"></i>
            </div>

            <img src="../../assets/img/csexpo.jpg" class="post-image" alt="Project Image">

            <div class="post-actions">
              <button class="post-action like-btn" data-post="1">
                <i class="bi bi-star"></i>
              </button>
              <button class="post-action comment-btn" data-post="1">
                <i class="bi bi-chat-left"></i>
              </button>
            </div>

            <div class="post-likes">1,243 likes</div>

            <div class="post-caption">
              <span class="post-caption-username">john_perez</span>
              Just launched our AI-powered campus navigation system! 🚀 #CSExpo2024 #AI #Innovation
            </div>

            <div class="post-comments" id="comments1">
              <div class="post-comment">
                <span class="post-comment-username">sarah_tech</span>
                This is amazing! How did you train the ML model?
              </div>
              <div class="post-comment">
                <span class="post-comment-username">mike_dev</span>
                Great work team! 👏
              </div>
            </div>

            <div class="post-time">2 DAYS AGO</div>

            <div class="post-add-comment" id="addComment1">
              <input type="text" class="comment-input" placeholder="Add a comment..." data-post="1">
              <button class="comment-submit" data-post="1">Post</button>
            </div>
          </div>

          <!-- Post 2 -->
          <div class="post-container">
            <div class="post-header">
              <img src="../../assets/img/team/sampleTeam.jpg" class="post-avatar" alt="User Avatar">
              <div class="d-flex row gy-0">
                <p class="project-username">john_perez</p>
                <p class="project-date">1 week ago</p>
              </div>
              <i class="bi bi-three-dots post-more"></i>
            </div>

            <img src="../../assets/img/comsayep.jpg" class="post-image" alt="Project Image">

            <div class="post-actions">
              <button class="post-action like-btn" data-post="2">
                <i class="bi bi-star"></i>
              </button>
              <button class="post-action comment-btn" data-post="2">
                <i class="bi bi-chat-left"></i>
              </button>
            </div>

            <div class="post-likes">892 likes</div>

            <div class="post-caption">
              <span class="post-caption-username">Eren_yeagar</span>
              Our event management system is now being used by 3 student organizations! 🎉 #WebDev #StudentProjects
            </div>

            <div class="post-comments" id="comments2">
              <div class="post-comment">
                <span class="post-comment-username">tech_guy</span>
                What stack did you use for this?
              </div>
            </div>

            <div class="post-time">1 WEEK AGO</div>

            <div class="post-add-comment" id="addComment2">
              <input type="text" class="comment-input" placeholder="Add a comment..." data-post="2">
              <button class="comment-submit" data-post="2">Post</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Sidebar -->
      <div class="col-lg-3 d-none d-sm-block">
        <div class="right-sidebar">
          <!-- Profile Card -->
          <div class="sidebar-card">
            <div class="profile-card">
              <!-- Avatar Image -->
              <img src="../../assets/img/team/sampleTeam.jpg" class="profile-avatar d-none" id="user-avatar" alt="Profile Avatar">

              <!-- Initials Fallback -->
              <div class="profile-avatar-initials d-none" id="avatar-initials"></div>

              <div class="profile-info">
                <h4><?= $name ?></h4>
                <p>Computer Science Student</p>
              </div>
            </div>

            <div class="profile-stats">
              <div class="stat-item">
                <div class="stat-number">24</div>
                <div class="stat-label">Projects</div>
              </div>
              <div class="stat-item">
                <div class="stat-number">156</div>
                <div class="stat-label">Following</div>
              </div>
              <div class="stat-item">
                <div class="stat-number">1.2K</div>
                <div class="stat-label">Followers</div>
              </div>
            </div>
          </div>

          <!-- Events Card -->
          <div class="sidebar-card">
            <div class="section-header">
              <h4>Upcoming Events</h4>
              <a href="#">View Calendar</a>
            </div>

            <div class="event-item">
              <div class="event-date">
                <span class="day">15</span>
                <span class="month">Jun</span>
              </div>
              <div class="event-info">
                <h5>CS Expo 2024</h5>
                <p>10:00 AM - 4:00 PM</p>
                <div class="event-location">
                  <i class="bi bi-geo-alt"></i>
                  <span>University Main Hall</span>
                </div>
              </div>
            </div>

            <div class="event-item">
              <div class="event-date">
                <span class="day">22</span>
                <span class="month">Jun</span>
              </div>
              <div class="event-info">
                <h5>Hackathon Workshop</h5>
                <p>2:00 PM - 5:00 PM</p>
                <div class="event-location">
                  <i class="bi bi-geo-alt"></i>
                  <span>Computer Lab B</span>
                </div>
              </div>
            </div>

            <div class="event-item">
              <div class="event-date">
                <span class="day">30</span>
                <span class="month">Jun</span>
              </div>
              <div class="event-info">
                <h5>Tech Career Fair</h5>
                <p>9:00 AM - 3:00 PM</p>
                <div class="event-location">
                  <i class="bi bi-geo-alt"></i>
                  <span>Student Center</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Links Card -->
          <div class="sidebar-card">
            <div class="section-header">
              <h4>Quick Links</h4>
            </div>

            <div class="suggestion-item" style="padding: 10px 0;">
              <i class="bi bi-link-45deg" style="font-size: 20px; color: #7db832; margin-right: 15px;"></i>
              <div class="suggestion-info">
                <h5>Course Materials</h5>
              </div>
            </div>

            <div class="suggestion-item" style="padding: 10px 0;">
              <i class="bi bi-link-45deg" style="font-size: 20px; color: #7db832; margin-right: 15px;"></i>
              <div class="suggestion-info">
                <h5>Student Resources</h5>
              </div>
            </div>

            <div class="suggestion-item" style="padding: 10px 0;">
              <i class="bi bi-link-45deg" style="font-size: 20px; color: #7db832; margin-right: 15px;"></i>
              <div class="suggestion-info">
                <h5>Research Opportunities</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="postTypeModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="overflow: hidden; border-radius: 16px;">
          <!-- Elegant Modal Header -->
          <div class="modal-header border-0 py-4 position-relative"
            style="background: linear-gradient(135deg, var(--accent-color) 0%, #5a9e2a 100%);">
            <div class="position-absolute top-0 end-0 me-3 mt-2">
              <button type="button" class="btn-close btn-close-white btn-close-white-fade" data-bs-dismiss="modal"
                aria-label="Close"></button>
            </div>
            <div class="text-center w-100">
              <h5 class="modal-title text-white mb-0 fw-semibold"
                style="font-family: var(--heading-font); letter-spacing: 0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <i class="bi bi-plus-circle-fill me-2"></i>Create New Post
              </h5>
              <div class="d-flex justify-content-center mt-2">
                <div style="width: 40px; height: 3px; background: rgba(255,255,255,0.5); border-radius: 3px;"></div>
              </div>
            </div>
          </div>

          <!-- Modal Body with Beautiful Cards -->
          <div class="modal-body px-4 py-4" style="background-color: #f9fbf7;">
            <h6 class="text-center mb-4"
              style="color: var(--heading-color); font-family: var(--default-font); font-weight: 500; letter-spacing: 0.3px;">
              Select your post type to continue
            </h6>

            <div class="row g-4 justify-content-center">
              <!-- Normal Post Card -->
              <div class="col-md-6">
                <a href="normal-post.html" class="text-decoration-none">
                  <div class="card border-0 h-100 post-type-option"
                    style="border-radius: 12px; background-color: var(--surface-color);">
                    <div class="card-body text-center p-4 position-relative">
                      <div class="position-absolute top-0 start-0 p-3">
                        <div class="rounded-circle"
                          style="width: 8px; height: 8px; background-color: var(--accent-color);"></div>
                      </div>
                      <div class="icon-wrapper mb-3"
                        style="background: linear-gradient(135deg, rgba(125, 184, 50, 0.1) 0%, rgba(125, 184, 50, 0.05) 100%); width: 80px; height: 80px; border-radius: 24px; display: flex; align-items: center; justify-content: center; margin: 0 auto; transform: rotate(45deg);">
                        <i class="bi bi-file-earmark-text fs-2"
                          style="color: var(--accent-color); transform: rotate(-45deg);"></i>
                      </div>
                      <h6 class="mb-2"
                        style="color: var(--heading-color); font-family: var(--heading-font); font-weight: 600;">Normal
                        Post</h6>
                      <p class="small text-muted mb-0 px-2" style="font-family: var(--default-font); line-height: 1.5;">
                        Share updates, thoughts, or general information with your audience
                      </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 py-3 text-center">
                      <span class="select-badge">
                        Choose this style
                        <i class="bi bi-arrow-right-short ms-1"></i>
                      </span>
                    </div>
                  </div>
                </a>
              </div>

              <!-- Project Post Card -->
              <div class="col-md-6">
                <a href="project-post.html" class="text-decoration-none">
                  <div class="card border-0 h-100 post-type-option"
                    style="border-radius: 12px; background-color: var(--surface-color);">
                    <div class="card-body text-center p-4 position-relative">
                      <div class="position-absolute top-0 start-0 p-3">
                        <div class="rounded-circle"
                          style="width: 8px; height: 8px; background-color: var(--accent-color);"></div>
                      </div>
                      <div class="icon-wrapper mb-3"
                        style="background: linear-gradient(135deg, rgba(125, 184, 50, 0.1) 0%, rgba(125, 184, 50, 0.05) 100%); width: 80px; height: 80px; border-radius: 24px; display: flex; align-items: center; justify-content: center; margin: 0 auto; transform: rotate(45deg);">
                        <i class="bi bi-file-earmark-ppt fs-2"
                          style="color: var(--accent-color); transform: rotate(-45deg);"></i>
                      </div>
                      <h6 class="mb-2"
                        style="color: var(--heading-color); font-family: var(--heading-font); font-weight: 600;">Project
                        Post</h6>
                      <p class="small text-muted mb-0 px-2" style="font-family: var(--default-font); line-height: 1.5;">
                        Showcase your work with detailed descriptions, media, and progress
                      </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 py-3 text-center">
                      <span class="select-badge">
                        Choose this style
                        <i class="bi bi-arrow-right-short ms-1"></i>
                      </span>
                    </div>
                  </div>
                </a>
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
          <i class="ri-home-9-line fs-1"></i>
        </a>
        <a href="../../pages-to-accounts/project-studs.php" class="text-center mt-2">
          <i class="ri-shapes-line fs-1"></i>
        </a>
        <a href="#" class="text-center mt-2">
          <i class="ri-add-circle-line fs-1"></i>
        </a>
        <a href="#" id="createPostTrigger" class="text-center mt-2">
          <i class="ri-notification-3-line fs-1"></i>
        </a>
        <a href="../pages-to-accounts/for-students/settings-studs.php" class="text-center mt-2">
          <i class="ri-settings-line fs-1"></i>
        </a>
      </div>
    </nav>

    <!-- Profile Modal for Mobile -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-slideout modal-sm m-0 ms-auto">
        <div class="modal-content vh-100">
          <div class="modal-header">
            <h5 class="modal-title" id="profileModalLabel">Your Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Clone of Right Sidebar -->
            <div class="right-sidebar">

              <!-- Profile Card -->
              <div class="sidebar-card">
                <div class="profile-card">
                  <img src="../../assets/img/team/sampleTeam.jpg" class="profile-avatar" alt="Profile Avatar">
                  <div class="profile-info">
                    <h4>your_username</h4>
                    <p>Computer Science Student</p>
                  </div>
                </div>

                <div class="profile-stats">
                  <div class="stat-item">
                    <div class="stat-number">24</div>
                    <div class="stat-label">Projects</div>
                  </div>
                  <div class="stat-item">
                    <div class="stat-number">156</div>
                    <div class="stat-label">Following</div>
                  </div>
                  <div class="stat-item">
                    <div class="stat-number">1.2K</div>
                    <div class="stat-label">Followers</div>
                  </div>
                </div>
              </div>

              <!-- Events Card -->
              <div class="sidebar-card">
                <div class="section-header">
                  <h4>Upcoming Events</h4>
                  <a href="#">View Calendar</a>
                </div>

                <!-- ... same event items ... -->
              </div>

              <!-- Quick Links Card -->
              <div class="sidebar-card">
                <div class="section-header">
                  <h4>Quick Links</h4>
                </div>

                <!-- ... same suggestion items ... -->
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
    <script src="../for-students/js/studs-search.js"></script>

    <script src="../../assets/js/studs-main-func.js"></script>

</body>

</html>