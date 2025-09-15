<?php
require_once "../../../backend/config/session.php";
require_once "../../../backend/config/db.php";
require_once '../../../backend/middleware/student_middleware.php';

require_once "../../../backend/api/view-profile.php";


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
    <link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/img/favicon/site.webmanifest">

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

    <!-- Main CSS File -->
    <link rel="stylesheet" href="../../assets/css/dark-mode.css">
    <link rel="stylesheet" href="../../assets/css/project-studs-design.css">
    <link rel="stylesheet" href="../../assets/css/search-profile-design.css">

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
    <!-- Main Content - Similar structure to profile-studs.php but read-only -->
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
                                <a href="../../pages-to-accounts/for-students/project-studs.php" class="btn text-start d-flex align-items-center gap-2">
                                    <i class="ri-shapes-line"></i> <span>Projects</span>
                                </a>
                                <a href="#" id="search-toggle" class="btn text-start d-flex align-items-center gap-2">
                                    <i class="ri-search-line"></i> <span>Search</span>
                                </a>
                                <a href="../../pages-to-accounts/for-students/profile-studs.php" class="btn text-start d-flex align-items-center gap-2 btn-active">
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

                <!-- Main Profile Content -->
                <div class="col-lg-10">
                    <!-- Mobile Only Header -->
                    <div class="d-lg-none d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
                        <div class="d-flex align-items-center">
                            <h5 class="ms-2 mb-0 fw-bold">COMSA-NOW</h5>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <!-- Search Button -->
                            <button class="btn p-2 search-toggle-mobile" type="button">
                                <i class="ri-search-line fs-1"></i>
                            </button>

                            <!-- Profile Icon Button -->
                            <button type="button" class="btn p-0 border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <img src="../../assets/img/team/default_user.png" class="rounded-circle" alt="Profile" style="width: 40px; height: 40px;">
                            </button>
                        </div>
                    </div>

                    <!-- Profile Header Section - Read Only -->
                    <div class="profile-header">
                        <div class="row align-items-center">
                            <div class="col-md-2 position-relative">
                                <div class="d-flex justify-content-end mb-3" style="margin-right: 100px;">
                                    <a href="profile-studs.php" class="btn btn-back" style="background-color: rgba(125, 184, 50, 0.8);">
                                        <i class="ri-arrow-left-line me-1"></i> Back to My Profile
                                    </a>
                                </div>
                                <img src="../../../backend/<?php echo !empty($profile['profile_picture']) ? $profile['profile_picture'] : 'assets/img/team/default_user.png'; ?>"
                                    class="profile-avatar" alt="Profile Picture" id="user-avatar" style="border-color: #7db832;">
                                <span class="view-only-badge position-absolute" style="bottom: 20px; left: 100px; background-color: rgba(125, 184, 50, 0.8);">
                                    View Only
                                </span>
                            </div>
                            <div class="col-md-10">
                                <h1 class="profile-name"><?php echo htmlspecialchars($profile['username']); ?></h1>
                                <h2 class="profile-nickname">
                                    <?php echo !empty($profile['nickname']) ? htmlspecialchars($profile['nickname']) : 'No nickname set'; ?>
                                </h2>

                                <p class="profile-bio">
                                    <?php echo !empty($profile['bio']) ? htmlspecialchars($profile['bio']) : 'No bio yet'; ?>
                                </p>

                                <div class="profile-stats">
                                    <div class="stat-item">
                                        <div class="stat-number"><?php echo $profile['total_projects']; ?></div>
                                        <div class="stat-label">Projects</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-number"><?php echo $profile['total_stars']; ?></div>
                                        <div class="stat-label">Total Stars</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Content -->
                    <div class="row">
                        <!-- About Section -->
                        <div class="col-12 d-md-none order-1">
                            <!-- Read-only about section -->
                        </div>

                        <!-- Projects Section -->
                        <div class="col-md-8 order-3 order-md-2">
                            <div class="profile-section">
                                <h3 class="section-title">Projects</h3>
                                <div id="viewProjectsContainer" class="row">
                                    <?php if (!empty($projects)): ?>
                                        <?php foreach ($projects as $project): ?>
                                            <div class="col-md-6 mb-4">
                                                <div class="project-card">
                                                    <?php if (!empty($project['images'])): ?>
                                                        <img src="../../../backend/<?php echo explode(',', $project['images'])[0]; ?>"
                                                            class="project-card-img" alt="<?php echo htmlspecialchars($project['project_title']); ?>">
                                                    <?php else: ?>
                                                        <div class="project-card-img bg-light d-flex align-items-center justify-content-center">
                                                            <i class="ri-image-line fs-1 text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="project-card-body">
                                                        <h5 class="project-card-title"><?php echo htmlspecialchars($project['project_title']); ?></h5>
                                                        <p class="project-card-desc"><?php echo htmlspecialchars($project['project_description']); ?></p>
                                                        <div class="project-card-tech">
                                                            <?php if (!empty($project['technologies'])): ?>
                                                                <?php foreach (explode(',', $project['technologies']) as $tech): ?>
                                                                    <span class="badge bg-secondary me-1"><?php echo htmlspecialchars($tech); ?></span>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <span class="text-muted">No technologies specified</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="project-card-footer">
                                                            <span class="project-card-type"><?php echo $project['project_category'] ?: 'Uncategorized'; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="col-12 text-center py-5">
                                            <i class="ri-folder-open-line fs-1 text-muted mb-3"></i>
                                            <h4>No Projects Yet</h4>
                                            <p class="text-muted">This user hasn't uploaded any projects yet.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- About Section for Desktop -->
                        <div class="col-md-4 d-none d-md-block order-2 order-md-3">
                            <!-- Read-only about section -->
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
    <script src="../for-students/js/profile-bio-nick.js"></script>
    <script src="../for-students/js/profile-project-studs.js" defer></script>

    <script src="../for-students/js/project-studs.js" defer></script>


    <script src="../for-students/js/profile-picture-handler.js" defer></script> <!-- For Handleling profile picture Image -->
    <script src="../for-students/js/profile-search-studs.js" defer></script> <!-- For Handleling search engine -->



    <script>
        //session with disabilities haha
        const studentId = <?php echo json_encode($_SESSION['user_id']); ?>;
        const currentStudentId = <?php echo json_encode($_SESSION['user_id']); ?>; //searchig --
    </script>



</body>

</html>