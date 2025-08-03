


//
// project upload modal and media upload functionality
//
document.addEventListener('DOMContentLoaded', function() {
  // Initialize project upload modal
  const uploadBtn = document.getElementById('uploadProjectBtn');
  if (uploadBtn) {
    uploadBtn.addEventListener('click', function() {
      var modal = new bootstrap.Modal(document.getElementById('projectUploadModal'));
      modal.show();
    });
  }

  // Handle media upload with max 8 images
  const mediaUpload = document.getElementById('mediaUpload');
  const mediaPreview = document.getElementById('mediaPreview');
  const mediaCounter = document.getElementById('mediaCounter');
  
  if (mediaUpload) {
    mediaUpload.addEventListener('change', function(e) {
      const files = Array.from(e.target.files).slice(0, 8); // Limit to 8 pics/files
      mediaPreview.innerHTML = '';
      
      files.forEach((file, index) => {
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = function(event) {
            const previewItem = document.createElement('div');
            previewItem.className = 'position-relative';
            
            const img = document.createElement('img');
            img.src = event.target.result;
            img.className = 'upload-preview';
            
            const removeBtn = document.createElement('button');
            removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 m-1 p-1';
            removeBtn.innerHTML = '<i class="bi bi-x"></i>';
            removeBtn.onclick = function() {
              previewItem.remove();
              updateMediaCounter();
            };
            
            previewItem.appendChild(img);
            previewItem.appendChild(removeBtn);
            mediaPreview.appendChild(previewItem);
          };
          reader.readAsDataURL(file);
        }
      });
      
      updateMediaCounter();
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
    
    uploadArea.addEventListener('dragover', function() {
      this.classList.add('drag-over');
    });
    
    uploadArea.addEventListener('dragleave', function() {
      this.classList.remove('drag-over');
    });
    
    uploadArea.addEventListener('drop', function(e) {
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





//
// Project category filter functionality
//
   document.addEventListener('DOMContentLoaded', function() {
  const categoryItems = document.querySelectorAll('.category-item');
  const projectContainers = document.querySelectorAll('.project-container');
  
  categoryItems.forEach(item => {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      
      const categoryId = this.id.replace('category-', '');
      
      // Remove active class from all category items
      categoryItems.forEach(ci => ci.classList.remove('active'));
      
      // Add active class to clicked category
      this.classList.add('active');
      
      // Show/hide projects based on category
      projectContainers.forEach(project => {
        const projectBadge = project.querySelector('.project-badge').textContent;
        
        if (categoryId === 'all') {
          project.style.display = 'block';
        } else {
          // Create a mapping between category IDs and badge texts
          const categoryMap = {
            'games': 'Game',
            'websites': 'Website',
            'mobile': 'Mobile App',
            'console': 'Console App',
            'ai': 'AI/ML',
            'databases': 'Database'
          };
          
          if (categoryMap[categoryId] === projectBadge) {
            project.style.display = 'block';
          } else {
            project.style.display = 'none';
          }
        }
      });
    });
  });
  
  // Activate "All" category by default
  const allCategory = document.getElementById('category-all');
  if (allCategory) {
    allCategory.classList.add('active');
  }



  // Initialize viewer for project images
  const projectImageViewer = new bootstrap.Modal(document.getElementById('projectImageViewer'));
  
  // Get all project images
  const projectImages = document.querySelectorAll('.project-image');

  projectImages.forEach((image, index) => {
    // Assign unique ID to each image if not already present
    if (!image.id) {
      image.id = `project-image-${index}`;
    }
    
    image.addEventListener('click', function() {
      // Get the image source and alt text
      const imgSrc = this.src;
      const imgAlt = this.alt || 'Project Image';
      
      // Set the modal content
      document.getElementById('projectImageView').src = imgSrc;
      
      // Show the modal
      projectImageViewer.show();
    });
  });
  
  // Optional: Add keyboard navigation
  document.addEventListener('keydown', function(e) {
    if (projectImageViewer._isShown) {
      if (e.key === 'Escape') {
        projectImageViewer.hide();
      }
    }
  });
});

