console.log("SCRIPT IS LOADED ✅");


const uploadForm = document.getElementById("projectUploadForm");
const closeUpload = document.querySelectorAll(".close-uploadInfo");

const techInput = document.getElementById("projectTechnologies");
const tagWrapper = document.getElementById("tagsWrapper");

const projMemberInput = document.getElementById("projectTeam");
const tagMemberWrapper = document.getElementById("tagsMemberWrapper");

const uploadArea = document.getElementById("mediaUploadArea");
const uploadInput = document.getElementById("mediaUpload");
const mediaPreview = document.getElementById("mediaPreview");
const mediaCounter = document.getElementById("mediaCounter");

let members = [];
let tags = [];
let selectedFiles = [];

techInput.addEventListener("keydown", (e) => {
  if (e.key === " " || e.key === "Enter") {
    e.preventDefault();
    const value = techInput.value.trim();

    if (value !== "" && !tags.includes(value)) {
      // Insert in array
      tags.push(value);
      console.log("Current tags:", tags);

      // New element
      const tag = document.createElement("span");
      tag.className = "badge bg-secondary px-2 py-1 rounded-pill d-flex align-items-center";
      tag.innerText = value;

      // Close button
      const closeBtn = document.createElement("button");
      closeBtn.className = "btn-close btn-close-white btn-sm ms-2";
      closeBtn.type = "button";
      closeBtn.innerHTML = "&times;";
      closeBtn.onclick = () => {
        const index = tags.indexOf(value);
        if (index > -1) tags.splice(index, 1);
        console.log("Updated tags:", tags);

        // Remove element in html
        tag.remove();
      };

      tag.appendChild(closeBtn);
      tagWrapper.appendChild(tag);
      techInput.value = "";
    }
  }
});

projMemberInput.addEventListener("keydown", (e) => {
  if (e.key === "Enter") {
    e.preventDefault();

    const value = projMemberInput.value.trim();

    if (value !== "" && !members.includes(value)) {
      members.push(value);
      console.log("Current members:", members);

      const tag = document.createElement("span");
      tag.className = "badge bg-secondary px-2 py-1 rounded-pill d-flex align-items-center";
      tag.innerText = value;

      const closeBtn = document.createElement("button");
      closeBtn.className = "btn-close btn-close-white btn-sm ms-2";
      closeBtn.type = "button";
      closeBtn.innerHTML = "&times;";
      closeBtn.onclick = () => {
        const index = members.indexOf(value);
        if (index > -1) members.splice(index, 1);
        console.log("Updated members:", members);

        // Remove element in html
        tag.remove();
      };

      tag.appendChild(closeBtn);
      tagMemberWrapper.appendChild(tag);
      projMemberInput.value = "";
    }
  }
});

uploadArea.addEventListener("click", () => {
  uploadInput.click();
});

uploadInput.addEventListener("change", () => {
  const newFiles = Array.from(uploadInput.files);

  // Merge and limit to 8
  const availableSlots = 8 - selectedFiles.length;
  const filesToAdd = newFiles.slice(0, availableSlots);
  selectedFiles = [...selectedFiles, ...filesToAdd];

  renderPreview();

  uploadInput.value = "";
  console.log("Currently selected:", selectedFiles.map(f => f.name));
});

function renderPreview() {
  mediaPreview.innerHTML = "";
  let filesProcessed = 0;

  selectedFiles.forEach((file, index) => {
    const reader = new FileReader();

    reader.onload = (e) => {
      const wrapper = document.createElement("div");
      wrapper.style.position = "relative";

      const img = document.createElement("img");
      img.src = e.target.result;
      img.className = "rounded";
      img.style.width = "100px";
      img.style.height = "auto";

      const removeBtn = document.createElement("button");
      removeBtn.innerHTML = "✖";
      removeBtn.type = "button";
      removeBtn.style.position = "absolute";
      removeBtn.style.top = "0";
      removeBtn.style.right = "0";
      removeBtn.style.background = "rgba(0,0,0,0.5)";
      removeBtn.style.color = "white";
      removeBtn.style.border = "none";
      removeBtn.style.borderRadius = "50%";
      removeBtn.style.cursor = "pointer";
      removeBtn.style.width = "20px";
      removeBtn.style.height = "20px";
      removeBtn.style.fontSize = "12px";
      removeBtn.title = "Remove";

      removeBtn.addEventListener("click", () => {
        selectedFiles.splice(index, 1); // remove from array
        renderPreview(); // re-render
      });

      wrapper.appendChild(img);
      wrapper.appendChild(removeBtn);
      mediaPreview.appendChild(wrapper);

      filesProcessed++;

      // Only update counter after all files processed
      if (filesProcessed === selectedFiles.length) {
        mediaCounter.innerText = `${selectedFiles.length}/8 images selected`;
      }
    };

    reader.readAsDataURL(file);
  });

  if (selectedFiles.length === 0) {
    mediaCounter.innerText = "0/8 images selected";
  }
}

function showFieldError(fieldId) {
  const input = document.getElementById(fieldId);
  if (!input) return;

  input.classList.add("is-invalid");

  let feedback = document.createElement("div");
  feedback.className = "invalid-feedback";
  feedback.innerText = "This field is required.";
  if (!input.nextElementSibling || !input.nextElementSibling.classList.contains("invalid-feedback")) {
    input.parentNode.appendChild(feedback);
  }
}

function clearFieldErrors() {
  document.querySelectorAll(".is-invalid").forEach(el => el.classList.remove("is-invalid"));
  document.querySelectorAll(".invalid-feedback").forEach(el => el.remove());
}

closeUpload.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();

    uploadForm.reset();

    tags = [];
    members = [];
    selectedFiles = [];

    tagWrapper.innerHTML = "";
    tagMemberWrapper.innerHTML = "";
    mediaPreview.innerHTML = "";

    mediaCounter.textContent = "0/8 images selected";
    console.log("Form and arrays cleared");
  });
});

uploadForm.addEventListener("submit", function (e) {
  e.preventDefault();
  e.stopPropagation();

  if (this.checkValidity()) {
    const formData = new FormData();

    formData.append("projectTitle", document.getElementById("projectTitle").value);
    formData.append("projectType", document.getElementById("projectType").value);
    formData.append("projectDescription", document.getElementById("projectDescription").value);
    formData.append("downloadLink", document.getElementById("downloadLink").value);
    formData.append("githubLink", document.getElementById("githubLink").value);
    formData.append("liveLink", document.getElementById("liveLink").value);

    tags.forEach((tag, index) => {
      formData.append('tags[]', tag);
    });
    members.forEach((member, index) => {
      formData.append('members[]', member);
    });
    selectedFiles.forEach((file, index) => {
      formData.append('selectedFiles[]', file);
    });

    document.getElementById("uploadOverlay").classList.remove("d-none");
    document.getElementById("uploadLoader").classList.remove("d-none");
    document.getElementById("uploadSuccess").classList.add("d-none");

    clearFieldErrors();
    document.getElementById("generalUploadError").classList.add("d-none");

    fetch("../../../backend/api/student_upload_proj.php", {
      method: "POST",
      body: formData,
    })
      .then(res => res.json())
      .then(response => {
        if (response.success) {
          document.getElementById("uploadLoader").classList.add("d-none");
          document.getElementById("uploadSuccess").classList.remove("d-none");

          setTimeout(() => {
            const modal = bootstrap.Modal.getInstance(document.getElementById("projectUploadModal"));
            modal.hide();
            document.getElementById("uploadOverlay").classList.add("d-none");

            // Reset form and visuals
            uploadForm.reset();
            selectedFiles = [];
            tags = [];
            members = [];
            tagWrapper.innerHTML = "";
            tagMemberWrapper.innerHTML = "";
            mediaPreview.innerHTML = "";
            mediaCounter.innerText = "0/8 images selected";
            window.location.reload();
          }, 1500);
        } else {
          // Hide overlay
          document.getElementById("uploadOverlay").classList.add("d-none");

          if (response.errors) {
            if (response.errors.empty_input) {
              showFieldError("projectTitle");
              showFieldError("projectType");
              showFieldError("projectDescription");
            }

            if (response.errors.empty_images) {
              document.getElementById("generalUploadError").innerText = response.errors.empty_images;
              document.getElementById("generalUploadError").classList.remove("d-none");
            }

            // Server or unknown errors
            Object.entries(response.errors).forEach(([key, msg]) => {
              if (!["empty_input", "empty_images"].includes(key)) {
                document.getElementById("generalUploadError").innerText = msg;
                document.getElementById("generalUploadError").classList.remove("d-none");
              }
            });
          }
        }
      })
      .catch(err => {
        console.error("Upload failed:", err);
        document.getElementById("uploadOverlay").classList.add("d-none");
        document.getElementById("generalUploadError").innerText = "An unexpected error occurred.";
        document.getElementById("generalUploadError").classList.remove("d-none");
      });
  }
});

document.addEventListener('DOMContentLoaded', () => {
  const socket = new WebSocket("ws://localhost:8080");

  const categoryClassMap = {
    'websites': 'web',
    'mobile apps': 'mobile',
    'games': 'game',
    'ai/ml': 'ai',
    'console apps': 'console',
    'databases': 'databases',
    'others': 'others'
  };

  function getInitials(name) {
    const parts = name.trim().split(" ").filter(Boolean);
    return parts.length === 1
      ? parts[0][0].toUpperCase()
      : (parts[0][0] + parts[1][0]).toUpperCase();
  }

  socket.onmessage = (event) => {
    console.log("📨 Message received:", event.data);

    let data;
    try {
      data = JSON.parse(event.data);
    } catch (e) {
      console.error("❌ Failed to parse message as JSON:", e);
      return;
    }

    if (data.type === 'like') {
      const likeIcon = document.getElementById(`like-icon-${data.project_id}`);

      if (data.status) {
        if (data.status === 'liked') {
          likeIcon.classList.remove('ri-heart-3-line');
          likeIcon.classList.add('ri-heart-3-fill');
        } else if (data.status === 'unliked') {
          likeIcon.classList.remove('ri-heart-3-fill');
          likeIcon.classList.add('ri-heart-3-line');
        }
        const likeCountEl = document.getElementById(`like-count-${data.project_id}`);

        if (likeCountEl && typeof data.like_count !== 'undefined') {
          likeCountEl.innerText = `${data.like_count} Likes`;
        }
      }
    }

    if (data.type === 'comment') {
      const commentsEl = document.getElementById('modalComments');
      const commentCountEl = document.getElementById(`comment-count-${data.project_id}`);
      if (!commentsEl || !commentCountEl) {
        console.warn("⚠️ 'modalComments' element not found");
        return;
      }

      const newEl = `<div class="mb-2"><strong>${data.name}</strong>: ${data.comment}</div>`;
      commentsEl.insertAdjacentHTML('beforeend', newEl);

      commentCountEl.textContent = `${data.comment_count} Comments`;

      console.log("✅ Comment added to modal");
    } else {
      console.log("ℹ️ Message type not handled:", data.type);
    }
  };

  socket.onerror = (err) => {
    console.error("❌ WebSocket error", err);
  };

  const feed = document.getElementById('projectFeed');
  if (!feed) {
    console.error('⚠️ projectField element not found!');
    return;
  }

  fetch('../../../backend/api/get_project.php')
    .then(res => res.json())
    .then(data => {
      console.log(data);

      // If there are no posts
      if (data.posts.length === 0) {
        feed.innerHTML = `
          <div class="empty-state">
            <i class="bi bi-folder-x"></i>
            <h3>No Projects Yet</h3>
            <p>Be the first to share your project!</p>
            <button class="btn btn-primary" id="uploadProjectBtn">
              <i class="bi bi-upload me-2"></i>Upload Project
            </button>
          </div>
        `;
        return;
      }

      

      if (data.success) {
        data.posts.forEach(post => {
          const postEl = document.createElement('div');
          postEl.classList.add('post');

          const categoryKey = post.project_category.toLowerCase().trim();
          const categoryClass = categoryClassMap[categoryKey] || 'all';
          const initials = getInitials(post.student_name);

          // Carousel images
          const carouselId = `carousel-${post.id}`;
          const hasImages = post.images && post.images.length > 0;
          const carouselControls = hasImages && post.images.length > 1
            ? `
              <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
              </button>
              `
            : '';

          const carouselHTML = `
            <div id="${carouselId}" class="carousel slide">
                <div class="carousel-inner">
                    ${post.images.map((img, index) => `
                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                        <img src="../../../backend/${img}" class="d-block w-100" alt="Project Image ${index + 1}">
                    </div>`).join('')}
                </div>
            ${carouselControls}
            </div>`;


   postEl.innerHTML = `
  <div class="project-container" id="${post.id}-project">
      
      <!-- IMAGE CAROUSEL ON TOP -->
      <div class="project-media">
          ${carouselHTML}
      </div>

      <!-- CONTENT -->
      <div class="project-content">
          
          <!-- TITLE + DESCRIPTION -->
          <h3 class="project-title mt-3">${post.project_title}</h3>
          <p class="project-description mb-3">${post.project_description}</p>

          <!-- TECHNOLOGIES -->
          <div class="project-tech mb-3">
              ${post.technologies.map(tech => `<span class="tech-tag">${tech}</span>`).join('')}
          </div>

          <!-- AUTHOR + DATE -->
          <div class="project-header mb-3">
              ${post.profile_photo 
                ? `<img src="../../../backend/${post.profile_photo}" class="project-avatar" alt="User Avatar">` 
                : `<div class="project-avatar">${initials}</div>`}
              
              <div class="project-author">
                  <p class="project-username">${post.student_name}</p>
                  <p class="project-date">${post.created_at}</p>
              </div>
              <span class="project-badge ${categoryClass}-badge">${post.project_category}</span>
          </div>
      <!-- FOOTER: STATS + LINKS -->
<div class="project-footer d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-3">

    <!-- LEFT: Likes + Comments -->
    <div class="project-stats d-flex gap-3">
        <button class="post-action like-btn" data-id="${post.id}">
            <i class="${post.liked_by_user ? 'ri-heart-3-fill' : 'ri-heart-3-line'} like-icon" id="like-icon-${post.id}"></i>
            <span class="like-count" id="like-count-${post.id}">${post.like_count} Likes</span>
        </button>
        <button class="post-action comment-btn" data-id="${post.id}" data-post='${JSON.stringify(post).replace(/'/g, "&apos;")}' >
            <i class="ri-chat-3-line"></i>
            <span class="comment-count" id="comment-count-${post.id}">${post.comment_count} Comments</span>
        </button>
    </div>

    <!-- RIGHT: Project Links -->
    <div class="project-links d-flex flex-row flex-nowrap justify-content-center gap-3 w-100 w-md-auto">
        ${post.download_link ? `<a href="${post.download_link}" class="project-link"><i class="ri-download-2-line"></i> Executable</a>` : ''}
        ${post.live_link ? `<a href="${post.live_link}" class="project-link"><i class="ri-global-line"></i> Live</a>` : ''}
        ${post.github_link ? `<a href="${post.github_link}" class="project-link"><i class="ri-github-fill"></i> GitHub</a>` : ''}
    </div>
</div>

`;



          feed.appendChild(postEl);
          const insertedCarousel = document.getElementById(carouselId);
          if (insertedCarousel) {
            new bootstrap.Carousel(insertedCarousel, {
              interval: false,
              ride: false,
              wrap: true
            });
          }
        });

        const categoryItems = document.querySelectorAll('.category-item');
        const projectContainers = document.querySelectorAll('.project-container');

        categoryItems.forEach(item => {
          item.addEventListener('click', function (e) {
            e.preventDefault();

            const categoryId = this.id.replace('category-', '');

            // Remove active class from all category items
            categoryItems.forEach(ci => ci.classList.remove('active'));

            // Add active class to clicked category
            this.classList.add('active');

            // Show/hide projects based on category
            projectContainers.forEach(project => {
              const badgeEl = project.querySelector('.project-badge');
              if (!badgeEl) {
                console.warn("⚠️ project-badge not found for project:", project);
                return;
              }

              const projectBadge = badgeEl.textContent.trim();

              if (categoryId === 'all') {
                project.style.display = 'block';
              } else {
                const categoryMap = {
                  'games': 'Games',
                  'websites': 'Websites',
                  'mobile': 'Mobile Apps',
                  'console': 'Console Apps',
                  'ai': 'AI/ML',
                  'databases': 'Databases',
                  'others': 'Others'
                };

                if (categoryMap[categoryId].toLowerCase() === projectBadge.toLowerCase()) {
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
      }
    });

  const projectImageViewer = new bootstrap.Modal(document.getElementById('projectImageViewer'));

  // Get all project images
  const projectImages = document.querySelectorAll('.project-image');

  projectImages.forEach((image, index) => {
    // Assign unique ID to each image if not already present
    if (!image.id) {
      image.id = `project-image-${index}`;
    }

    image.addEventListener('click', function () {
      // Get the image source and alt text
      const imgSrc = this.src;
      const imgAlt = this.alt || 'Project Image';

      // Set the modal content
      document.getElementById('projectImageView').src = imgSrc;

      // Show the modal
      projectImageViewer.show();
    });
  });

  feed.addEventListener("click", async (e) => {
    const commentBtn = e.target.closest('.comment-btn');
    const postComment = e.target.closest('.add-comment');
    const likeBtn = e.target.closest('.like-btn');

    // Handle the appearance of the comment modal
    if (commentBtn) {
      const postData = JSON.parse(commentBtn.dataset.post.replace(/&apos;/g, "'"));

      const commentModal = new bootstrap.Modal(document.getElementById('commentModal'));
      const modalPostEl = document.getElementById('modalPostContent');
      const commentsEl = document.getElementById('modalComments');
      const modalHeader = document.getElementById('modalProjectHeader');
      const projectId = commentBtn.dataset.id;

      document.querySelector('#commentModal .comment-input').dataset.id = projectId;
      document.querySelector('#commentModal .add-comment').dataset.id = projectId;

      // Render post details
      modalPostEl.innerHTML = `
        <div class="modal-project">
            <h5>${postData.project_title}</h5>
            <p class="text-muted" style="font-size: 13px;">${postData.student_name} · ${postData.created_at}</p>
            <p>${postData.project_description}</p>
            ${postData.technologies.map(tech => `<span class="badge bg-secondary me-1">${tech}</span>`).join('')}
        </div>
        <hr>
      `;

      modalHeader.innerHTML = `${postData.student_name}'s Project`;

      commentsEl.innerHTML = `<div class="text-muted">Loading comments...</div>`;

      try {
        const response = await fetch(`../../../backend/api/get_comments.php?project_id=${projectId}`);
        const data = await response.json();
        console.log(data);

        if (!data || data.length === 0) {
          commentsEl.innerHTML = `<div class="text-muted">No comments yet.</div>`;
        } else {
          commentsEl.innerHTML = data.map(c =>
            `<div class="mb-2"><strong>${c.name}</strong>: ${c.comment}</div>`
          ).join('');
        }

        commentModal.show();
      } catch (err) {
        commentsEl.innerHTML = `<div class="text-danger">Failed to load comments.</div>`;
      }
    }

    if (postComment) {
      const parentDiv = postComment.closest('.parent-comment-div');
      const inputEl = parentDiv.querySelector('.comment-input');
      const comment = inputEl.value;
      const projectId = postComment.dataset.id;

      if (comment.trim() !== '') {
        const res = await fetch("../../../backend/api/add_comment.php", {
          method: 'POST',
          headers: { "Content-type": "application/json" },
          credentials: 'include',
          body: JSON.stringify({ project_id: projectId, comment: comment })
        });

        const data = await res.json();

        if (data.success && data.comment) {
          inputEl.value = '';
          const submitBtn = parentDiv.querySelector('.add-comment');
          submitBtn.disabled = true;
          setTimeout(() => submitBtn.disabled = false, 500);
        }
      }
    }

    if (likeBtn) {
      const projectId = likeBtn.dataset.id;
      const res = await fetch(`../../../backend/api/like_project.php`, {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ project_id: projectId })
      });
    }
  });
});


