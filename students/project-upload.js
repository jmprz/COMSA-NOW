


//
// project upload modal and media upload functionality
//
document.addEventListener('DOMContentLoaded', function () {
  // Initialize project upload modal
  const uploadBtns = [
    document.getElementById('uploadProjectBtn'),
    document.getElementById('uploadProjectBtnEmpty'),
    document.getElementById('uploadProjectBtnMobile')
  ].filter(Boolean); // Filter out null elements

  uploadBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      var modal = new bootstrap.Modal(document.getElementById('projectUploadModal'));
      modal.show();
    });
  });


  // Handle media upload with max 8 images
  const mediaUpload = document.getElementById('mediaUpload');
  const mediaPreview = document.getElementById('mediaPreview');
  const mediaCounter = document.getElementById('mediaCounter');
  const uploadArea = document.getElementById('mediaUploadArea');
  const browseBtn = document.querySelector('.upload-browse-btn');

  if (browseBtn && mediaUpload) {
    browseBtn.addEventListener('click', function() {
      mediaUpload.click();
    });
  }

  if (mediaUpload && mediaPreview && mediaCounter && uploadArea) {
    mediaUpload.addEventListener('change', function (e) {
      handleMediaFiles(e.target.files);
    });

    // Drag and drop functionality
    ['dragover', 'dragleave', 'drop'].forEach(eventName => {
      uploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
      e.preventDefault();
      e.stopPropagation();
    }

    uploadArea.addEventListener('dragover', function () {
      this.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', function () {
      this.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', function (e) {
      this.classList.remove('drag-over');
      handleMediaFiles(e.dataTransfer.files);
    });

    // Drag and drop functionality
    const uploadArea = document.getElementById('mediaUploadArea');

    ['dragover', 'dragleave', 'drop'].forEach(eventName => {
      uploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
      e.preventDefault();
      e.stopPropagation();
    }

    uploadArea.addEventListener('dragover', function () {
      this.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', function () {
      this.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', function (e) {
      this.classList.remove('drag-over');
      const files = e.dataTransfer.files;
      mediaUpload.files = files;
      mediaUpload.dispatchEvent(new Event('change'));
    });

    function updateMediaCounter() {
      const count = mediaPreview.children.length;
      mediaCounter.textContent = `${count}/8 images selected`;
    }
  }
});

