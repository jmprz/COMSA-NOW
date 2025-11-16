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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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
        /* Custom scrollbar styling */
        #studentProjectsContainer {
           display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
             gap: 2rem;
        }

        #studentProjectsContainer::-webkit-scrollbar {
            width: 8px;
        }

        #studentProjectsContainer::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #studentProjectsContainer::-webkit-scrollbar-thumb {
            background: #007a00;
            border-radius: 10px;
        }

        #studentProjectsContainer::-webkit-scrollbar-thumb:hover {
            background: #6aa02a;
        }

        #studentProjectsContainer {
            scrollbar-width: thin;
            scrollbar-color: #007a00 #f1f1f1;
        }




        .content-header {
    background: linear-gradient(135deg, #007a00, #8bc34a);
    color: white;
    border-radius: 22px !important;
    padding: 3rem 2rem !important;
}

        /* Custom scrollbar ---END */


        .object-fit-cover {
            object-fit: cover;
        }

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
            background: #007a00;
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
            border-bottom: 2px solid #007a00;
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
            color: #007a00;
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
            border-color: #007a00;
        }

        .avatar-option.selected {
            border-color: #007a00;
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

        /* Avatar upload modal ---END*/



        /* NICKNAME */

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

        /* NICKNAME ---END*/

        /* Stats Section */
.profile-stats-modern {
    display: flex;
    gap: 3rem;
    margin-top: 1.5rem;
}

.profile-stat {
    text-align: center;
}

.profile-stat .number {
    font-size: 3rem;
    font-weight: 800;
    line-height: 1;
}

.profile-stat .label {
    font-size: 1rem;
    opacity: 0.85;
}
    </style>
</head>

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
             class="user-avatar rounded-circle btn-user-comsa-border" style="width: 45px; height: 45px;">
      </a>

  </div>
</nav>

<!-- /Navbar -->

    <!-- Main Content -->
<main class="container-fluid" style="margin-top: 80px;">

    <!-- =======================
         PROFILE HERO HEADER
    ======================== -->
    <div class="container my-4">
        <div class="content-header container py-5 mb-4 rounded-4 shadow-sm position-relative overflow-hidden "
             style="background: linear-gradient(1deg, #007a00, #7db832); color: white;">

            <!-- Abstract circles -->
            <div style="position: absolute; top: -20px; right: -50px; width: 200px; height: 200px; background-color: #ffffff; border-radius: 50%; opacity: 0.1;"></div>
            <div style="position: absolute; bottom: -60px; left: -40px; width: 150px; height: 150px; background-color: #ffffff; border-radius: 50%; opacity: 0.1;"></div>
            <div style="position: absolute; top: 10px; left: 20px; width: 100px; height: 100px; background-color: #ffffff; border-radius: 50%; opacity: 0.05;"></div>
            <div style="position: absolute; bottom: 40px; right: 100px; width: 80px; height: 80px; background-color: #ffffff; border-radius: 50%; opacity: 0.05;"></div>

        <!-- PROFILE INFO -->
            <div class="d-flex justify-content-center">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start gap-4">

                    <!-- Avatar -->
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="../../assets/img/team/default_user.png"
                             class="rounded-circle shadow user-avatar"
                             width="180" height="180">
                    </div>

                    <!-- User Info -->
                    <div class="flex-grow-1 text-center text-md-start">
                        <h1 class="fw-bold mb-1">
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </h1>

                        <h4 class="mb-2 opacity-75">
                            <?php echo htmlspecialchars($_SESSION['user_email']); ?>
                        </h4>

                        <p class="opacity-75 mb-0"><?php echo $bio; ?></p>
                    </div>

                    <!-- Stats -->
                    <div class="profile-stats-modern">
                        <div class="profile-stat">
                            <div class="number">0</div>
                            <div class="label">Projects</div>
                        </div>

                        <div class="profile-stat">
                            <div class="number" id="totalStarsCount">0</div>
                            <div class="label">Total Stars</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- =======================
         PROJECTS ONLY
    ======================== -->
    <div class="container mb-5">

        <div class="d-flex justify-content-between align-items-center">
            <h3 class="section-title mb-0">My Projects</h3>
            <button class="btn btn-primary" id="uploadProjectBtnMobile"
                    style="background: #007a00; border: none;">
                <i class="ri-upload-line me-1"></i> Upload Project
            </button>
        </div>

        <!-- Project Grid -->
        <div id="studentProjectsContainer" class="row mt-4">
            <!-- JS will insert project cards here -->
        </div>

    </div>
</main>


            <!-- Project Upload Modal (Same as in project-studs.php) -->
            <div class="modal fade" id="projectUploadModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload Your Project</h5>
                            <button type="button" class="close-uploadInfo btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="projectUploadForm" class="compact-form">
                                <div class="col g-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="projectTitle" class="form-label">Project Title*</label>
                                            <input type="text" class="form-control" id="projectTitle" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="projectType" class="form-label">Project Type*</label>
                                            <select class="form-select" id="projectType" required>
                                                <option value="">Select type</option>
                                                <option value="AI/ML">AI/ML</option>
                                                <option value="Console Apps">Console Apps</option>
                                                <option value="Databases">Databases</option>
                                                <option value="Desktop Apps">Desktop Apps</option>
                                                <option value="Games">Games</option>
                                                <option value="Mobile Apps">Mobile Apps</option>
                                                <option value="UI/UX Design">UI/UX Design</option>
                                                <option value="Web Development">Web Development</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="projectDescription" class="form-label">Description*</label>
                                        <textarea class="form-control" id="projectDescription" rows="3" required></textarea>
                                    </div>
                                    <div class="row">
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
                            <button type="submit" form="projectUploadForm" class="btn btn-primary" style="background-color: #007a00; border: 1px solid #007a00;">Upload Project</button>
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
                                <div class="col g-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="editProjectTitle" class="form-label">Project Title*</label>
                                            <input type="text" class="form-control" id="editProjectTitle" name="project_title" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="editProjectType" class="form-label">Project Type*</label>
                                            <select class="form-select" id="editProjectType" name="project_category" required>
                                                <option value="">Select type</option>
                                                <option value="AI/ML">AI/ML</option>
                                                <option value="Console Apps">Console Apps</option>
                                                <option value="Databases">Databases</option>
                                                <option value="Desktop Apps">Desktop Apps</option>
                                                <option value="Games">Games</option>
                                                <option value="Mobile Apps">Mobile Apps</option>
                                                <option value="UI/UX Design">UI/UX Design</option>
                                                <option value="Web Development">Web Development</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="editProjectDescription" class="form-label">Description*</label>
                                        <textarea class="form-control" id="editProjectDescription" name="project_description" rows="3" required></textarea>
                                    </div>
                                    <div class="row">
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
                                    </div>


                                    <div class="col-12">
                                        <label class="form-label">Project Images</label>
                                        <div class="border p-2 rounded">
                                            <p class="text-muted">Current images (cannot be changed)</p>
                                            <div id="currentProjectImages" class="d-flex flex-wrap gap-2 mt-2">
                                                <!-- Images will be displayed here -->
                                            </div>
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

                    <!-- Edit Project Loader Overlay -->
                    <div id="editProjectOverlay" class="position-absolute d-flex flex-column justify-content-center start-0 w-100 h-100 bg-light bg-opacity-75 d-none justify-content-center align-items-center" style="z-index: 1051; top: 0;">
                        <div id="editProjectLoader" class="text-center">
                            <div class="spinner-border text-success" role="status"></div>
                            <p class="mt-2 fw-semibold">Updating Project...</p>
                        </div>
                        <div id="editProjectSuccess" class="text-center d-none">
                            <i class="bi bi-check-circle-fill text-success fs-1"></i>
                            <p class="mt-2 fw-semibold">Update Successful!</p>
                        </div>
                    </div>
                    <div id="editProjectError" class="text-danger fw-semibold text-center d-none mt-2"></div>
                </div>
            </div>


        <!-- 📌 Bottom Navigation (mobile only) -->
<nav class="d-lg-none fixed-bottom bg-white border-top shadow-sm">
  <div class="d-flex justify-content-around py-2 mt-2">

    <a href="../../pages-to-accounts/for-students/student-dashboard.php" class="btn rounded-3 d-flex align-items-center justify-content-center"
       style="width:50px; height:50px;">
       <i class="ri-home-9-line fs-1"></i>
    </a>

    <a href="../../pages-to-accounts/for-students/project-studs.php" 
       class="btn btn-light d-flex align-items-center justify-content-center"
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
            class="user-avatar rounded-circle btn-user-comsa-border"
            width="40" height="40">
    </a>

  </div>
</nav>

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
    <script src="../for-students/js/profile-bio-nick.js"></script>
    <script src="../for-students/js/profile-project-studs.js" defer></script>

    <script src="../for-students/js/project-studs.js" defer></script>


    <script src="../for-students/js/profile-picture-handler.js" defer></script> <!-- For Handleling profile picture Image -->
    <script src="../for-students/js/profile-search-studs.js" defer></script> <!-- For Handleling search engine -->

    <script>
        //session with disabilities haha
        const studentId = <?php echo json_encode($_SESSION['user_id']); ?>;
        const currentStudentId = <?php echo json_encode($_SESSION['user_id']); ?>;
    </script>

    <script>

    </script>



</body>



</html>