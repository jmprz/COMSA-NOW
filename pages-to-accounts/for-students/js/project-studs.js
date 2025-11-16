console.log("SCRIPT IS LOADED ✅");

// =======================
// PROJECT UPLOAD HANDLING
// =======================
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

// =======================
// TAG HANDLING
// =======================
techInput.addEventListener("keydown", (e) => {
  if (e.key === " " || e.key === "Enter") {
    e.preventDefault();
    const value = techInput.value.trim();
    if (value !== "" && !tags.includes(value)) {
      tags.push(value);
      const tag = document.createElement("span");
      tag.className = "badge bg-secondary px-2 py-1 rounded-pill d-flex align-items-center";
      tag.innerText = value;

      const closeBtn = document.createElement("button");
      closeBtn.className = "btn-close btn-close-white btn-sm ms-2";
      closeBtn.type = "button";
      closeBtn.innerHTML = "&times;";
      closeBtn.onclick = () => {
        tags.splice(tags.indexOf(value), 1);
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
      const tag = document.createElement("span");
      tag.className = "badge bg-secondary px-2 py-1 rounded-pill d-flex align-items-center";
      tag.innerText = value;

      const closeBtn = document.createElement("button");
      closeBtn.className = "btn-close btn-close-white btn-sm ms-2";
      closeBtn.type = "button";
      closeBtn.innerHTML = "&times;";
      closeBtn.onclick = () => {
        members.splice(members.indexOf(value), 1);
        tag.remove();
      };

      tag.appendChild(closeBtn);
      tagMemberWrapper.appendChild(tag);
      projMemberInput.value = "";
    }
  }
});

// =======================
// MEDIA UPLOAD PREVIEW
// =======================
uploadArea.addEventListener("click", () => uploadInput.click());

uploadInput.addEventListener("change", () => {
  const newFiles = Array.from(uploadInput.files);
  const availableSlots = 8 - selectedFiles.length;
  selectedFiles = [...selectedFiles, ...newFiles.slice(0, availableSlots)];
  renderPreview();
  uploadInput.value = "";
});

function renderPreview() {
  mediaPreview.innerHTML = "";
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
      Object.assign(removeBtn.style, {
        position: "absolute",
        top: "0",
        right: "0",
        background: "rgba(0,0,0,0.5)",
        color: "white",
        border: "none",
        borderRadius: "50%",
        cursor: "pointer",
        width: "20px",
        height: "20px",
        fontSize: "12px",
      });
      removeBtn.title = "Remove";
      removeBtn.onclick = () => {
        selectedFiles.splice(index, 1);
        renderPreview();
      };

      wrapper.appendChild(img);
      wrapper.appendChild(removeBtn);
      mediaPreview.appendChild(wrapper);
      mediaCounter.innerText = `${selectedFiles.length}/8 images selected`;
    };
    reader.readAsDataURL(file);
  });
  if (selectedFiles.length === 0) mediaCounter.innerText = "0/8 images selected";
}

// =======================
// FORM RESET
// =======================
closeUpload.forEach((btn) =>
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
  })
);

// =======================
// FORM SUBMIT
// =======================
uploadForm.addEventListener("submit", function (e) {
  e.preventDefault();
  e.stopPropagation();
  if (!this.checkValidity()) return;

  const formData = new FormData(uploadForm);
  tags.forEach(tag => formData.append('tags[]', tag));
  members.forEach(member => formData.append('members[]', member));
  selectedFiles.forEach(file => formData.append('selectedFiles[]', file));

  document.getElementById("uploadOverlay").classList.remove("d-none");
  document.getElementById("uploadLoader").classList.remove("d-none");
  document.getElementById("uploadSuccess").classList.add("d-none");
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
          tags = [];
          members = [];
          selectedFiles = [];
          tagWrapper.innerHTML = "";
          tagMemberWrapper.innerHTML = "";
          mediaPreview.innerHTML = "";
          mediaCounter.innerText = "0/8 images selected";
          window.location.reload();
        }, 1500);
      } else {
        document.getElementById("uploadOverlay").classList.add("d-none");
        console.error(response.errors);
      }
    })
    .catch(err => {
      console.error("Upload failed:", err);
      document.getElementById("uploadOverlay").classList.add("d-none");
    });
});

// =======================
// PROJECT FEED + SEARCH + CATEGORY FILTER
// =======================
document.addEventListener('DOMContentLoaded', () => {
  const feed = document.getElementById('projectFeed');
  const searchInput = document.getElementById('projectSearch');
  const categoryItems = document.querySelectorAll('.category-item');

  let selectedCategory = 'all';

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
    return parts.length === 1 ? parts[0][0].toUpperCase() : (parts[0][0] + parts[1][0]).toUpperCase();
  }

  function formatPostDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
  }

  fetch('../../../backend/api/get_project.php')
    .then(res => res.json())
    .then(data => {
      if (!data.success || !data.posts.length) {
        feed.innerHTML = `<div class="empty-state text-center py-5"><h3>No Projects Yet</h3><p>Be the first to share your project!</p></div>`;
        return;
      }

    data.posts.forEach(post => {
  const postEl = document.createElement('div');
  postEl.classList.add('project-container');
  postEl.dataset.category = post.project_category.toLowerCase();
  const categoryClass = categoryClassMap[post.project_category.toLowerCase()] || 'all';
  const initials = getInitials(post.student_name);
  const postDate = formatPostDate(post.created_at);
  const studentProfileUrl = `view-profile-func.php?id=${post.student_id}`; // Adjust as needed
  const carouselId = `carousel-${post.id}`;
  const hasImages = post.images && post.images.length > 0;
  const carouselControls = hasImages && post.images.length > 1 ? `
    <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Next</span>
    </button>` : '';

  const carouselHTML = `<div id="${carouselId}" class="carousel slide"><div class="carousel-inner">
    ${post.images.map((img, index) => `<div class="carousel-item ${index === 0 ? 'active' : ''}">
      <img src="../../../backend/${img}" class="d-block w-100" alt="Project Image">
    </div>`).join('')}
  </div>${carouselControls}</div>`;

  postEl.innerHTML = `
    <div class="project-media position-relative">
      ${carouselHTML}
      <span class="project-badge ${categoryClass}-badge position-absolute top-0 end-0 m-2">${post.project_category}</span>
    </div>

    <div class="project-content">
      <h3 class="project-title mt-3">${post.project_title}</h3>
      <p class="project-description mb-3">${post.project_description}</p>

      <div class="project-tech mb-3">
        ${post.technologies.map(t => `<span class="tech-tag">${t}</span>`).join('')}
      </div>

      <div class="project-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3">
        <div class="d-flex align-items-center gap-3 mb-2 mb-sm-0">
          ${post.profile_photo 
              ? `<a href="${studentProfileUrl}"><img src="../../../backend/${post.profile_photo}" class="project-avatar"></a>` 
              : `<a href="${studentProfileUrl}"><div class="project-avatar">${initials}</div></a>`}
          <div>
            <p class="project-username mb-0">${post.student_name}</p>
            <p class="project-date mb-0">${postDate}</p>
          </div>
        </div>

        <div class="d-flex gap-2 flex-wrap d-none d-sm-flex">
          <button class="btn btn-light rounded-pill shadow-sm d-flex align-items-center gap-2 like-btn px-3" data-id="${post.id}">
            <i class="${post.liked_by_user ? 'ri-heart-3-fill text-comsa-highlight' : 'ri-heart-3-line'} fs-6 like-icon" id="like-icon-${post.id}"></i>
            <span id="like-count-${post.id}" class="fw-semibold">${post.like_count}</span>
          </button>

          <button class="btn btn-light rounded-pill shadow-sm d-flex align-items-center gap-2 comment-btn px-3"
                  data-id="${post.id}"
                  data-post='${JSON.stringify(post).replace(/'/g, "&apos;")}'>
            <i class="ri-chat-3-line fs-6"></i>
            <span id="comment-count-${post.id}" class="fw-semibold">${post.comment_count}</span>
          </button>
        </div>
      </div>

      <!-- Mobile Likes + Comments -->
      <div class="d-flex gap-2 justify-content-center flex-wrap my-3 d-flex d-sm-none">
        <button class="btn btn-light rounded-pill shadow-sm d-flex align-items-center gap-2 like-btn px-3" data-id="${post.id}">
          <i class="${post.liked_by_user ? 'ri-heart-3-fill text-comsa-highlight' : 'ri-heart-3-line'} fs-6 like-icon" id="like-icon-mobile-${post.id}"></i>
          <span id="like-count-mobile-${post.id}" class="fw-semibold">${post.like_count}</span>
        </button>

        <button class="btn btn-light rounded-pill shadow-sm d-flex align-items-center gap-2 comment-btn px-3"
                data-id="${post.id}"
                data-post='${JSON.stringify(post).replace(/'/g, "&apos;")}'>
          <i class="ri-chat-3-line fs-6"></i>
          <span id="comment-count-mobile-${post.id}" class="fw-semibold">${post.comment_count}</span>
        </button>
      </div>

      <!-- Project Links -->
      <div class="project-links d-flex flex-row flex-wrap justify-content-center gap-2">
        ${post.download_link ? `<a href="${post.download_link}" class="btn btn-outline-secondary btn-comsa-gradient rounded-pill px-3 d-flex align-items-center gap-2">
          <i class="ri-download-2-line fs-5"></i> Download
        </a>` : ''}
        ${post.live_link ? `<a href="${post.live_link}" class="btn btn-outline-secondary btn-comsa-gradient rounded-pill px-3 d-flex align-items-center gap-2">
          <i class="ri-global-line fs-5"></i> Live Demo
        </a>` : ''}
        ${post.github_link ? `<a href="${post.github_link}" class="btn btn-outline-secondary btn-comsa-gradient rounded-pill px-3 d-flex align-items-center gap-2">
          <i class="ri-github-fill fs-5"></i> GitHub
        </a>` : ''}
      </div>
    </div>
  `;

  feed.appendChild(postEl);

  // Initialize carousel
  const insertedCarousel = document.getElementById(carouselId);
  if (insertedCarousel) new bootstrap.Carousel(insertedCarousel, { interval: false, ride: false, wrap: true });
});


function filterProjects() {
  const query = document.querySelector('#projectSearch').value.toLowerCase().trim();
  const projects = document.querySelectorAll('.project-container');

  projects.forEach(project => {
    const title = project.querySelector('.project-title')?.innerText.toLowerCase() || '';
    const description = project.querySelector('.project-description')?.innerText.toLowerCase() || '';
    const techs = Array.from(project.querySelectorAll('.tech-tag')).map(t => t.innerText.toLowerCase()).join(' ');
    const student = project.querySelector('.project-username')?.innerText.toLowerCase() || '';
    const type = project.dataset.category?.toLowerCase() || 'all';

    const matchesSearch = title.includes(query) || description.includes(query) || techs.includes(query) || student.includes(query);
    const matchesCategory = (activeCategory === 'all') || (type === activeCategory);

    project.style.display = (matchesSearch && matchesCategory) ? 'block' : 'none';
  });
}

// Search input listener
document.querySelectorAll('#projectSearch').forEach(input => {
  input.addEventListener('input', filterProjects);
});

// Category click listener
document.querySelectorAll('.category-item').forEach(item => {
  item.addEventListener('click', e => {
    e.preventDefault();

    // remove active class
    document.querySelectorAll('.category-item').forEach(btn => btn.classList.remove('active'));

    // set active class
    item.classList.add('active');

    // set active category
    activeCategory = item.dataset.category;
    filterProjects();
  });
});


      // Activate all by default
      const allCategory = document.getElementById('category-all');
      if (allCategory) allCategory.classList.add('active');
    });
});
