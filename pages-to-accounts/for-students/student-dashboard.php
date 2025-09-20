<?php
require_once "../../../backend/config/session.php";
require_once "../../../backend/config/db.php";
require_once '../../../backend/middleware/student_middleware.php';

require_once "../../../backend/api/update_nickname_bio.php";



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
    <link rel="stylesheet" href="../../assets/css/project-studs-design.css">  <!-- Also responsible for nav design-->
  <link rel="stylesheet" href="../../assets/css/dark-mode.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
  /* Event and Quick Links Styles */

  /* Event item styles */
  .event-item {
    display: flex;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .event-item:last-child {
    border-bottom: none;
  }

  .event-item:hover {
    background-color: #f8f9fa;
    transform: translateX(3px);
  }

  .event-date {
    min-width: 50px;
    text-align: center;
    margin-right: 15px;
    background: linear-gradient(135deg, #7db832, #6aa32a);
    color: white;
    border-radius: 8px;
    padding: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .event-date .day {
    display: block;
    font-size: 1.2rem;
    font-weight: bold;
    line-height: 1;
  }

  .event-date .month {
    display: block;
    font-size: 0.8rem;
    text-transform: uppercase;
    font-weight: 600;
  }

  .event-info {
    flex: 1;
  }

  .event-info h5 {
    font-size: 0.95rem;
    margin-bottom: 4px;
    color: #2c3e50;
    font-weight: 600;
    line-height: 1.3;
  }

  .event-time {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 0;
  }

  /* Quick link styles */
  .suggestion-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .suggestion-item:last-child {
    border-bottom: none;
  }

  .suggestion-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
  }

  .suggestion-info {
    flex: 1;
  }

  .suggestion-info h5 {
    font-size: 0.9rem;
    margin-bottom: 2px;
    color: #2c3e50;
    font-weight: 600;
  }

  .suggestion-info small {
    font-size: 0.75rem;
    color: #7f8c8d;
  }

  /* Dark mode support */
  body.dark-mode .event-item:hover,
  body.dark-mode .suggestion-item:hover {
    background-color: #2a2a2a;
  }

  body.dark-mode .event-info h5,
  body.dark-mode .suggestion-info h5 {
    color: #e0e0e0;
  }

  body.dark-mode .event-time,
  body.dark-mode .suggestion-info small {
    color: #b0b0b0;
  }

  .suggestion-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }

  .suggestion-item:last-child {
    border-bottom: none;
  }

  .suggestion-item:hover {
    background-color: #f8f9fa;
  }

  .suggestion-info h5 {
    font-size: 0.9rem;
    margin-bottom: 0;
    color: #333;
  }



  .no-events-message,
  .no-links-message {
    border-top: 1px solid #eee;
    margin-top: 10px;
    padding: 20px 0;
  }

  .no-events-message i,
  .no-links-message i {
    opacity: 0.5;
  }

  body.dark-mode .no-events-message,
  body.dark-mode .no-links-message {
    border-top-color: #333;
  }

  /* Dark mode styles */
  body.dark-mode .event-item:hover,
  body.dark-mode .suggestion-item:hover {
    background-color: #2a2a2a;
  }

  body.dark-mode .event-info h5,
  body.dark-mode .suggestion-info h5 {
    color: #e0e0e0;
  }

  body.dark-mode .event-info p,
  body.dark-mode .event-location {
    color: #aaa;
  }


  .post-tags {
    padding: 10px 15px;
    border-top: 1px solid #eee;
  }

  .post-tag {
    display: inline-block;
    background-color: #f0f8ff;
    color: #007bff;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
    margin-right: 5px;
    margin-bottom: 5px;
  }
</style>

<body class="index-page">

  <!-- 🔎 Search Modal -->
  <div class="search-popup">
    <div class="search-container">
      <div class="search-input-container d-flex">
        <input type="text" placeholder="Search..." class="form-control">
        <button class="btn btn-success"><i class="bi bi-search"></i></button>
      </div>
    </div>
  </div>
  <!-- /Search Modal -->

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

      <a href="#" class="btn btn-active rounded-3 d-flex align-items-center justify-content-center"
         style="width:50px; height:50px;">
        <i class="ri-home-9-line fs-4"></i>
      </a>

      <a href="../../pages-to-accounts/for-students/project-studs.php"
         class="btn btn-light rounded-3 d-flex align-items-center justify-content-center"
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

    <!-- Left Sidebar (Events + Quick Links stacked) -->
    <aside class="col-lg-3 d-none d-lg-block">
      <div class="left-sidebar sticky-top" style="top: 120px;">
        
        <!-- Events Card -->
        <div class="card shadow-sm mb-4 border-0 rounded-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="fw-bold mb-0">Upcoming Events</h6>
              <a href="#" class="small">View Calendar</a>
            </div>
            <!-- fetch events -->
          </div>
        </div>

        <!-- Quick Links Card -->
        <div class="card shadow-sm border-0 rounded-3">
          <div class="card-body">
            <h6 class="fw-bold mb-3">Quick Links</h6>
            <!-- fetch quick links -->
          </div>
        </div>

      </div>
    </aside>

    <!-- Right Column (Posts Feed) -->
    <div class="col-lg-7">
      <div class="posts-column mb-5 mt-3">

      </div>
    </div>

  </div>
</main>


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
    <script src="../for-students/js/profile-bio-nick.js"></script>
    <script src="../for-students/js/profile-project-studs.js" defer></script>

    <script src="../for-students/js/project-studs.js" defer></script>

    <script src="../for-students/js/fetch-posts.js"></script>
    <script src="../for-students/js/fetch-events-links.js"></script>

    <script>
      //session with disabilities haha
      const studentId = <?php echo json_encode($_SESSION['user_id']); ?>;


      // Helper function to check if element contains text
      Element.prototype.containsText = function(text) {
        return this.textContent.toLowerCase().includes(text.toLowerCase());
      };
    </script>


</body>

</html>