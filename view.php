<?php
require_once "../backend/config/session.php";
require_once "../backend/config/db.php";
require_once '../backend/middleware/student_middleware.php';

require_once "../backend/api/view-profile.php";


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>COMSA-NOW - Student Profile</title>
    <meta name="description" content="Student profile page to manage account settings and projects">
    <meta name="keywords" content="student profile, account settings, project management">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/img/favicon/site.webmanifest">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">


    <!-- Vendor CSS Files -->
    <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="./assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="./assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="./assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="./assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="./assets/css/dark-mode.css">
    <link rel="stylesheet" href="./assets/css/project-studs-design.css">
    <link rel="stylesheet" href="./assets/css/search-profile-design.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .view-only-badge {
            background-color: #6c757d;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
        }

        .search-result-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #eee;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body class="index-page">
   <nav class="navbar navbar-light bg-white shadow-sm fixed-top">
  <div class="container-xxl d-flex align-items-center justify-content-between">

    <!-- Left: Logo -->
    <a class="navbar-brand fs-2 fw-bold d-flex align-items-center gap-2" href="#">
      <img src="./assets/img/logo.png" alt="COMSA Logo" class="img-fluid" style="height:60px;">
      <span class="d-lg-inline">COMSA-NOW</span>
    </a>



      <!-- Right: Icon buttons -->
    <div class="d-flex align-items-center gap-3 d-none d-lg-flex">

      <a href="home.php" class="btn btn-light rounded-3 d-flex align-items-center justify-content-center"
         style="width:50px; height:50px;">
        <i class="ri-home-9-line fs-4"></i>
      </a>

      <a href="projects.php"
         class="btn btn-light rounded-3 d-flex align-items-center justify-content-center"
         style="width:50px; height:50px;">
        <i class="ri-shapes-line fs-4"></i>
      </a>

      <a href="settings.php"
         class="btn btn-light rounded-3 d-flex align-items-center justify-content-center"
         style="width:50px; height:50px;">
        <i class="ri-settings-line fs-4"></i>
      </a>

      <!-- Profile -->
      <a href="profile.php" class="d-flex align-items-center">
        <img src="./assets/img/team/default_user.png" alt="Profile"
             class="user-avatar rounded-circle btn-user-comsa-border" style="width: 45px; height: 45px;">
      </a>

  </div>
</nav>

<!-- /Navbar -->
 <!-- Main Content -->
<main class="container-fluid" style="margin-top: 80px;">
   <!-- =======================
     VIEW PROFILE HEADER
======================= -->
<div class="container my-4">
    <div class="content-header container py-5 mb-4 rounded-4 shadow-sm position-relative overflow-hidden"
         style="background: linear-gradient(1deg, #007a00, #7db832); color: white;">

        <!-- Abstract circles -->
        <div style="position: absolute; top: -20px; right: -50px; width: 200px; height: 200px; background-color: #ffffff; border-radius: 50%; opacity: 0.1;"></div>
        <div style="position: absolute; bottom: -60px; left: -40px; width: 150px; height: 150px; background-color: #ffffff; border-radius: 50%; opacity: 0.1;"></div>
        <div style="position: absolute; top: 10px; left: 20px; width: 100px; height: 100px; background-color: #ffffff; border-radius: 50%; opacity: 0.05;"></div>
        <div style="position: absolute; bottom: 40px; right: 100px; width: 80px; height: 80px; background-color: #ffffff; border-radius: 50%; opacity: 0.05;"></div>

        <!-- Back Button -->
        <div class="mb-3">
            <a href="profile.php" class="btn btn-back" 
               style="background-color: rgba(125, 184, 50, 0.8); color: white;">
                <i class="ri-arrow-left-line me-1"></i> Back to My Profile
            </a>
        </div>

        <!-- MATCHED LAYOUT -->
        <div class="d-flex justify-content-center">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start gap-4">

                <!-- Avatar -->
                <div class="d-flex flex-column align-items-center text-center position-relative">
                    <img src="../backend/<?php echo !empty($profile['profile_picture']) ? $profile['profile_picture'] : './assets/img/team/default_user.png'; ?>"
                         class="rounded-circle shadow"
                         width="180" height="180">

                </div>

                <!-- User Info -->
                <div class="flex-grow-1 text-center text-md-start">
                    <h1 class="fw-bold mb-1">
                        <?php echo htmlspecialchars($profile['username']); ?>
                    </h1>

                    <h4 class="mb-2 opacity-75">
                        <?php echo !empty($profile['nickname']) ? htmlspecialchars($profile['nickname']) : 'No nickname set'; ?>
                    </h4>

                    <p class="opacity-75 mb-0">
                        <?php echo !empty($profile['bio']) ? htmlspecialchars($profile['bio']) : 'No bio yet'; ?>
                    </p>
                </div>

                <!-- Stats (same as profile page) -->
                <div class="profile-stats-modern">
                    <div class="profile-stat">
                        <div class="number"><?php echo $profile['total_projects']; ?></div>
                        <div class="label">Projects</div>
                    </div>

                    <div class="profile-stat">
                        <div class="number"><?php echo $profile['total_stars']; ?></div>
                        <div class="label">Total Stars</div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
</div>
                </div>
        </div>
    </div>
</main>
    <!-- Vendor JS Files -->
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/vendor/php-email-form/validate.js"></script>
    <script src="./assets/vendor/aos/aos.js"></script>
    <script src="./assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="./assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="./assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="./assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="./assets/js/main.js"></script>
    <script src="./students/project-upload.js" defer></script>
    <script src="./students/profile-bio-nick.js"></script>
    <script src="./students/profile-project-studs.js" defer></script>

    <script src="./students/project-studs.js" defer></script>


    <script src="./students/profile-picture-handler.js" defer></script> <!-- For Handleling profile picture Image -->
    <script src="./students/profile-search-studs.js" defer></script> <!-- For Handleling search engine -->



    <script>
        //session with disabilities haha
        const studentId = <?php echo json_encode($_SESSION['user_id']); ?>;
        const currentStudentId = <?php echo json_encode($_SESSION['user_id']); ?>; //searchig --
    </script>



</body>

</html>