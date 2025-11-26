console.log("SCRIPT IS LOADED ✅");

// -------------------- FORM HANDLING --------------------
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

// ----- TECH TAGS -----
techInput.addEventListener("keydown", (e) => {
  if (e.key === " " || e.key === "Enter") {
    e.preventDefault();
    const value = techInput.value.trim();

    if (value !== "" && !tags.includes(value)) {
      tags.push(value);
      console.log("Current tags:", tags);

      const tag = document.createElement("span");
      tag.className = "badge bg-secondary px-2 py-1 rounded-pill d-flex align-items-center";
      tag.innerText = value;

      const closeBtn = document.createElement("button");
      closeBtn.className = "btn-close btn-close-white btn-sm ms-2";
      closeBtn.type = "button";
      closeBtn.innerHTML = "&times;";
      closeBtn.onclick = () => {
        tags.splice(tags.indexOf(value), 1);
        console.log("Updated tags:", tags);
        tag.remove();
      };

      tag.appendChild(closeBtn);
      tagWrapper.appendChild(tag);
      techInput.value = "";
    }
  }
});

// ----- MEMBERS -----
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
        members.splice(members.indexOf(value), 1);
        console.log("Updated members:", members);
        tag.remove();
      };

      tag.appendChild(closeBtn);
      tagMemberWrapper.appendChild(tag);
      projMemberInput.value = "";
    }
  }
});

// ----- MEDIA UPLOAD -----
uploadArea.addEventListener("click", () => uploadInput.click());

uploadInput.addEventListener("change", () => {
  const newFiles = Array.from(uploadInput.files);
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
        selectedFiles.splice(index, 1);
        renderPreview();
      });

      wrapper.appendChild(img);
      wrapper.appendChild(removeBtn);
      mediaPreview.appendChild(wrapper);

      filesProcessed++;
      if (filesProcessed === selectedFiles.length) {
        mediaCounter.innerText = `${selectedFiles.length}/8 images selected`;
      }
    };
    reader.readAsDataURL(file);
  });

  if (selectedFiles.length === 0) mediaCounter.innerText = "0/8 images selected";
}

// ----- FORM ERROR HANDLING -----
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

// ----- RESET FORM -----
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

// ----- FORM SUBMISSION -----
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

    tags.forEach(tag => formData.append('tags[]', tag));
    members.forEach(member => formData.append('members[]', member));
    selectedFiles.forEach(file => formData.append('selectedFiles[]', file));

    document.getElementById("uploadOverlay").classList.remove("d-none");
    document.getElementById("uploadLoader").classList.remove("d-none");
    document.getElementById("uploadSuccess").classList.add("d-none");
    clearFieldErrors();
    document.getElementById("generalUploadError").classList.add("d-none");

    fetch("../../../backend/api/student_upload_proj.php", { method: "POST", body: formData })
      .then(res => res.json())
      .then(response => {
        if (response.success) {
          document.getElementById("uploadLoader").classList.add("d-none");
          document.getElementById("uploadSuccess").classList.remove("d-none");

          setTimeout(() => {
            const modal = bootstrap.Modal.getInstance(document.getElementById("projectUploadModal"));
            modal.hide();
            document.getElementById("uploadOverlay").classList.add("d-none");
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

// -------------------- DOM CONTENT LOADED --------------------
document.addEventListener('DOMContentLoaded', () => {

  const socket = new WebSocket("ws://localhost:8080");
  const feed = document.getElementById('projectFeed');

  if (!feed) {
    console.error('⚠️ projectFeed element not found!');
    return;
  }

  const categoryClassMap = {
    'ai/ml': 'ai',
    'console apps': 'console',
    'databases': 'databases',
    'desktop apps': 'desktop',
    'games': 'game',
    'mobile apps': 'mobile',
    'ui/ux design': 'uiux',
    'web development': 'web'
  };

  function getInitials(name) {
    const parts = name.trim().split(" ").filter(Boolean);
    return parts.length === 1
      ? parts[0][0].toUpperCase()
      : (parts[0][0] + parts[1][0]).toUpperCase();
  }

 // -------------------- WEBSOCKET --------------------
  socket.onmessage = (event) => {
    let data;
    try { data = JSON.parse(event.data); } 
    catch(e){ console.error("Failed to parse WS message", e); return; }

    // Helper function (moved into scope for use by 'comment' type)
    function getInitials(name) {
        const parts = name.trim().split(" ").filter(Boolean);
        if (parts.length === 0) return '';
        if (parts.length === 1) return parts[0][0].toUpperCase();
        return (parts[0][0] + parts[1][0]).toUpperCase();
    }

    if (data.type === 'like') {
      const likeIcon = document.getElementById(`like-icon-${data.project_id}`);
      if (likeIcon) {
        if (data.status === 'liked') { likeIcon.classList.replace('ri-heart-3-line','ri-heart-3-fill'); }
        else if (data.status === 'unliked') { likeIcon.classList.replace('ri-heart-3-fill','ri-heart-3-line'); }
      }
      const likeCountEl = document.getElementById(`like-count-${data.project_id}`);
      if (likeCountEl && typeof data.like_count !== 'undefined') likeCountEl.innerText = `${data.like_count}`;
    }

    if (data.type === 'comment') {
      const commentsEl = document.getElementById('modalComments');
      const commentCountEl = document.getElementById(`comment-count-${data.project_id}`);
      
      if (!commentsEl || !commentCountEl) return;
      
        // 🌟 FIX: Generate the avatar HTML just like the initial loading block
        const commentInitials = getInitials(data.name);
        const commentAvatar = data.profile_photo 
            ? `<img src="../../../backend/${data.profile_photo}" class="comment-avatar me-2" alt="Commenter Avatar">`
            : `<div class="comment-avatar me-2">${commentInitials}</div>`;
        
        // Use the same formatted HTML structure as when initially loading comments
        const newEl = `
            <div class="d-flex align-items-start mb-3">
                ${commentAvatar}
                <div>
                    <strong>${data.name}</strong> <span class="text-muted small">Just now</span>
                    <p class="mb-0">${data.comment}</p>
                </div>
            </div>`;

      commentsEl.insertAdjacentHTML('beforeend', newEl);
      commentCountEl.textContent = `${data.comment_count} Comments`;
    }
  };

  socket.onerror = (err) => console.error("WS error", err);

  // -------------------- FETCH PROJECTS --------------------
  fetch('../../../backend/api/get_project.php')
    .then(res => res.json())
    .then(data => {
      if (!data.success || !data.posts || data.posts.length === 0) {
        feed.innerHTML = `<div class="empty-state"><h3>No Projects Yet</h3><p>Be the first to share your project!</p></div>`;
        return;
      }
      const noResultsMessage = document.getElementById('noResultsMessage');
      if (noResultsMessage) noResultsMessage.classList.add('d-none'); 

      data.posts.forEach(post => {
        const postEl = document.createElement('div');
        postEl.classList.add('project-container');

        const categoryKey = post.project_category.toLowerCase().trim();
        const categoryClass = categoryClassMap[categoryKey] || 'all';
        const initials = getInitials(post.student_name);
        const studentProfileUrl = `view-profile-func.php?id=${post.student_id}`;
        const postDate = formatPostDate(post.created_at);
        const carouselId = `carousel-${post.id}`;
        const hasImages = post.images && post.images.length > 0;
        const carouselControls = hasImages && post.images.length > 1
          ? `<button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
             <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>`
          : '';
        const carouselHTML = `<div id="${carouselId}" class="carousel slide"><div class="carousel-inner">${post.images.map((img,index)=>`<div class="carousel-item ${index===0?'active':''}"><img src="../../../backend/${img}" class="d-block w-100" alt="Project Image ${index+1}"></div>`).join('')}</div>${carouselControls}</div>`;
 // ------------------ DESCRIPTION TRUNCATE ------------------
      const maxLength = 150; // characters to show on card
      let shortDesc = post.project_description;
      let isTruncated = false;
      if (shortDesc.length > maxLength) {
        shortDesc = shortDesc.substring(0, maxLength) + '... ';
        isTruncated = true;
      }

        postEl.innerHTML = `
        <div class="project-media position-relative">
          ${carouselHTML}
          <span class="project-badge ${categoryClass}-badge position-absolute top-0 end-0 m-2">${post.project_category}</span>
        </div>
        <div class="project-content">
          <h3 class="project-title mt-3">${post.project_title}</h3>
           <p class="project-description mb-3">
            ${shortDesc}
            ${isTruncated ? `<a href="#" class="read-more-link" data-id="${post.id}" data-post='${JSON.stringify(post).replace(/'/g,"&apos;")}'>Read more</a>` : ''}
          </p>
          <div class="project-tech mb-3">${post.technologies.map(t=>`<span class="tech-tag">${t}</span>`).join('')}</div>
          <div class="project-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3">
            <div class="d-flex align-items-center gap-3 mb-2 mb-sm-0">
              ${post.profile_photo ? `<a href="${studentProfileUrl}"><img src="../../../backend/${post.profile_photo}" class="project-avatar" alt="User Avatar"></a>` : `<a href="${studentProfileUrl}"><div class="project-avatar">${initials}</div></a>`}
              <div><p class="project-username mb-0">${post.student_name}</p><p class="project-date mb-0">${postDate}</p></div>
            </div>
            <div class="d-flex gap-2 flex-wrap post-actions">
              <button class="btn btn-light rounded-pill shadow-sm d-flex align-items-center gap-2 like-btn px-3" data-id="${post.id}">
                <i class="${post.liked_by_user ? 'ri-heart-3-fill text-comsa-highlight' : 'ri-heart-3-line'} fs-6 like-icon" id="like-icon-${post.id}"></i>
                <span id="like-count-${post.id}" class="fw-semibold">${post.like_count}</span>
              </button>
              <button class="btn btn-light rounded-pill shadow-sm d-flex align-items-center gap-2 comment-btn px-3" data-id="${post.id}" data-post='${JSON.stringify(post).replace(/'/g,"&apos;")}'>
                <i class="ri-chat-3-line fs-6"></i>
                <span id="comment-count-${post.id}" class="fw-semibold">${post.comment_count}</span>
              </button>
            </div>
          </div>
          <div class="project-links d-flex flex-row flex-wrap justify-content-center gap-2">
            ${post.download_link ? `<a href="${post.download_link}" class="btn btn-outline-secondary btn-comsa-gradient rounded-pill px-3 d-flex align-items-center gap-2"><i class="ri-download-2-line fs-5"></i> Download</a>` : ''}
            ${post.live_link ? `<a href="${post.live_link}" class="btn btn-outline-secondary btn-comsa-gradient rounded-pill px-3 d-flex align-items-center gap-2"><i class="ri-global-line fs-5"></i> Live Demo</a>` : ''}
            ${post.github_link ? `<a href="${post.github_link}" class="btn btn-outline-secondary btn-comsa-gradient rounded-pill px-3 d-flex align-items-center gap-2"><i class="ri-github-fill fs-5"></i> GitHub</a>` : ''}
          </div>
        </div>`;

        feed.appendChild(postEl);
        if (hasImages) new bootstrap.Carousel(document.getElementById(carouselId), {interval:false,ride:false,wrap:true});
      });

      // ---------------- GLOBAL EVENT LISTENER FOR LIKE + COMMENT ----------------
feed.addEventListener("click", async (e) => {
  const commentBtn = e.target.closest('.comment-btn');
  const postComment = e.target.closest('.add-comment');
  const likeBtn = e.target.closest('.like-btn');
  const readMore = e.target.closest('.read-more-link'); 

 // ---------------- READ MORE / COMMENT MODAL ----------------
  if (readMore || commentBtn) {
    if (readMore) e.preventDefault(); // prevent # jump

    const postData = readMore 
      ? JSON.parse(readMore.dataset.post.replace(/&apos;/g, "'"))
      : JSON.parse(commentBtn.dataset.post.replace(/&apos;/g, "'"));
    const projectId = readMore ? readMore.dataset.id : commentBtn.dataset.id;
    
    // Helper values for the HTML generation
    const postDate = formatPostDate(postData.created_at);
    const initials = getInitials(postData.student_name);
    const studentProfileUrl = `view-profile-func.php?id=${postData.student_id}`;
    const modalCarouselId = `modal-carousel-${projectId}`; // Unique ID for modal carousel
    const hasImages = postData.images && postData.images.length > 0;

    // Carousel HTML Generation
    const carouselControls = hasImages && postData.images.length > 1
        ? `<button class="carousel-control-prev" type="button" data-bs-target="#${modalCarouselId}" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
           <button class="carousel-control-next" type="button" data-bs-target="#${modalCarouselId}" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>`
        : '';
    
    const carouselHTML = `<div id="${modalCarouselId}" class="carousel slide">
                            <div class="carousel-inner">
                            ${postData.images.map((img,index)=>`<div class="carousel-item ${index===0?'active':''}"><img src="../../../backend/${img}" class="d-block w-100" alt="Project Image ${index+1}"></div>`).join('')}
                            </div>
                            ${carouselControls}
                          </div>`;

    const commentModal = new bootstrap.Modal(document.getElementById('commentModal'));
    const modalPostEl = document.getElementById('modalPostContent');
    const commentsEl = document.getElementById('modalComments');
    const modalHeader = document.getElementById('modalProjectHeader');

    document.querySelector('#commentModal .comment-input').dataset.id = projectId;
    document.querySelector('#commentModal .add-comment').dataset.id = projectId;

    // Set the Modal Title
    modalHeader.innerHTML = postData.project_title;
    
    // Build the full post content for the modal
    modalPostEl.innerHTML = `
        <div class="modal-project-content">
            <div class="project-media">
                ${carouselHTML}
                <span class="project-badge ${categoryClassMap[postData.project_category.toLowerCase().trim()] || 'all'}-badge position-absolute top-0 end-0 m-4">${postData.project_category}</span>
            </div>

            <div class="d-flex align-items-center gap-3 mb-3">
              
            </div>

            <p class="project-description mb-3">${postData.project_description}</p>

            <div class="project-tech mb-3">
                ${postData.technologies.map(t => `<span class="badge me-1 tech-tag">${t}</span>`).join('')}
            </div>
          <div class="project-links d-flex flex-row flex-wrap justify-content-center gap-2">${postData.download_link ? `<a href="${postData.download_link}" class="btn btn-outline-secondary btn-comsa-gradient rounded-pill px-3 d-flex align-items-center gap-2"><i class="ri-download-2-line fs-5"></i> Download</a>` : ''}${postData.live_link ? `<a href="${postData.live_link}" class="btn btn-outline-secondary btn-comsa-gradient rounded-pill px-3 d-flex align-items-center gap-2"><i class="ri-global-line fs-5"></i> Live Demo</a>` : ''}${postData.github_link ? `<a href="${postData.github_link}" class="btn btn-outline-secondary btn-comsa-gradient rounded-pill px-3 d-flex align-items-center gap-2"><i class="ri-github-fill fs-5"></i> GitHub</a>` : ''}</div>
            </div><h5 class="mt-2">Comments</h5>`;

    // Initialize the carousel for the modal
    if (hasImages) {
        new bootstrap.Carousel(document.getElementById(modalCarouselId), {
            interval: false, 
            ride: false,
            wrap: true
        });
    }


    commentsEl.innerHTML = `<div class="text-muted">Loading comments...</div>`;

    try {
      const response = await fetch(`../../../backend/api/get_comments.php?project_id=${projectId}`);
      const data = await response.json();
      // Enhanced comment rendering to include profile picture/initials
      commentsEl.innerHTML = data.length
        ? data.map(c => {
            const commentInitials = getInitials(c.name);
            const commentAvatar = c.profile_photo 
                ? `<img src="../../../backend/${c.profile_photo}" class="comment-avatar me-2" alt="Commenter Avatar">`
                : `<div class="comment-avatar me-2">${commentInitials}</div>`;

            return `<div class="d-flex align-items-start mb-3">
                        ${commentAvatar}
                        <div>
                            <strong>${c.name}</strong> <span class="text-muted small">${formatPostDate(c.created_at)}</span>
                            <p class="mb-0">${c.comment}</p>
                        </div>
                    </div>`;
        }).join('')
        : `<div class="text-muted">No comments yet.</div>`;
    } catch (err) {
      commentsEl.innerHTML = `<div class="text-danger">Failed to load comments.</div>`;
    }

    commentModal.show();
    return;
  }

  // ---------------- POST A COMMENT ----------------
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
        body: JSON.stringify({ project_id: projectId, comment })
      });

      const data = await res.json();
      if (data.success) {
        inputEl.value = '';
        postComment.disabled = true;
        setTimeout(() => postComment.disabled = false, 500);
      }
    }
    return;
  }

  // ---------------- LIKE BUTTON ----------------
  if (likeBtn) {
    const projectId = likeBtn.dataset.id;
    const icon = document.getElementById(`like-icon-${projectId}`);
    const countEl = document.getElementById(`like-count-${projectId}`);

    // Optimistic UI update
    const liked = icon.classList.contains('ri-heart-3-fill');

    if (liked) {
      icon.classList.remove('ri-heart-3-fill', 'text-comsa-highlight');
      icon.classList.add('ri-heart-3-line');
      countEl.textContent = Number(countEl.textContent) - 1;
    } else {
      icon.classList.remove('ri-heart-3-line');
      icon.classList.add('ri-heart-3-fill', 'text-comsa-highlight');
      countEl.textContent = Number(countEl.textContent) + 1;
    }

    // Backend update
    await fetch("../../../backend/api/like_project.php", {
      method: 'POST',
      headers: { "Content-type": "application/json" },
      credentials: 'include',
      body: JSON.stringify({ project_id: projectId })
    });

    return;
  }
});

      

      // -------------------- SEARCH + CATEGORY FILTER --------------------
 const searchInputs = document.querySelectorAll('.project-search-input');
const categoryItems = document.querySelectorAll('.category-item');
let activeCategory = 'all';

function filterProjects(query = null) {
  // If a query is provided, sync it to all inputs
  if (query !== null) {
    searchInputs.forEach(input => input.value = query);
  } else {
    // Otherwise, take value from the first input
    query = searchInputs[0].value.toLowerCase().trim();
  }

  const projects = document.querySelectorAll('.project-container');
  let visibleCount = 0;

  projects.forEach(project => {
    const title = project.querySelector('.project-title')?.innerText.toLowerCase() || '';
    const description = project.querySelector('.project-description')?.innerText.toLowerCase() || '';
    const techs = Array.from(project.querySelectorAll('.tech-tag')).map(t => t.innerText.toLowerCase()).join(' ');
    const student = project.querySelector('.project-username')?.innerText.toLowerCase() || '';
    const projectBadge = project.querySelector('.project-badge')?.innerText.toLowerCase() || '';

    const matchesSearch = title.includes(query) || description.includes(query) || techs.includes(query) || student.includes(query);
    const matchesCategory = (activeCategory === 'all') || (projectBadge === activeCategory);

    const isVisible = matchesSearch && matchesCategory;

    project.style.display = isVisible ? 'block' : 'none';
    if (isVisible) {
            visibleCount++;
        }
  });
  // noResultsMessage is now correctly in scope
    if (noResultsMessage) { 
        if (visibleCount === 0) {
            noResultsMessage.classList.remove('d-none');
        } else {
            noResultsMessage.classList.add('d-none');
        }
    }
}


// Attach event listener to all search inputs
searchInputs.forEach(input => {
  input.addEventListener('input', () => filterProjects(input.value.toLowerCase().trim()));
});

// Category clicks
categoryItems.forEach(item => {
  item.addEventListener('click', function (e) {
    e.preventDefault();

    categoryItems.forEach(ci => ci.classList.remove('active'));
    this.classList.add('active');

    const categoryMap = {
      'all': 'all',
      'aiml': 'ai/ml',
      'console': 'console apps',
      'databases': 'databases',
      'desktop': 'desktop apps',
      'games': 'games',
      'mobile': 'mobile apps',
      'uiux': 'ui/ux design',
      'web': 'web development'
    };

    activeCategory = categoryMap[this.id.replace('category-', '').toLowerCase()] || 'all';

    // Re-filter projects whenever category changes
    filterProjects();
  });
});

// Activate "All" by default
const allCategory = document.getElementById('category-all');
if (allCategory) allCategory.classList.add('active');

    })
    .catch(err => console.error("Failed to fetch projects:", err));

  function formatPostDate(datetimeStr) {
    const date = new Date(datetimeStr);
    return date.toLocaleDateString(undefined, {year:'numeric',month:'short',day:'numeric'});
  }

});



