<?php
require_once "../../../backend/config/session.php";

require_once '../../../backend/middleware/student_middleware.php';


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>COMSA-NOW - Settings</title>
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
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link rel="stylesheet" href="../../assets/css/search.css">
  <link href="../../assets/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/login-form.css">
  <link rel="stylesheet" href="../../assets/css/student-dash.css">
    <link rel="stylesheet" href="../../assets/css/project-studs-design.css">  <!-- Also responsible for nav design-->
  <link rel="stylesheet" href="../../assets/css/dark-mode.css">
    <link rel="stylesheet" href="../../assets/css/search-profile-design.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="index-page">
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar (Left Column) -->
      <div class="col-md-2 d-none d-lg-block bg-light min-vh-100">
        <div class="side-nav py-4 px-3 d-flex flex-column justify-content h-100">
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
              <a href="../../pages-to-accounts/for-students/project-studs.php" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-shapes-line"></i> <span>Projects</span>
              </a>
              <a href="../../pages-to-accounts/for-students/studs-chat.php" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-chat-smile-3-line"></i> <span>Chat</span>
              </a>
              <a href="#" id="search-toggle" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-search-line"></i> <span>Search</span>
              </a>
              <a href="../../pages-to-accounts/for-students/profile-studs.php" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-user-line"></i> <span>Profile</span>
              </a>
              <a href="../../pages-to-accounts/for-students/settings-studs.php"
                class="btn text-start d-flex align-items-center gap-2 btn-active">
                <i class="ri-settings-line"></i> <span>Settings</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Settings Content (Right Column) -->
      <div class="col-lg-9 p-4">
        <div class="settings-container">
          <div class="settings-header">
            <h2><i class="bi bi-gear-fill"></i> Account Settings</h2>
            <p class="text-muted">Manage your account preferences and security</p>
          </div>

          <!-- Account Settings Section -->
          <div class="settings-section">
            <h3><i class="bi bi-person-circle"></i> Account Information</h3>

            <div class="settings-item">
              <div class="item-info">
                <h4>Profile Picture</h4>
                <p>Update your profile photo</p>
              </div>
              <div class="item-action">
                <button class="btn-settings" data-bs-toggle="modal" data-bs-target="#profilePicModal">Change</button>
              </div>
            </div>

            <div class="settings-item">
              <div class="item-info">
                <h4>Password</h4>
                <p>Last changed 3 months ago</p>
              </div>
              <div class="item-action">
                <button class="btn-settings">Change</button>
              </div>
            </div>
          </div>

          <!-- Privacy & Security Section -->
          <div class="settings-section">
            <h3><i class="bi bi-shield-lock"></i> Privacy & Security</h3>

            <div class="settings-item">
              <div class="item-info">
                <h4>Account Activity</h4>
                <p>View login history and active sessions</p>
              </div>
              <div class="item-action">
                <button class="btn-settings-outline" data-bs-toggle="modal"
                  data-bs-target="#accountActivityModal">View</button>
              </div>
            </div>
          </div>

          <!-- Preferences Section -->
          <div class="settings-section">
            <h3><i class="bi bi-sliders"></i> Preferences</h3>

            <div class="settings-item">
              <div class="item-info">
                <h4>Dark Mode</h4>
                <p>Switch between light and dark theme</p>
              </div>
              <div class="item-action">
                <label class="toggle-switch">
                  <input type="checkbox" id="darkModeToggle">
                  <span class="toggle-slider"></span>
                </label>
              </div>
            </div>
          </div>

          <!-- Support & About Section -->
          <div class="settings-section">
            <h3><i class="bi bi-info-circle"></i> Support & Information</h3>

            <div class="settings-item">
              <div class="item-info">
                <h4>Help Center</h4>
                <p>Get help with using COMSA-NOW</p>
              </div>
              <div class="item-action">
                <button class="btn-settings-outline">Visit</button>
              </div>
            </div>

            <div class="settings-item">
              <div class="item-info">
                <h4>Privacy Policy</h4>
                <p>Read our data privacy guidelines</p>
              </div>
              <div class="item-action">
                <button class="btn-settings-outline" data-bs-toggle="modal"
                  data-bs-target="#privacyPolicyModal">View</button>
              </div>
            </div>

            <div class="settings-item">
              <div class="item-info">
                <h4>Terms of Service</h4>
                <p>Review our terms and conditions</p>
              </div>
              <div class="item-action">
                <button class="btn-settings-outline" data-bs-toggle="modal" data-bs-target="#termsModal">View</button>
              </div>
            </div>

            <div class="settings-item">
              <div class="item-info">
                <h4>Report a Problem</h4>
                <p>Let us know about any issues</p>
              </div>
              <div class="item-action">
                <button class="btn-settings-outline">Contact</button>
              </div>
            </div>
          </div>
          <!-- About COMSA Section -->
          <div class="about-comsa">
            <h4>About COMSA</h4>
            <p>The Computer Science Students' Association (COMSA) is the official organization for Computer Science
              students at our university. We aim to foster a community of tech enthusiasts, provide learning
              opportunities, and bridge the gap between academia and industry through workshops, hackathons, and
              networking events.</p>
            <p>COMSA-NOW is our digital platform designed to connect students, showcase projects, and facilitate
              collaboration within the Computer Science community.</p>
          </div>

          <!-- Account Actions -->
          <div class="d-flex justify-content-end mt-4">
            <button id="logoutBtn" class="btn btn-danger">Log Out</button>
          </div>
        </div>
      </div>

      <!-- Bottom Navigation Bar (for md and below) -->
      <nav class="d-lg-none fixed-bottom bg-light border-top">
        <div class="d-flex justify-content-around py-2">
          <a href="../../pages-to-accounts/for-students/student-dashboard.php" class="text-center mt-2">
            <i class="ri-home-9-line fs-1"></i>
          </a>
          <a href="../../pages-to-accounts/for-students/project-studs.php" class="text-center mt-2">
            <i class="ri-shapes-line fs-1"></i>
          </a>
          <a href="#" class="text-center mt-2">
            <i class="ri-add-circle-line fs-1"></i>
          </a>
          <a href="#" id="createPostTrigger" class="text-center mt-2">
            <i class="ri-notification-3-line fs-1"></i>
          </a>
          <a href="../../pages-to-accounts/for-students/settings-studs.php" class="text-center mt-2 btn-active-mobile">
            <i class="ri-settings-line fs-1"></i>
          </a>
        </div>
      </nav>
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

    <!-- Profile Picture Modal -->
    <div class="modal fade" id="profilePicModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Change Profile Picture</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <div id="profilePicPreviewWrapper" class="d-flex justify-content-center mb-2">
              <img id="profilePicPreview" class="profile-pic-preview d-none" alt="Profile Picture">
              <div id="profileInitialsPreview" class="profile-avatar-initials d-none"></div>
            </div>
            <div class="mb-3">
              <input type="file" class="form-control" id="profilePicUpload" accept="image/*">
            </div>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-outline-secondary" id="removeProfilePic">Remove Current</button>
              <button class="btn btn-primary" id="saveProfilePic">Save Changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Account Activity Modal -->
    <div class="modal fade" id="accountActivityModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Account Activity</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="alert alert-info">
              <i class="bi bi-info-circle-fill"></i> This shows your recent login activity.
            </div>
            <table class="activity-table">
              <thead>
                <tr>
                  <th>Date & Time</th>
                  <th>Device</th>
                  <th>Location</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Just now</td>
                  <td>Chrome on Windows</td>
                  <td>Manila, PH</td>
                  <td><span class="badge bg-success">Active</span></td>
                </tr>
                <tr>
                  <td>2 hours ago</td>
                  <td>Safari on iPhone</td>
                  <td>Quezon City, PH</td>
                  <td><span class="badge bg-secondary">Logged out</span></td>
                </tr>
                <tr>
                  <td>Yesterday, 3:45 PM</td>
                  <td>Firefox on Linux</td>
                  <td>Makati, PH</td>
                  <td><span class="badge bg-secondary">Logged out</span></td>
                </tr>
                <tr>
                  <td>June 15, 10:30 AM</td>
                  <td>Edge on Windows</td>
                  <td>Cavite, PH</td>
                  <td><span class="badge bg-secondary">Logged out</span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div class="modal fade" id="privacyPolicyModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Privacy Policy</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="policy-content">
              <h4>1. Introduction</h4>
              <p>Welcome to COMSA-NOW. We are committed to protecting your personal information and your right to
                privacy. If you have any questions or concerns about this privacy notice, or our practices with regards
                to your personal information, please contact us.</p>

              <h4>2. Information We Collect</h4>
              <p>We collect personal information that you voluntarily provide to us when you register on the platform,
                express an interest in obtaining information about us or our products and services, when you participate
                in activities on the platform, or otherwise when you contact us.</p>

              <h4>3. How We Use Your Information</h4>
              <p>We use personal information collected via our platform for a variety of business purposes described
                below. We process your personal information for these purposes in reliance on our legitimate business
                interests, in order to enter into or perform a contract with you, with your consent, and/or for
                compliance with our legal obligations.</p>

              <h4>4. Will Your Information Be Shared With Anyone?</h4>
              <p>We only share information with your consent, to comply with laws, to provide you with services, to
                protect your rights, or to fulfill business obligations.</p>

              <h4>5. How Long Do We Keep Your Information?</h4>
              <p>We will only keep your personal information for as long as it is necessary for the purposes set out in
                this privacy notice, unless a longer retention period is required or permitted by law.</p>

              <h4>6. How Do We Keep Your Information Safe?</h4>
              <p>We have implemented appropriate technical and organizational security measures designed to protect the
                security of any personal information we process.</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Terms of Service Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Terms of Service</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="policy-content">
              <h4>1. Acceptance of Terms</h4>
              <p>By accessing or using the COMSA-NOW platform, you agree to be bound by these Terms of Service. If you
                do not agree to all the terms and conditions, then you may not access the platform or use any services.
              </p>

              <h4>2. User Responsibilities</h4>
              <p>You are responsible for maintaining the confidentiality of your account and password and for
                restricting access to your computer or device. You agree to accept responsibility for all activities
                that occur under your account or password.</p>

              <h4>3. Content Standards</h4>
              <p>You agree not to post content that is illegal, threatening, defamatory, abusive, harassing, degrading,
                intimidating, fraudulent, deceptive, invasive, racist, or contains any type of suggestive,
                inappropriate, or explicit language.</p>

              <h4>4. Intellectual Property</h4>
              <p>The platform and its original content, features, and functionality are and will remain the exclusive
                property of COMSA and its licensors. The platform is protected by copyright, trademark, and other laws.
              </p>

              <h4>5. Termination</h4>
              <p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason
                whatsoever, including without limitation if you breach the Terms.</p>

              <h4>6. Changes to Terms</h4>
              <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. We will
                provide notice of any changes by posting the new Terms on this page.</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Agree</button>
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
    <script src="./js/settings-logout.js"></script>
    <script src="./js/settings-config.js"></script>


  <script src="../for-students/js/profile-search-studs.js" defer></script> <!-- For Handleling search engine -->

    <!-- <script src="../../assets/js/studs-main-func.js"></script> -->

</body>

</html>