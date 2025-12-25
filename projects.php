<?php
require_once "../backend/config/session.php";

require_once '../backend/middleware/student_middleware.php';

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



  <link rel="apple-touch-icon" sizes="180x180" href="./assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/favicon/site.webmanifest">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <!-- Vendor CSS Files -->
  <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="./assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="./assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="./assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="./assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="./assets/css/main.css" rel="stylesheet">

  <link rel="stylesheet" href="./assets/css/project-studs-design.css">
  <link rel="stylesheet" href="./assets/css/search-profile-design.css">
  <link rel="stylesheet" href="./assets/css/dark-mode.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
  .carousel {
    width: 100%;
    height: 400px;
    /* Adjust this height as needed */
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
    /* This ensures the image fits while maintaining aspect ratio */
    background-color: #f8f9fa;
    /* Background color for images with different aspect ratios */
  }

  .sticky-sidebar {
    position: sticky;
    top: 120px;
    /* Adjust depending on navbar height */
    z-index: 100;
  }

  .posts-column {
    max-height: none;
    overflow-y: visible;
    padding-right: 10px;
    padding-top: 10px;
    scroll-behavior: smooth;
  }

  /* Fix for overlapping content behind navbar */
  body {
    padding-top: 50px;
    /* Adjust to match the height of your navbar */
  }

  @media screen and (max-width: 820px) {
    body {
      padding-top: 10px;
    }
  }

  /* Optional: make sure sections have consistent spacing */
  main {
    margin-top: 0 !important;
  }

  .category-item {
    display: block;
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .category-item:hover {
    background-color: var(--primary-light);
    color: #007a00;
  }

  .category-item:hover .category-icon {
    color: #007a00;
    /* icon color matches hover text */
  }

  .category-item.active {
    /* Gradient background for active category */
    background: #007a00;
    color: white !important;
  }

  .category-item.active .category-icon {
    color: white !important;
  }

  /* Container styling */
.modern-form-container {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    font-family: 'Inter', sans-serif;
    color: #333;
}

/* Row handling for side-by-side inputs */
.form-row-custom {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.flex-1 { flex: 1; min-width: 200px; }

/* Grouping labels and inputs */
.form-group-custom {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group-custom label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Modern Input Styling */
.form-group-custom input, 
.form-group-custom select, 
.form-group-custom textarea {
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    background-color: #f8fafc;
    transition: all 0.2s ease;
}

.form-group-custom input:focus {
    outline: none;
    border-color: #007a00;
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(0, 122, 0, 0.1);
}

/* Dropzone styling */
.upload-dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    background: #ffffff;
    transition: background 0.2s ease;
}

.upload-dropzone:hover {
    background: #f0fdf4;
    border-color: #007a00;
}

.upload-dropzone i {
    font-size: 2rem;
    color: #007a00;
}

/* Link inputs with icons */
.link-input-group {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.icon-input {
    display: flex;
    align-items: center;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding-left: 1rem;
}

.icon-input input {
    border: none !important;
    background: transparent !important;
    width: 100%;
}

.icon-input i {
    color: #64748b;
}

/* Container for input + tags */
.tag-input-wrapper {
    display: flex;
    flex-direction: column;
    padding: 0.5rem 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    background-color: #f8fafc;
    transition: all 0.2s ease;
    min-height: 50px;
}

.tag-input-wrapper:focus-within {
    background-color: #fff;
    border-color: #007a00;
    box-shadow: 0 0 0 4px rgba(0, 122, 0, 0.1);
}

/* The actual text input inside the wrapper */
.tag-input-wrapper input {
    border: none !important;
    background: transparent !important;
    padding: 0.25rem 0 !important;
    width: 100%;
    outline: none !important;
    box-shadow: none !important;
}

/* Tag styling */
.tags-display-area {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 4px;
}

.badge-tag {
    background-color: #e8f5e9;
    color: #007a00;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
    border: 1px solid #c8e6c9;
}

.badge-tag .remove-tag {
    cursor: pointer;
    font-size: 1rem;
    line-height: 1;
}

.badge-tag .remove-tag:hover {
    color: #cc0000;
}
</style>

<body class="index-page">
  <!-- Navbar -->
  <nav class="navbar navbar-mobile bg-white shadow-sm fixed-top py-1">
    <div class="container-xxl d-flex align-items-center">

      <!-- Left: Logo -->
      <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <img src="./assets/img/logo.png" alt="COMSA Logo" class="img-fluid" style="height:60px;">
        <span class="d-lg-inline fs-4 fw-bold">COMSA-NOW</span>
      </a>

      <!-- Right: Icon buttons -->
      <div class="d-flex align-items-center gap-2 ms-auto d-none d-lg-flex">

        <a href="home.php" class="btn-header d-flex align-items-center justify-content-center p-1 rounded-4"
          style="width:45px; height:45px;">
          <i class="ri-home-5-line fs-3"></i>
        </a>

        <a href="projects.php" class="btn-active d-flex align-items-center justify-content-center p-1 rounded-4"
          style="width:45px; height:45px;">
          <i class="ri-shapes-fill fs-3"></i>
        </a>

        <a href="settings.php" class="btn-header d-flex align-items-center justify-content-center p-1 rounded-4"
          style="width:45px; height:45px;">
          <i class="ri-settings-4-line fs-3"></i>
        </a>

        <a href="profile.php" class="d-flex align-items-center profile-border">
          <img src="./assets/img/team/default_user.png" alt="Profile" class="user-avatar rounded-circle border"
            width="40" height="40">
        </a>

      </div>
    </div>
  </nav>


  <!-- /Navbar -->

  <!-- Main Content -->
  <main class="container-fluid" style="margin-top: 80px;">
    <div class="row g-4 justify-content-center">

      <!-- Left Sidebar (Sticky Sidebar) -->
      <aside class="col-lg-3 order-lg-1" style="margin-top: 80px;">
        <div class="sticky-sidebar" style="position: sticky; top: 100px;">

          <!-- Project Upload -->
          <div class="d-lg-block d-none">
            <div class="shadow-sm mb-3 border-0">
              <button class="btn btn-primary mt-2 w-100 fw-semibold" data-bs-toggle="modal"
                data-bs-target="#projectUploadModal" style="background: #007a00; border: none;"> <i
                  class="ri-upload-cloud-2-line me-2"></i>
                Upload Project
              </button>
            </div>
            <div class="mb-3 d-lg-block d-none position-relative">
              <input type="text" class="form-control ps-5 shadow-sm border-0 rounded-3 project-search-input"
                placeholder="Search projects...">
              <i class="ri-search-line position-absolute"
                style="top: 50%; left: 15px; transform: translateY(-50%); color: #6c757d;"></i>
            </div>
          </div>

          <!-- Categories Card -->
          <div class="d-lg-block d-none">
            <div class="card shadow-sm border-0 mb-4">
              <div class="card-body">
                <h6 class="fw-bold mb-3">Project Categories</h6>
                <div class="accordion-body category-list">
                  <a href="#" class="category-item" id="category-all">
                    <i class="ri-recycle-line category-icon"></i>
                    <span>All</span>
                  </a>
                  <a href="#" class="category-item" id="category-aiml">
                    <i class="ri-robot-line category-icon"></i>
                    <span>AI/ML</span>
                  </a>
                  <a href="#" class="category-item" id="category-console">
                    <i class="ri-terminal-line category-icon"></i>
                    <span>Console Apps</span>
                  </a>
                  <a href="#" class="category-item" id="category-databases">
                    <i class="ri-database-2-line category-icon"></i>
                    <span>Databases</span>
                  </a>
                  <a href="#" class="category-item" id="category-desktop">
                    <i class="ri-computer-line category-icon"></i>
                    <span>Desktop Apps</span>
                  </a>
                  <a href="#" class="category-item" id="category-games">
                    <i class="ri-gamepad-line category-icon"></i>
                    <span>Games</span>
                  </a>
                  <a href="#" class="category-item" id="category-mobile">
                    <i class="ri-smartphone-line category-icon"></i>
                    <span>Mobile Apps</span>
                  </a>
                  <a href="#" class="category-item" id="category-uiux">
                    <i class="ri-brush-line category-icon"></i>
                    <span>UI/UX Design</span>
                  </a>
                  <a href="#" class="category-item" id="category-web">
                    <i class="ri-earth-line category-icon"></i>
                    <span>Web Development</span>
                  </a>

                </div>
              </div>
            </div>
          </div>
        </div>
      </aside>



      <!-- Main Feed -->
      <section class="col-lg-7 order-lg-2">
        <div id="projectFeed" class="posts-column">
          <!-- Upload for Mobile -->
          <div class="d-lg-none">
            <div class="shadow-sm mb-3 border-0">
              <button class="btn btn-primary mt-2 w-100 fw-semibold" data-bs-toggle="modal"
                data-bs-target="#projectUploadModal" style="background: #007a00; border: none;"> <i
                  class="ri-upload-cloud-2-line me-2"></i>
                Upload Project
              </button>
              <div class="mb-3 mt-4 d-lg-none position-relative">
                <input type="text" class="form-control ps-5 shadow-sm border-0 rounded-3 project-search-input"
                  placeholder="Search projects...">
                <i class="ri-search-line position-absolute"
                  style="top: 50%; left: 15px; transform: translateY(-50%); color: #6c757d;"></i>
              </div>
            </div>
          </div>
          <!-- Accordion for Mobile -->
          <div class="accordion d-lg-none mb-3" id="categoriesAccordion">
            <div class="accordion-item border-0 shadow-sm">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed bg-white text-dark fw-semibold" type="button"
                  data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="false"
                  aria-controls="collapseCategories">
                  Project Categories
                </button>
              </h2>
              <div id="collapseCategories" class="accordion-collapse collapse" data-bs-parent="#categoriesAccordion">
                <div class="accordion-body bg-white">
                  <div class="list-group">
                    <a href="#" class="category-item" id="category-all">
                      <i class="ri-recycle-line category-icon" style="color: #6c757d;"></i>
                      <span>All</span>
                    </a>
                    <a href="#" class="category-item" id="category-aiml">
                      <i class="ri-robot-line category-icon" style="color: #6c757d;"></i>
                      <span>AI/ML</span>
                    </a>
                    <a href="#" class="category-item" id="category-console">
                      <i class="ri-terminal-line category-icon" style="color: #6c757d;"></i>
                      <span>Console Apps</span>
                    </a>
                    <a href="#" class="category-item" id="category-databases">
                      <i class="ri-database-2-line category-icon" style="color: #6c757d;"></i>
                      <span>Databases</span>
                    </a>
                    <a href="#" class="category-item" id="category-desktop">
                      <i class="ri-computer-line category-icon" style="color: #6c757d;"></i>
                      <span>Desktop Apps</span>
                    </a>
                    <a href="#" class="category-item" id="category-games">
                      <i class="ri-gamepad-line category-icon" style="color: #6c757d;"></i>
                      <span>Games</span>
                    </a>
                    <a href="#" class="category-item" id="category-mobile">
                      <i class="ri-smartphone-line category-icon" style="color: #6c757d;"></i>
                      <span>Mobile Apps</span>
                    </a>
                    <a href="#" class="category-item" id="category-uiux">
                      <i class="ri-brush-line category-icon" style="color: #6c757d;"></i>
                      <span>UI/UX Design</span>
                    </a>
                    <a href="#" class="category-item" id="category-web">
                      <i class="ri-earth-line category-icon" style="color: #6c757d;"></i>
                      <span>Web Development</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Posts dynamically loaded here -->
          <!-- Comment Modal -->
          <div class="modal fade" id="commentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalProjectHeader"></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div id="modalPostContent" class="mb-3"></div>
                  <div id="modalComments">Loading comments...</div>
                </div>
                <div class="d-flex parent-comment-div p-2">
                  <input type="text" placeholder="Write a comment..." data-id="${post.id}" class="comment-input" />
                  <button class="add-comment" data-id="${post.id}"><i class="ri-send-plane-2-line"></i></button>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div id="noResultsMessage" class="d-none text-center mt-5">
          <i class="ri-emotion-sad-line display-1 text-muted mb-3"></i>
          <h3 class="fw-bold">No result found</h3>
          <p>Try refining your search or changing the category</p>
        </div>
      </section>
    </div>
  </main>

  <!-- Project Upload Modal (Same as in projects.php) -->
 <div class="modal fade" id="projectUploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            
            <div class="modal-header border-0 pb-0 pt-4">
                <div>
                    <h4 class="modal-title fw-bold" style="color: #1a1a1a;">Upload Project</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
          <form id="projectUploadForm" class="compact-form">
               <div class="form-group-custom">
        <label for="projectTitle">Project Title*</label>
        <input type="text" id="projectTitle" placeholder="Give your masterpiece a name" required>
    </div>
                <div class="form-row-custom">
        <div class="form-group-custom flex-1">
            <label for="projectType">Category*</label>
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
               <div class="form-group-custom flex-1">
    <label for="projectTechnologies">Technologies</label>
    <div class="tag-input-wrapper" id="tagInputContainer">
        <input type="text" id="projectTechnologies" placeholder="Press Enter or Space to add tags...">
        <div id="tagsWrapper" class="tags-display-area"></div>
    </div>
</div>
              </div>
<div class="form-group-custom">
        <label for="projectDescription">Description*</label>
        <textarea id="projectDescription" rows="4" placeholder="Describe the problem you solved..." required></textarea>
    </div>
              <div class="form-group-custom">
                <label>Project Media (2-8 images)</label>
                <div class="upload-area" id="mediaUploadArea">
                  <i class="bi bi-images upload-icon"></i>
                  <p class="mb-1">Drag & drop or click to upload</p>
                  <small class="text-muted">Max 8 images (800x600 recommended)</small>
                  <input type="file" id="mediaUpload" name="mediaFiles[]" multiple accept="image/*"
                    style="display: none;" max="8">
                </div>
                <div id="mediaPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                <div id="mediaCounter" class="text-muted small mt-1">0/8 images selected</div>
              </div>

             <div class="form-group-custom">
        <label>Project Assets</label>
        <div class="link-input-group">
           <div class="icon-input">
                     <i class="bi bi-download"></i>
                  <input type="url" id="downloadLink" placeholder="Executable Download URL">
                </div>
            <div class="icon-input">
                <i class="bi bi-github"></i>
                <input type="url" id="githubLink" placeholder="GitHub Repository URL">
            </div>
            <div class="icon-input">
                <i class="bi bi-globe"></i>
                <input type="url" id="liveLink" placeholder="Live Demo URL">
            </div>
        </div>
    </div>
          </form>
        </div>
        <div id="uploadOverlay"
          class="position-absolute d-flex flex-column justify-content-center start-0 w-100 h-100 bg-light bg-opacity-75 d-none justify-content-center align-items-center"
          style="z-index: 1051;">
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
        <div class="modal-footer border-0 p-4">
        <button type="button" class="btn btn-outline-secondary border-0" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="projectUploadForm" class="btn btn-success px-4" style="background-color: #007a00;">
          Upload Project
        </button>
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

   <!-- 📌 Bottom Navigation (mobile only) -->
  <nav class="d-lg-none fixed-bottom bg-white shadow-lg border-0 bottom-nav">
    <div class="d-flex justify-content-around align-items-center py-2">

      <a href="home.php" class="nav-item-mobile">
        <i class="ri-home-5-line"></i>
        <span>Home</span>
      </a>

      <a href="#" class="nav-item-mobile active">
        <i class="ri-shapes-fill"></i>
        <span style="color: #007a00">Projects</span>
      </a>

      <a href="settings.php" class="nav-item-mobile">
        <i class="ri-settings-4-line"></i>
        <span>Settings</span>
      </a>

      <a href="profile.php" class="nav-item-mobile">
        <img src="./assets/img/team/default_user.png" class="rounded-circle user-avatar border profile-icon"
          alt="Profile">
        <span>Profile</span>
      </a>

    </div>
  </nav>

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

  <!-- Main JS File -->
  <script src="./students/project-studs.js"></script>



  <script src="./students/profile-picture-handler.js" defer></script> <!-- For Handleling profile picture Image -->
  <script src="./students/profile-search-studs.js" defer></script> <!-- For Handleling search engine -->

  <script>
    //session
    const studentId = <?php echo json_encode($_SESSION['user_id']); ?>;
    const currentStudentId = <?php echo json_encode($_SESSION['user_id']); ?>;
  </script>



</body>

</html>