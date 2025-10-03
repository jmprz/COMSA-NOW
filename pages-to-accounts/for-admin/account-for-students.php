<?php
require_once '../../../backend/middleware/admin_middleware.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>COMSA-NOW - Student Accounts</title>
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
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
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
    .student-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .action-dropdown .dropdown-toggle::after {
      display: none;
    }

    .student-details-card {
      border-radius: 8px;
      overflow: hidden;
    }

    .student-profile-header {
      height: 120px;
      background-color: #7db832;
      position: relative;
    }

    .student-profile-avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 4px solid white;
      position: absolute;
      bottom: -50px;
      left: 20px;
      object-fit: cover;
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

    .student-info-item {
      display: flex;
      margin-bottom: 15px;
    }

    .student-info-label {
      font-weight: 600;
      width: 100px;
    }

    .image-upload-container {
      border: 2px dashed #dee2e6;
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s;
    }

    .image-upload-container:hover {
      border-color: #7db832;
      background-color: rgba(125, 184, 50, 0.05);
    }

    .upload-icon {
      font-size: 2rem;
      color: #7db832;
      margin-bottom: 10px;
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
              <a href="account-for-students.php" class="btn text-start d-flex align-items-center gap-2 btn-active active">
                <i class="ri-group-line"></i> <span>Students</span>
              </a>
              <a href="posting-config-admin.php" class="btn text-start d-flex align-items-center gap-2">
                <i class="ri-file-text-line"></i> <span>Posts</span>
              </a>
              <a href="project-config-admin.php" class="btn text-start d-flex align-items-center gap-2">
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
            <button type="button" class="btn p-0 border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#adminProfileModal">
              <img src="../../assets/img/team/default_user.png" class="rounded-circle" alt="Profile" style="width: 40px; height: 40px;">
            </button>
          </div>
        </div>

        <!-- Dashboard Content -->
        <div class="admin-content p-4">
          <!-- Student Management Header -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">Student Accounts</h2>
                <div class="d-flex gap-2">

                  <button class="btn btn-success" data-bs-toggle="modal">
                    <a href="#" style="color: white;"> <i class="ri-group-2-line"></i> Bulk Create </a>
                  </button>

                  <!-- Add New Student Button -->
                  <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    <i class="ri-user-add-line"></i> Add Student
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Student Management Tabs -->
          <div class="card mb-4">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs" id="studentManagementTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="all-students-tab" data-bs-toggle="tab" data-bs-target="#all-students" type="button" role="tab">All Students</button>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="studentManagementTabsContent">
                <!-- All Students Tab -->

                <div class="tab-pane fade show active" id="all-students" role="tabpanel">
                  <div class="table-responsive">
                    <table id="allStudentsTable" class="table table-hover">
                      <thead id="tableHeadStudents">
                        <tr>
                          <th>ID</th>
                          <th>Student</th>
                          <th>Email</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody id="studentsTableBody">

                        <!-- this is the students tab -->

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
      <a href="account-for-students.php" class="text-center mt-2 btn-active-mobile">
        <i class="ri-group-line fs-1"></i>
      </a>
      <a href="posting-config-admin.php" class="text-center mt-2">
        <i class="ri-file-text-line fs-1"></i>
      </a>
      <a href="project-config-admin.php" class="text-center mt-2">
        <i class="ri-projector-line fs-1"></i>
      </a>
      <a href="admin-dashboard.php#settings-section" class="text-center mt-2">
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
          <form name="addStudentForm" id="addStudentForm" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="studentFirstName" class="form-label">First Name</label>
                  <input name="studentFirstName" type="text" class="form-control" id="studentFirstName" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="studentLastName" class="form-label">Last Name</label>
                  <input name="studentLastName" type="text" class="form-control" id="studentLastName" required>
                </div>
              </div>

            <div class="col-md-6">
               <div class="mb-3">
                <label for="yearLevel" class="form-label">Year Level</label>
                  <select name="yearLevel" class="form-select" id="yearLevel" required>
                    <option value="" disabled selected></option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                  </select>
                </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
               <label for="section" class="form-label">Section</label>
                <select name="section" class="form-select" id="section" required>
                  <option value="" disabled selected></option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                </select>
               </div>
            </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label for="studentEmail" class="form-label">Email</label>
                  <input name="studentEmail" type="email" class="form-control" id="studentEmail" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="studentID" class="form-label">Student ID</label>
                  <input name="studentID" type="text" class="form-control" id="studentID" required>
                </div>
              </div>

              <div class="col-12">
                <div class="mb-3">
                  <label for="studentAvatar" class="form-label">Profile Picture</label>
                  <div class="image-upload-container mb-2" onclick="document.getElementById('studentAvatar').click()">
                    <i class="ri-user-line upload-icon"></i>
                    <p class="mb-1">Click to upload profile picture</p>
                    <p class="small text-muted">JPG, PNG (Max 2MB)</p>
                    <input type="file" name="studentAvatar" id="studentAvatar" accept="image/*" style="display: none;">
                  </div>
                  <div class="text-center">
                    <img id="studentAvatarPreview" class="rounded-circle" width="100" height="100" style="display: none; object-fit: cover;">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>


        <div id="studentUploadOverlay" class="position-absolute d-flex flex-column justify-content-center start-0 w-100 h-100 bg-light bg-opacity-75 d-none justify-content-center align-items-center" style="z-index: 1051;">
          <div id="studentUploadLoader" class="text-center">
            <div class="spinner-border text-success" role="status"></div>
            <p class="mt-2 fw-semibold">Adding...</p>
          </div>
          <div id="studentUploadSuccess" class="text-center d-none">
            <i class="bi bi-check-circle-fill text-success fs-1"></i>
            <p class="mt-2 fw-semibold">Add Successful!</p>
          </div>
        </div>

        <div id="studentGeneralUploadError" class="text-danger fw-semibold text-center d-none mt-2"></div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" form="addStudentForm" class="btn btn-success">Add Student</button>
        </div>
      </div>
    </div>
  </div>

  <!-- View Student Modal -->
  <div class="modal fade" id="viewStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Student Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-4">
            <img src="../../assets/img/team/default_user.png" id="studentImage" class="rounded-circle" width="120" height="120" style="object-fit: cover;" alt="Student Avatar">
          </div>

          <div class="student-info-container">
            <div class="student-info-item">
              <div class="student-info-label">Name</div>
              <div id="studentName"></div>
            </div>
            <div class="student-info-item">
              <div class="student-info-label">Email</div>
              <div id="viewStudentEmail"></div>
            </div>
            <div class="student-info-item">
              <div class="student-info-label">Student ID</div>
              <div id="studentId"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="studentViewEditBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editStudentModal" data-bs-dismiss="modal">
            <i class="ri-edit-line me-1"></i> Edit Profile
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Student Modal -->
  <div class="modal fade" id="editStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Student Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editStudentForm" enctype="multipart/form-data">
            <input name="editStudentId" type="text" class="form-control d-none" id="editStudentId" required>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="editFirstName" class="form-label">Name</label>
                  <input name="editFirstName" type="text" class="form-control" id="editFirstName" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label for="editEmail" class="form-label">Email</label>
                  <input name="editEmail" type="email" class="form-control" id="editEmail" value="Valexore@huh.edu" required>
                </div>
              </div>
                 <div class="col-md-6">
                <div class="mb-3">
                  <label for="editYearLevel" class="form-label">Year Level</label>
                  <select name="editYearLevel" class="form-select" id="editYearLevel" required>
                    <option value="" disabled selected></option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                  </select>
                </div>
              </div>

                 <div class="col-md-6">
                <div class="mb-3">
                  <label for="editSection" class="form-label">Section</label>
                  <select name="editSection" class="form-select" id="editSection" required>
                    <option value="" disabled selected></option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                  </select>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="editStudentID" class="form-label">Student ID</label>
                  <input name="editStudentID" type="text" class="form-control" id="editStudentID" value="STU2023001" required>
                </div>
              </div>

              <div class="col-12">
                <div class="mb-3">
                  <label for="editAvatar" class="form-label">Profile Picture</label>
                  <div class="d-flex align-items-center gap-4">
                    <img src="../../assets/img/team/default_user.png" name="editAvatarPreview" id="editAvatarPreview" class="rounded-circle" width="100" height="100" style="object-fit: cover;">
                    <div>
                      <button type="button" class="btn btn-sm btn-outline-primary mb-2" onclick="document.getElementById('editAvatar').click()">
                        <i class="ri-upload-line me-1"></i> Change Photo
                      </button>
                      <input name="editAvatar" type="file" id="editAvatar" accept="image/*" style="display: none;">
                      <p class="small text-muted mb-0">JPG, PNG (Max 2MB)</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div id="studentEditUploadOverlay" class="position-absolute d-flex flex-column justify-content-center start-0 w-100 h-100 bg-light bg-opacity-75 d-none justify-content-center align-items-center" style="z-index: 1051;">
          <div id="studentEditUploadLoader" class="text-center">
            <div class="spinner-border text-success" role="status"></div>
            <p class="mt-2 fw-semibold">Editing...</p>
          </div>
          <div id="studentEditUploadSuccess" class="text-center d-none">
            <i class="bi bi-check-circle-fill text-success fs-1"></i>
            <p class="mt-2 fw-semibold">Edited Successfully!</p>
          </div>
        </div>

        <div id="studentEditGeneralUploadError" class="text-danger fw-semibold text-center d-none mt-2"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" form="editStudentForm" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/aos/aos.js"></script>
  <script src="../../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

  <!-- Main JS File -->
  <script src="../../assets/js/main.js"></script>
  <script src="./js/admin-logout.js"></script>
  <script src="./js/student.js"></script>


  <script>
    // Initialize DataTables
    $(document).ready(function() { // responsible for search bar and pagination

      // Image preview for add student form
      $('#studentAvatar').change(function() {
        const file = this.files[0];
        if (file) {
          if (file.size > 2 * 1024 * 1024) {
            alert('File size exceeds 2MB limit');
            return;
          }
          const reader = new FileReader();
          reader.onload = function(e) {
            $('#studentAvatarPreview').attr('src', e.target.result).show();
          }
          reader.readAsDataURL(file);
        }
      });

      // Image preview for edit student form
      $('#editAvatar').change(function() {
        const file = this.files[0];
        if (file) {
          if (file.size > 2 * 1024 * 1024) {
            alert('File size exceeds 2MB limit');
            return;
          }
          const reader = new FileReader();
          reader.onload = function(e) {
            $('#editAvatarPreview').attr('src', e.target.result);
          }
          reader.readAsDataURL(file);
        }
      });
    });
  </script>
</body>

</html>