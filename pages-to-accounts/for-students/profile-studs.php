<?php
require_once "../../../backend/config/session.php";
require_once "../../../backend/config/db.php";
require_once '../../../backend/middleware/student_middleware.php';

require_once "../../../backend/api/update_nickname_bio.php";


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
=    <link rel="stylesheet" href="../../assets/css/search.css">
    <link rel="stylesheet" href="../../assets/css/dark-mode.css">
    <link rel="stylesheet" href="../../assets/css/project-studs-design.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .profile-header {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            position: relative;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar-edit {
            position: absolute;
            bottom: 20px;
            left: 140px;
            background: #7db832;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 2px solid white;
        }

        .profile-name {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .profile-nickname {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .profile-bio {
            margin-bottom: 1.5rem;
        }

        .profile-stats {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .profile-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #7db832;
        }

        .project-card {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .project-card:hover {
            transform: translateY(-5px);
        }

        .project-card-img {
            height: 180px;
            object-fit: cover;
            width: 100%;
        }

        .project-card-body {
            padding: 1rem;
        }

        .project-card-title {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .project-card-desc {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .project-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .project-card-type {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            background-color: #e9ecef;
        }

        .project-card-actions {
            display: flex;
            gap: 0.5rem;
        }

        .edit-nickname-btn {
            background: none;
            border: none;
            color: #7db832;
            cursor: pointer;
        }

        /* Avatar upload modal */
        .avatar-options {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .avatar-option {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .avatar-option:hover {
            border-color: #7db832;
        }

        .avatar-option.selected {
            border-color: #7db832;
        }

        .carousel {
            width: 100%;
            height: 400px;
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
            background-color: #f8f9fa;
        }




        .char-limit-warning {
            color: orange;
        }

        .char-limit-exceeded {
            color: red;
        }

        .text-danger {
            color: red;
        }

        .is-invalid {
            border-color: red;
        }
    </style>
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
                            <button class="btn p-2" type="button" id="search-toggle">
                                <i class="ri-search-line fs-1"></i>
                            </button>

                            <!-- Profile Icon Button -->
                            <button type="button" class="btn p-0 border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <img src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle" alt="Profile" style="width: 40px; height: 40px;">
                            </button>
                        </div>
                    </div>

                    <!-- Profile Header Section -->
                    <div class="profile-header">
                        <div class="row align-items-center">
                            <div class="col-md-2 position-relative">
                                <img src="../../assets/img/team/sampleTeam.jpg" class="profile-avatar d-none" alt="Profile Picture" id="user-avatar" style="border-color: #7db832;">
                                <div class="profile-avatar-edit" data-bs-toggle="modal" data-bs-target="#avatarModal">
                                    <i class="ri-camera-line"></i>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <h1 class="profile-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
                                <div class="d-flex align-items-center">
                                    <h2 class="profile-nickname me-2" id="nicknameDisplay">
                                        <?php echo !empty($nickname) ? $nickname : 'No nickname set'; ?>
                                    </h2>
                                    <button class="edit-nickname-btn" data-bs-toggle="modal" data-bs-target="#nicknameModal">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <p class="profile-bio mb-0">
                                        <?php echo $bio; ?>
                                    </p>
                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#editBioModal" style="color: #7db832">
                                        <i class="ri-edit-line"></i>
                                    </button>

                                </div>

                                <div class="profile-stats">
                                    <div class="stat-item">
                                        <div class="stat-number">0</div>
                                        <div class="stat-label">Projects</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-number" id="totalStarsCount">0</div>
                                        <div class="stat-label">Total Stars</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- bio Content -->
                    <div class="modal fade" id="editBioModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Bio</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form method="post" action="../../../backend/api/update_nickname_bio.php" ;>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <textarea class="form-control" id="bioInput" name="bio" rows="5"
                                                maxlength="100"><?php echo $bio; ?></textarea>
                                            <div class="form-text text-end">
                                                <span id="wordCount"><?php echo strlen($bio); ?>/100 characters</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>




                    <!-- Profile Content -->
                    <div class="row">
                        <!-- Projects Section -->
                        <div class="col-md-8">
                            <div class="profile-section">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3 class="section-title mb-0">My Projects</h3>
                                    <button class="btn btn-primary" id="uploadProjectBtnMobile" style="background-color: #7db832; border: none;">
                                        <i class="ri-upload-line me-1"></i> Upload Project
                                    </button>
                                </div>


                                <div id="studentProjectsContainer" class="row">
                                    <!-- Projects will be loaded here via JavaScript -->
                                </div>

                                <div class="text-center mt-3">
                                    <button class="btn btn-outline-primary">View All Projects</button>
                                </div>
                            </div>
                        </div>


                        <!-- About Section -->
                        <div class="col-md-4">
                            <div class="profile-section">
                                <h3 class="section-title">About</h3>
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span><i class="ri-user-3-line me-2"></i> Full Name</span>
                                                <span class="text-muted"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span><i class="ri-mail-line me-2"></i> Email</span>
                                                <span class="text-muted"><?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span><i class="ri-calendar-line me-2"></i> Member Since</span>
                                                <span class="text-muted">June 2023</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Avatar Change Modal -->
            <div class="modal fade" id="avatarModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Change Profile Picture</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <img id="currentAvatarPreview" src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>

                            <div class="d-flex flex-column gap-2">
                                <button class="btn btn-primary" id="uploadNewAvatarBtn">
                                    <i class="ri-upload-line me-2"></i> Upload New Photo
                                </button>
                                <input type="file" id="avatarFileInput" accept="image/*" style="display: none;">

                                <button class="btn btn-outline-danger" id="removeAvatarBtn">
                                    <i class="ri-delete-bin-line me-2"></i> Remove Current Photo
                                </button>
                            </div>

                            <div class="progress mt-3 d-none" id="avatarUploadProgress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>

                            <div id="avatarError" class="text-danger mt-2 text-center"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-success" id="saveAvatarBtn" disabled>Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Nickname Change Modal -->
            <div class="modal fade" id="nicknameModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Nickname</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form method="post" action="../../../backend/api/update_nickname_bio.php" ;>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nicknameInput" class="form-label">Nickname</label>
                                    <input type="text" class="form-control" id="nicknameInput" name="nickname"
                                        value="<?php echo isset($_SESSION['user_nickname']) ? htmlspecialchars($_SESSION['user_nickname']) : ''; ?>"
                                        pattern="[A-Za-z]+" title="Only letters (A-Z, a-z) allowed">
                                    <div class="form-text">Letters only, no spaces or special characters</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Project Upload Modal (Enhanced Design) -->
            <div class="modal fade" id="projectUploadModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content upload-modal-content">
                        <div class="modal-header upload-modal-header">
                            <div class="d-flex align-items-center">
                                <i class="ri-upload-cloud-line me-2 upload-modal-icon"></i>
                                <h5 class="modal-title upload-modal-title">Upload Your Project</h5>
                            </div>
                            <button type="button" class="close-uploadInfo btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body upload-modal-body">
                            <form id="projectUploadForm" class="compact-form">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectTitle" class="form-label upload-form-label">
                                                <i class="ri-text me-1"></i>Project Title<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control upload-form-control" id="projectTitle" required placeholder="Enter your project title">
                                            <div class="form-text">Make it descriptive and catchy!</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectType" class="form-label upload-form-label">
                                                <i class="ri-folder-2-line me-1"></i>Project Type<span class="text-danger">*</span>
                                            </label>
                                            <div class="select-wrapper">
                                                <select class="form-select upload-form-control" id="projectType" required>
                                                    <option value="">Select project type</option>
                                                    <option value="Games">Game</option>
                                                    <option value="Websites">Website</option>
                                                    <option value="Mobile Apps">Mobile App</option>
                                                    <option value="Console">Console App</option>
                                                    <option value="AI/ML">AI/ML</option>
                                                    <option value="Databases">Database</option>
                                                    <option value="Others">Other</option>
                                                </select>
                                                <i class="ri-arrow-down-s-line select-arrow"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="projectDescription" class="form-label upload-form-label">
                                                <i class="ri-file-text-line me-1"></i>Description<span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control upload-form-control" id="projectDescription" rows="4" required placeholder="Describe your project, what it does, and what makes it special"></textarea>
                                            <div class="form-text d-flex justify-content-between">
                                                <span>Minimum 50 characters recommended</span>
                                                <span id="descriptionCounter">0 characters</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectTechnologies" class="form-label upload-form-label">
                                                <i class="ri-code-s-slash-line me-1"></i>Technologies Used
                                            </label>
                                            <div class="tag-input-container upload-form-control">
                                                <input type="text" class="tag-input" id="projectTechnologies" placeholder="Add technology (press Enter or Space)">
                                                <div id="tagsWrapper" class="tags-container mt-2"></div>
                                            </div>
                                            <div class="form-text">Examples: JavaScript, React, Node.js, Python</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectTeam" class="form-label upload-form-label">
                                                <i class="ri-team-line me-1"></i>Team Members
                                            </label>
                                            <div class="tag-input-container upload-form-control">
                                                <input type="text" class="tag-input" id="projectTeam" placeholder="Add team member (press Enter or Space)">
                                                <div id="tagsMemberWrapper" class="tags-container mt-2"></div>
                                            </div>
                                            <div class="form-text">Enter usernames of your collaborators</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label upload-form-label">
                                                <i class="ri-image-line me-1"></i>Project Media (2-8 images)
                                            </label>
                                            <div class="upload-area enhanced-upload-area" id="mediaUploadArea">
                                                <div class="upload-content">
                                                    <i class="ri-folder-upload-line upload-icon-main"></i>
                                                    <h5>Drag & drop your files here</h5>
                                                    <p class="mb-2">or</p>
                                                    <button type="button" class="btn btn-outline-primary btn-sm upload-browse-btn">Browse Files</button>
                                                    <small class="text-muted d-block mt-2">Max 8 images (800x600 recommended)</small>
                                                </div>
                                                <input type="file" id="mediaUpload" name="mediaFiles[]" multiple accept="image/*" style="display: none;">
                                            </div>
                                            <div id="mediaPreview" class="media-preview-grid mt-3"></div>
                                            <div id="mediaCounter" class="media-counter text-muted small mt-2">0/8 images selected</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label upload-form-label">
                                                <i class="ri-links-line me-1"></i>Project Links
                                            </label>
                                            <div class="link-input-group mb-3">
                                                <span class="link-input-icon"><i class="ri-download-line"></i></span>
                                                <input type="url" id="downloadLink" class="form-control upload-form-control link-input" placeholder="https://... Executable Download URL">
                                            </div>
                                            <div class="link-input-group mb-3">
                                                <span class="link-input-icon"><i class="ri-global-line"></i></span>
                                                <input type="url" id="liveLink" class="form-control upload-form-control link-input" placeholder="https://... Live Demo URL">
                                            </div>
                                            <div class="link-input-group">
                                                <span class="link-input-icon"><i class="ri-github-fill"></i></span>
                                                <input type="url" id="githubLink" class="form-control upload-form-control link-input" placeholder="https://... GitHub Repository">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="uploadOverlay" class="upload-overlay">
                            <div id="uploadLoader" class="upload-status">
                                <div class="upload-spinner">
                                    <div class="spinner-border text-success" role="status"></div>
                                </div>
                                <p class="mt-3 fw-semibold">Uploading your project...</p>
                                <div class="progress mt-2 upload-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                            <div id="uploadSuccess" class="upload-status d-none">
                                <div class="upload-success-icon">
                                    <i class="ri-checkbox-circle-fill"></i>
                                </div>
                                <h5 class="mt-3 fw-bold">Upload Successful!</h5>
                                <p class="text-muted">Your project is now live</p>
                                <button type="button" class="btn btn-success mt-2" data-bs-dismiss="modal">Continue</button>
                            </div>
                        </div>
                        <div id="generalUploadError" class="upload-error-alert alert alert-danger d-none mt-2 mx-3"></div>
                        <div class="modal-footer upload-modal-footer">
                            <button type="button" class="btn btn-outline-secondary cancel-btn" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="projectUploadForm" class="btn btn-primary upload-submit-btn">
                                <i class="ri-upload-cloud-line me-1"></i>Upload Project
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Image Viewer Modal -->
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



            <!-- Edit Project Modal -->
            <div class="modal fade" id="editProjectModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Project</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="editProjectForm" class="compact-form">
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="editProjectTitle" class="form-label">Project Title*</label>
                                        <input type="text" class="form-control" id="editProjectTitle" name="project_title" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="editProjectType" class="form-label">Project Type*</label>
                                        <select class="form-select" id="editProjectType" name="project_category" required>
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
                                        <label for="editProjectDescription" class="form-label">Description*</label>
                                        <textarea class="form-control" id="editProjectDescription" name="project_description" rows="3" required></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="editProjectTechnologies" class="form-label">Technologies Used</label>
                                        <div class="border p-2 rounded" style="min-height: 50px;">
                                            <input type="text" class="form-control" id="editProjectTechnologies" placeholder="Add technology and press space/enter">
                                            <div id="editTechTags" class="mt-2 d-flex flex-wrap gap-1"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="editProjectTeam" class="form-label">Team Members</label>
                                        <div class="border p-2 rounded" style="min-height: 50px;">
                                            <input type="text" class="form-control" id="editProjectTeam" placeholder="Add member and press space/enter">
                                            <div id="editMemberTags" class="mt-2 d-flex flex-wrap gap-1"></div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Project Media</label>
                                        <div class="border p-2 rounded">
                                            <p class="text-muted">Current images will be kept. Upload new ones to replace.</p>
                                            <input type="file" class="form-control" name="mediaFiles[]" multiple accept="image/*">
                                        </div>
                                    </div>

                                    <div class="row-md-5">
                                        <label class="form-label">Project Links</label>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><i class="bi bi-download"></i></span>
                                            <input type="url" id="editDownloadLink" class="form-control" name="download_link" placeholder="Executable Download URL">
                                        </div>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                            <input type="url" id="editLiveLink" class="form-control" name="live_link" placeholder="Live Demo URL">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-github"></i></span>
                                            <input type="url" id="editGithubLink" class="form-control" name="github_link" placeholder="GitHub Repository">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
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
                    <a id="uploadProjectBtn" class="text-center mt-2 ">
                        <i class="ri-add-circle-line fs-1"></i>
                    </a>
                    <a href="../../pages-to-accounts/for-students/profile-studs.php" class="text-center mt-2 btn-active-mobile">
                        <i class="ri-user-line fs-1"></i>
                    </a>
                    <a href="../../pages-to-accounts/for-students/settings-studs.php" class="text-center mt-2">
                        <i class="ri-settings-line fs-1"></i>
                    </a>
                </div>
            </nav>



            <!-- Search modal unfixed both id and it's design-->
            <div class="search-popup">
                <div class="search-container">
                    <div class="search-input-container">
                        <input type="text" placeholder="Search projects..." class="search-input">
                        <button class="search-button"><i class="bi bi-search"></i></button>
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
    <script src="../for-students/js/project-upload.js" defer></script>
    <script src="../for-students/js/profile-bio-nick.js"></script>
    <script src="../for-students/js/profile-project-studs.js" defer></script>
    <script src="../../assets/js/studs-main-func.js"></script>


    <script src="../for-students/js/project-studs.js" defer></script>


    <script>
        //session with disabilities haha
        const studentId = <?php echo json_encode($_SESSION['user_id']); ?>;
    </script>

</body>

<script>

</script>

</html>