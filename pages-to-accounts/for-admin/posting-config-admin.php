<?php
require_once '../../../backend/middleware/admin_middleware.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>COMSA-NOW - Post Configuration</title>
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
  <link rel="stylesheet" href="../../assets/css/dark-mode.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    .post-preview-container {
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 15px;
      background-color: #fff;
      margin-bottom: 20px;
    }

    .post-preview-container.dark-mode {
      background-color: #1e1e1e;
      border-color: #333;
    }

    .post-preview-header {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }

    .post-preview-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .post-preview-image {
      width: 100%;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .post-actions-preview {
      display: flex;
      margin-bottom: 10px;
    }

    .post-action-preview {
      background: none;
      border: none;
      margin-right: 15px;
      font-size: 1.2rem;
      color: #495057;
    }

    .dark-mode .post-action-preview {
      color: #e0e0e0;
    }

    .post-caption-preview {
      margin-bottom: 10px;
    }

    .post-comments-preview {
      max-height: 200px;
      overflow-y: auto;
      margin-bottom: 10px;
    }

    .tag-badge {
      margin-right: 5px;
      margin-bottom: 5px;
    }

    .editor-container {
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 15px;
      background-color: #fff;
      margin-bottom: 20px;
    }

    .dark-mode .editor-container {
      background-color: #1e1e1e;
      border-color: #333;
    }

    .image-upload-container {
      border: 2px dashed #dee2e6;
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      margin-bottom: 15px;
    }

    .dark-mode .image-upload-container {
      border-color: #555;
    }

    .image-upload-container:hover {
      border-color: #7db832;
    }

    .upload-icon {
      font-size: 2rem;
      color: #7db832;
      margin-bottom: 10px;
    }

    .image-preview {
      max-width: 100%;
      max-height: 300px;
      margin-bottom: 15px;
      display: none;
    }

    .schedule-options {
      display: none;
      margin-top: 15px;
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

    .comments-container {
      scrollbar-width: thin;
      scrollbar-color: #7db832 #f1f1f1;
    }

    .comments-container::-webkit-scrollbar {
      width: 6px;
    }

    .comments-container::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    .comments-container::-webkit-scrollbar-thumb {
      background-color: #7db832;
      border-radius: 6px;
    }

    .dark-mode .comments-container::-webkit-scrollbar-track {
      background: #2a2a2a;
    }

    .comment-delete-btn {
      opacity: 0;
      transition: opacity 0.2s;
    }

    .post-comment:hover .comment-delete-btn {
      opacity: 1;
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
              <a href="posting-config.php" class="btn text-start d-flex align-items-center gap-2 btn-active active">
                <i class="ri-file-text-line"></i> <span>Posts</span>
              </a>
              <a href="project-config-admin.php" class="btn text-start d-flex align-items-center gap-2 btn-active">
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
              <img src="../../assets/img/team/default_user.png" class="rounded-circle" alt="Profile"
                style="width: 40px; height: 40px;">
            </button>
          </div>
        </div>

        <!-- Dashboard Content -->
        <div class="admin-content p-4">
          <!-- Post Management Header -->
          <!-- Post Management Header - Updated with Search Bar -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">Post Management</h2>
                <div class="d-flex gap-2">
                  <!-- Search Bar -->
                  <div class="input-group" style="width: 250px;">
                    <input type="text" class="form-control" placeholder="Search posts..." id="postSearchInput">
                    <button class="btn btn-outline-secondary" type="button" id="postSearchButton">
                      <i class="ri-search-line"></i>
                    </button>
                  </div>

                  <!-- Create New Post Button -->
                  <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createPostModal">
                    <i class="ri-add-line"></i> Create New Post
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Post Management Tabs -->
          <div class="card mb-4">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs" id="postManagementTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="all-posts-tab" data-bs-toggle="tab" data-bs-target="#all-posts"
                    type="button" role="tab">All Posts</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="published-tab" data-bs-toggle="tab" data-bs-target="#published"
                    type="button" role="tab">Published</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="drafts-tab" data-bs-toggle="tab" data-bs-target="#drafts" type="button"
                    role="tab">Drafts</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="archived-tab" data-bs-toggle="tab" data-bs-target="#archived"
                    type="button" role="tab">Archived</button>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="postManagementTabsContent">
                <!-- All Posts Tab -->
                <div class="tab-pane fade show active" id="all-posts" role="tabpanel">
                  <div class="table-responsive">
                    <table id="allPostsTable" class="table table-hover">
                      <thead id="tableHeadPost">
                        <tr>
                          <th>ID</th>
                          <th>Post</th>
                          <th>Date</th>
                          <th>Status</th>
                          <th>Engagement</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody id="tableBodyPost">
                        <!-- this is the table for ALL Post Filter -->

                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Published Tab -->
                <div class="tab-pane fade" id="published" role="tabpanel">
                  <div class="table-responsive">
                    <table id="publishedPostsTable" class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Post</th>
                          <th>Date</th>
                          <th>Engagement</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Content will be populated by JavaScript -->
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Drafts Tab -->
                <div class="tab-pane fade" id="drafts" role="tabpanel">
                  <div class="table-responsive">
                    <table id="draftsTable" class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Post</th>
                          <th>Last Updated</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Content will be populated by JavaScript -->
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Archived Tab -->
                <div class="tab-pane fade" id="archived" role="tabpanel">
                  <div class="table-responsive">
                    <table id="archivedTable" class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Post</th>
                          <th>Date Archived</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Content will be populated by JavaScript -->
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
      <a href="admin-dashboard.php" class="text-center mt-2">
        <i class="ri-dashboard-line fs-1"></i>
      </a>
      <a href="admin-dashboard.php#students-section" class="text-center mt-2">
        <i class="ri-group-line fs-1"></i>
      </a>
      <a href="posting-config-admin.php" class="text-center mt-2 btn-active-mobile">
        <i class="ri-file-text-line fs-1"></i>
      </a>
      <a href="admin-dashboard.php#content-section" class="text-center mt-2">
        <i class="ri-file-text-line fs-1"></i>
      </a>
      <a href="admin-dashboard.php#settings-section" class="text-center mt-2">
        <i class="ri-settings-line fs-1"></i>
      </a>
    </div>
  </nav>

  <!-- Create Post Modal -->
  <div class="modal fade" id="createPostModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create New Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="postForm" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-8">
                <!-- Post Content Editor -->
                <div class="mb-3">
                  <label for="postTitle" class="form-label">Post Title</label>
                  <input name="postTitle" type="text" class="form-control" id="postTitle" placeholder="Enter post title" required>
                </div>

                <div class="mb-3">
                  <label for="postContent" class="form-label">Content</label>
                  <textarea name="postContent" class="form-control" id="postContent" rows="8"
                    placeholder="Write your post content here..." required></textarea>
                </div>

                <!-- Image Upload -->
                <div class="mb-3">
                  <label class="form-label">Featured Image</label>
                  <div class="image-upload-container" id="imageUploadContainer">
                    <i class="ri-image-add-line upload-icon"></i>
                    <p class="mb-1">Click to upload or drag and drop</p>
                    <p class="small text-muted mb-0">PNG, JPG up to 5MB</p>
                    <input type="file" name="imageUpload" id="imageUpload" accept="image/*" required>
                  </div>
                  <img id="imagePreview" class="image-preview rounded">
                </div>

                <!-- Tags -->
                <div class="mb-3">
                  <label for="postTags" class="form-label">Tags</label>
                  <div class="border p-2 rounded" id="tagInputContainer" style="min-height: 50px;">
                    <input name="postTags" type="text" class="form-control" id="postTags" placeholder="Add tags separated by space">
                    <span id="tagsWrapper" class="mt-2 d-flex flex-wrap gap-1"></span>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <!-- Post Settings -->
                <div class="card">
                  <div class="card-header">
                    <h6 class="mb-0">Post Settings</h6>
                  </div>
                  <div class="card-body">
                    <!-- Publish Options -->
                    <div class="mb-3">
                      <label class="form-label">Publish Options</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="publishOption" id="publishNow" value="published"
                          checked>
                        <label class="form-check-label" for="publishNow">
                          Publish Immediately
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="publishOption" id="publishDraft"
                          value="draft">
                        <label class="form-check-label" for="publishDraft">
                          Save as Draft
                        </label>
                      </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success w-100">
                      <i class="ri-save-line me-2"></i> Save Post
                    </button>
                  </div>
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
      </div>
    </div>
  </div>

  <!-- Edit Post Modal -->
  <div class="modal fade" id="editPostModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editPostForm">
            <input type="hidden" name="postId" id="editPostId">
            <div class="row">
              <div class="col-md-8">
                <!-- Post Content Editor -->
                <div class="mb-3">
                  <label for="editPostTitle" class="form-label">Post Title</label>
                  <input type="text" name="editPostTitle" class="form-control" id="editPostTitle">
                </div>

                <div class="mb-3">
                  <label for="editPostContent" class="form-label">Content</label>
                  <textarea name="editPostContent" class="form-control" id="editPostContent"
                    rows="8"></textarea>
                </div>

                <!-- Image Upload -->
                <div class="mb-3">
                  <label class="form-label">Featured Image</label>
                  <div class="image-upload-container" id="editImageUploadContainer">
                    <img src="../../assets/img/csexpo.jpg" name="editImagePreview" id="editImagePreview" class="image-preview rounded"
                      style="display: block;">
                  </div>
                  <input type="file" name="editImageUpload" id="editImageUpload" accept="image/*" style="display: none;">
                  <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="changeImageBtn">
                    <i class="ri-image-edit-line me-1"></i> Change Image
                  </button>
                </div>

                <!-- Tags -->
                <div class="mb-3">
                  <label for="editPostTags" class="form-label">Tags</label>
                  <input type="text" name="editPostTags" class="form-control" id="editPostTags">
                  <div class="mt-2" id="editTagsContainer">
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <!-- Post Settings -->
                <div class="card">
                  <div class="card-header">
                    <h6 class="mb-0">Post Settings</h6>
                  </div>
                  <div class="card-body">
                    <!-- Status -->
                    <div class="mb-3">
                      <label class="form-label">Status</label>
                      <select name="editPostStatus" class="form-select" id="editPostStatus">
                        <option value="published">Published</option>
                        <!-- <option value="scheduled">Scheduled</option> -->
                        <option value="draft">Draft</option>
                      </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success w-100">
                      <i class="ri-save-line me-2"></i> Update Post
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div id="editPostUploadOverlay" class="position-absolute d-flex flex-column justify-content-center start-0 w-100 h-100 bg-light bg-opacity-75 d-none justify-content-center align-items-center" style="z-index: 1051;">
          <div id="editPostUploadLoader" class="text-center">
            <div class="spinner-border text-success" role="status"></div>
            <p class="mt-2 fw-semibold">Editing...</p>
          </div>
          <div id="editPostUploadSuccess" class="text-center d-none">
            <i class="bi bi-check-circle-fill text-success fs-1"></i>
            <p class="mt-2 fw-semibold">Edit Successful!</p>
          </div>
        </div>

        <div id="editPostGeneralUploadError" class="text-danger fw-semibold text-center d-none mt-2"></div>
      </div>
    </div>
  </div>

  <!-- View Post Modal -->
  <div class="modal fade" id="viewPostModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Changed to modal-xl for larger size -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">View Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0"> <!-- Removed padding to allow full-width layout -->
          <div class="row g-0"> <!-- Added row with no gap -->
            <!-- Main Post Content (Left Side) -->
            <div class="col-md-8">
              <div class="post-preview-container h-100" style="border-radius: 0; border-right: 1px solid #dee2e6;">
                <div class="post-preview-header">
                  <img src="../../assets/img/team/default_user.png" class="post-preview-avatar" alt="Admin Avatar">
                  <div>
                    <h6 id="adminViewName" class="mb-0">Admin</h6>
                    <small id="adminPostDate" class="text-muted">Posted on June 15, 2024</small>
                  </div>
                </div>

                <h4 id="adminViewTitle" class="my-3">AI-powered campus navigation system</h4>

                <img src="../../assets/img/csexpo.jpg" id="adminViewImage" class="post-preview-image" alt="Post Image">

                <div class="post-caption-preview">
                  <p id="adminViewContent">Just launched our AI-powered campus navigation system! 🚀 #CSExpo2024 #AI #Innovation</p>
                </div>

                <div class="post-actions-preview">
                  <button id="adminViewLike" class="post-action-preview">
                    <i class="ri-star-line"></i>
                  </button>
                  <button id="adminViewComment" class="post-action-preview">
                    <i class="ri-chat-3-line"></i>
                  </button>
                  <button id="adminViewShare" class="post-action-preview">
                    <i class="ri-share-line"></i> Share
                  </button>
                </div>

                <div class="mb-2" id="adminViewTagContainer">
                </div>
              </div>
            </div>

            <!-- Comments Section (Right Side) -->
            <div class="col-md-4">
              <div class="h-100 d-flex flex-column">
                <div class="p-3 border-bottom">
                  <h5 class="mb-0" id="adminViewCommentCount"></h5>
                </div>

                <div id="viewCommentsContainer" class="comments-container flex-grow-1 overflow-auto p-3" style="max-height: 400px;">
                  <!-- <div class="post-comment mb-3 position-relative">
                    <div class="d-flex align-items-start">
                      <img src="../../assets/img/team/default_user.png" class="rounded-circle me-2" width="32" height="32" alt="User">
                      <div>
                        <strong class="d-block">student1</strong>
                        <span>This is amazing! How does the AI work?</span>
                      </div>
                    </div>
                    <button class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 p-1 comment-delete-btn" title="Delete comment">
                      <i class="ri-delete-bin-line"></i>
                    </button>
                  </div>

                  <div class="post-comment mb-3 position-relative">
                    <div class="d-flex align-items-start">
                      <img src="../../assets/img/team/default_user.png" class="rounded-circle me-2" width="32" height="32" alt="User">
                      <div>
                        <strong class="d-block">professor_x</strong>
                        <span>Great work team! Looking forward to seeing this in action.</span>
                      </div>
                    </div>
                    <button class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 p-1 comment-delete-btn" title="Delete comment">
                      <i class="ri-delete-bin-line"></i>
                    </button>
                  </div>

                  <div class="post-comment mb-3 position-relative">
                    <div class="d-flex align-items-start">
                      <img src="../../assets/img/team/default_user.png" class="rounded-circle me-2" width="32" height="32" alt="User">
                      <div>
                        <strong class="d-block">tech_enthusiast</strong>
                        <span>Can't wait to try this out on campus!</span>
                      </div>
                    </div>
                    <button class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 p-1 comment-delete-btn" title="Delete comment">
                      <i class="ri-delete-bin-line"></i>
                    </button>
                  </div>

                  <div class="post-comment mb-3 position-relative">
                    <div class="d-flex align-items-start">
                      <img src="../../assets/img/team/default_user.png" class="rounded-circle me-2" width="32" height="32" alt="User">
                      <div>
                        <strong class="d-block">anonymous_user</strong>
                        <span class="text-danger">This is a bad comment that should be removed!</span>
                      </div>
                    </div>
                    <button class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 p-1 comment-delete-btn" title="Delete comment">
                      <i class="ri-delete-bin-line"></i>
                    </button>
                  </div> -->
                </div>

                <div class="p-3 border-top">
                  <div class="input-group">
                    <input type="text" id="adminViewAddComment" class="form-control" placeholder="Add a comment...">
                    <button id="adminViewSubmitComment" class="btn btn-success" type="button">
                      <i class="ri-send-plane-line"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="adminViewCloseBtn" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="adminViewSubmitBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPostModal"
            data-bs-dismiss="modal">
            <i class="ri-edit-line me-1"></i> Edit Post
          </button>
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
            <img src="../../assets/img/team/default_user.png" class="rounded-circle mb-3" width="100" height="100"
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

  <!-- Main JS File -->
  <script src="../../assets/js/main.js"></script>
  <script src="../for-admin/js/search-config-post.js"></script>
  <script src="../js/"></script>
  <script src="../for-admin/js/admin-comment-deletion.js"></script>

  <script src="./js/admin-logout.js"></script>
  <script src="./js//post.js"></script>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize DataTables
      $('#allPostsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50]
      });

      $('#publishedPostsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50]
      });

      $('#scheduledPostsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50]
      });

      $('#draftsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50]
      });

      $('#archivedTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50]
      });

      // Post creation form functionality
      const imageUploadContainer = document.getElementById('imageUploadContainer');
      const imageUpload = document.getElementById('imageUpload');
      const imagePreview = document.getElementById('imagePreview');

      // Handle image upload
      imageUploadContainer.addEventListener('click', function() {
        imageUpload.click();
      });

      imageUpload.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
          const file = e.target.files[0];
          const reader = new FileReader();

          reader.onload = function(event) {
            imagePreview.src = event.target.result;
            imagePreview.style.display = 'block';
          };

          reader.readAsDataURL(file);
        }
      });

      // Drag and drop for image upload
      imageUploadContainer.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#7db832';
      });

      imageUploadContainer.addEventListener('dragleave', function() {
        this.style.borderColor = '#dee2e6';
      });

      imageUploadContainer.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '#dee2e6';

        if (e.dataTransfer.files.length > 0) {
          imageUpload.files = e.dataTransfer.files;
          const event = new Event('change');
          imageUpload.dispatchEvent(event);
        }
      });

      // Show/hide schedule options
      document.querySelectorAll('input[name="publishOption"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
          const scheduleOptions = document.getElementById('scheduleOptions');
          if (this.value === 'schedule') {
            scheduleOptions.style.display = 'block';
          } else {
            scheduleOptions.style.display = 'none';
          }
        });
      });

      // Handle tags input
      const postTags = document.getElementById('postTags');
      const tagsContainer = document.getElementById('tagsContainer');

      postTags.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
          e.preventDefault();
          const tag = this.value.trim();
          if (tag) {
            addTag(tag);
            this.value = '';
          }
        }
      });

      function addTag(tag) {
        const tagElement = document.createElement('span');
        tagElement.className = 'badge bg-light text-dark tag-badge me-1 mb-1';
        tagElement.textContent = '#' + tag;
        tagsContainer.appendChild(tagElement);
      }

      // Preview post
      const previewPostBtn = document.getElementById('previewPostBtn');
      const postPreviewModal = new bootstrap.Modal(document.getElementById('postPreviewModal'));

      previewPostBtn.addEventListener('click', function() {
        const title = document.getElementById('postTitle').value || 'Post Title';
        const content = document.getElementById('postContent').value || 'Post content will appear here...';

        document.getElementById('previewTitle').textContent = title;
        document.getElementById('previewContent').textContent = content;

        if (imagePreview.src) {
          document.getElementById('previewImage').src = imagePreview.src;
          document.getElementById('previewImage').style.display = 'block';
        } else {
          document.getElementById('previewImage').style.display = 'none';
        }

        postPreviewModal.show();
      });

      // Form submission
      document.getElementById('postForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Here you would normally send the form data to the server
        alert('Post saved successfully!');
        const createPostModal = bootstrap.Modal.getInstance(document.getElementById('createPostModal'));
        createPostModal.hide();
      });

      // Edit post functionality
      const editImageUploadContainer = document.getElementById('editImageUploadContainer');
      const changeImageBtn = document.getElementById('changeImageBtn');
      const editImageUpload = document.getElementById('editImageUpload');
      const editImagePreview = document.getElementById('editImagePreview');

      changeImageBtn.addEventListener('click', function() {
        editImageUpload.click();
      });

      editImageUpload.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
          const file = e.target.files[0];
          const reader = new FileReader();

          reader.onload = function(event) {
            editImagePreview.src = event.target.result;
          };

          reader.readAsDataURL(file);
        }
      });

      // Edit post preview
      const editPreviewPostBtn = document.getElementById('editPreviewPostBtn');
      const viewPostModal = new bootstrap.Modal(document.getElementById('viewPostModal'));

      editPreviewPostBtn.addEventListener('click', function() {
        viewPostModal.show();
      });

      // Edit form submission
      document.getElementById('editPostForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Post updated successfully!');
        const editPostModal = bootstrap.Modal.getInstance(document.getElementById('editPostModal'));
        editPostModal.hide();
      });

    });
  </script>



  <script>
   
  </script>
  

</body>

</html>