document.addEventListener("DOMContentLoaded", function (e) {

  const editForm = document.getElementById("editProjectForm");

  let allProjects = [];

  let newImages = [];
  let currentImages = [];

  const categoryClassMap = {
    'websites': 'web',
    'mobile apps': 'mobile',
    'games': 'game',
    'ai/ml': 'ai',
    'console apps': 'console',
    'databases': 'databases',
    'others': 'others'
  };

  function renderProjectsTable(projects, tableId) {
    const table = document.getElementById(tableId);
    table.innerHTML = "";

    if (projects.length === 0) {
      table.innerHTML = `
            <div class="d-flex justify-content-center align-items-center flex-column" style="min-height:200px;">
                <i class="bi bi-emoji-frown fs-1 mb-2 text-muted"></i>
                <p class="text-muted">No Projects found.</p>
            </div>
        `;
      return;
    }

    projects.forEach(project => {
      const newEl = document.createElement("div");
      newEl.classList.add("project-container-admin");

      const categoryKey = project.project_category.toLowerCase().trim();
      const categoryClass = categoryClassMap[categoryKey] || 'all';

      // ✅ Unique carousel id per project
      const carouselId = `carousel-${project.id}`;
      const hasImages = project.images && project.images.length > 0;

      // ✅ Carousel controls (only if > 1 image)
      const carouselControls = hasImages && project.images.length > 1
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

      // ✅ Carousel HTML
      const carouselHTML = hasImages ? `
            <div id="${carouselId}" class="carousel slide">
                <div class="carousel-inner">
                    ${project.images.map((img, index) => `
                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                            <img src="../../../backend/${img}" class="d-block w-100 project-image-admin" alt="Project Image ${index + 1}">
                        </div>`).join('')}
                </div>
                ${carouselControls}
            </div>
        ` : `
            <img src="../../assets/img/events/project-game-example.png" class="project-image-admin" alt="Default Project Image">
        `;

      newEl.innerHTML = `
            <div class="project-header d-flex justify-content-between align-items-start">
              <div class="d-flex align-items-center">
                <img src="${project.profile_photo ? `../../../backend/${project.profile_photo}` : "../../assets/img/default-pic.jpg"}" 
                     class="rounded-circle me-2" width="40" height="40" alt="User Avatar">
                <div>
                  <h6 class="mb-0">${project.student_name || 'Unknown User'}</h6>
                  <small class="text-muted">${project.created_at}</small>
                </div>
              </div>
              <span class="project-badge ${categoryClass}-badge">${project.project_category || 'Uncategorized'}</span>
            </div>

            <div class="project-content mt-3">
              <h4 class="project-title">${project.project_title}</h4>
              <p class="project-description">${project.project_description}</p>

              <p class="project-members">
                <span style="font-weight: bold; font-size: 15px;">Team Members:</span>
                <span style="font-size: 14px;">
                  ${project.team_members.map(member => member).join(', ')}
                </span>
              </p>

              <div class="project-media mt-2">
                ${carouselHTML}
              </div>

              <div class="project-links mt-2">
                ${project.download_link ? `<a href="${project.download_link}" class="project-link"><i class="ri-download-line"></i> Executable</a>` : ''}
                ${project.github_link ? `<a href="${project.github_link}" class="project-link"><i class="ri-github-fill"></i> Source Code</a>` : ''}
                ${project.live_link ? `<a href="${project.live_link}" class="project-link"><i class="ri-globe-line"></i> Live</a>` : ''}
              </div>

              <div class="project-tech mt-2">
                ${(project.technologies || []).map(tech => `<span class="tech-tag">${tech}</span>`).join('')}
              </div>

              <div class="project-stats">
                    <div class="stat d-flex align-items-start">
                    <button class="post-action d-flex flex-column like-btn" data-id="${project.id}">
                        <i class="bi ${project.liked_by_user ? 'bi-star-fill' : 'bi-star'} like-icon" id="like-icon-${project.id}"></i>
                        <span class="like-count" style="font-size: 13px;" id="like-count-${project.id}">${project.like_count} Likes</span>
                    </button>
                    <button class="post-action d-flex flex-column comment-btn" data-id="${project.id}" data-post='${JSON.stringify(project).replace(/'/g, "&apos;")}'>
                        <i class="bi bi-chat-left"></i>
                        <span class="comment-count" style="font-size: 13px;" id="comment-count-${project.id}">${project.comment_count} Comments</span>
                    </button>
                    </div>
                </div>

              <div class="admin-actions d-flex justify-content-end gap-2">
                <button class="btn btn-sm btn-outline-primary viewProjectBtn" data-id="${project.id}" data-bs-toggle="modal" data-bs-target="#viewProjectModal">
                  <i class="ri-eye-line"></i> View
                </button>
                <button class="btn btn-sm btn-outline-secondary editProjectBtn"  data-id="${project.id}" data-bs-toggle="modal" data-bs-target="#editProjectModal">
                  <i class="ri-edit-line"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-danger deleteProjectBtn"  data-id="${project.id}">
                  <i class="ri-delete-bin-line"></i> Delete
                </button>
              </div>
            </div>
        `;

      table.appendChild(newEl);
      attachEventListener(newEl, project);
      // ✅ Activate carousel (if images exist)
      if (hasImages) {
        const insertedCarousel = document.getElementById(carouselId);
        new bootstrap.Carousel(insertedCarousel, {
          interval: false,
          ride: false,
          wrap: true
        });
      }



    });
  }

  function attachEventListener(element, project) {
    const viewPostBtn = element.querySelector(".viewProjectBtn");
    const editPostBtn = element.querySelector(".editProjectBtn");

    if (viewPostBtn) {
      viewPostBtn.addEventListener("click", function (e) {
        const imageContainer = document.querySelector(".imageContainer"); // modal image container
        const projectLinks = document.getElementById("projectLinks");
        const technologies = document.getElementById("technologies");

        // Clear old content
        technologies.innerHTML = "";
        projectLinks.innerHTML = "";
        imageContainer.innerHTML = "";

        // Set modal data
        document.getElementById("name").innerText = project.student_name;
        document.getElementById("datePosted").innerText = project.created_at;
        document.getElementById("category").innerText = project.project_category;
        document.getElementById("title").innerText = project.project_title;
        document.getElementById("description").innerText = project.project_description;
        document.getElementById("viewLikeCount").innerText = project.like_count;
        document.getElementById("viewCommentCount").innerText = project.comment_count;
        document.getElementById("userAvatar").src = project.profile_photo
          ? `../../../backend/${project.profile_photo}`
          : `../../assets/img/default-pic.jpg`;

        // Technologies
        (project.technologies || []).forEach(tag => {
          const newSpan = document.createElement("span");
          newSpan.classList.add("tech-tag");
          newSpan.innerText = tag;
          technologies.appendChild(newSpan);
        });

        // Links
        if (project.live_link) {
          projectLinks.innerHTML += `<a href="${project.live_link}" class="project-link"><i class="bi bi-globe"></i> Live</a>`;
        }
        if (project.download_link) {
          projectLinks.innerHTML += `<a href="${project.download_link}" class="project-link"><i class="bi bi-download"></i> Executable</a>`;
        }
        if (project.github_link) {
          projectLinks.innerHTML += `<a href="${project.github_link}" class="project-link"><i class="bi bi-github"></i> Source Code</a>`;
        }

        // 🔹 Build carousel if project has multiple images
        if (project.images && project.images.length > 0) {
          const carouselId = `modal-carousel-${project.id}`;
          imageContainer.innerHTML = `
            <div id="${carouselId}" class="carousel slide mb-3" data-bs-ride="carousel">
              <div class="carousel-inner">
                ${project.images.map((img, index) => `
                  <div class="carousel-item ${index === 0 ? 'active' : ''}">
                    <img src="../../../backend/${img}" class="d-block w-100 rounded" alt="Project Image ${index + 1}">
                  </div>
                `).join("")}
              </div>

              ${project.images.length > 1 ? `
                <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
                  <i class="bi bi-chevron-left fs-1 text-dark"></i>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
                  <i class="bi bi-chevron-right fs-1 text-dark"></i>
                  <span class="visually-hidden">Next</span>
                </button>
              ` : ""}
            </div>
          `;

          // Initialize carousel
          const insertedCarousel = document.getElementById(carouselId);
          new bootstrap.Carousel(insertedCarousel, {
            interval: false,
            ride: false,
            wrap: true
          });
        } else {
          // If no images → fallback to default
          imageContainer.innerHTML = `
          <img src="../../assets/img/events/project-game-example.png" class="img-fluid rounded mb-3" alt="Default Project Image">
        `;
        }
      });
    }

    if (editPostBtn) {
      editPostBtn.addEventListener("click", (e) => {
        document.getElementById("editProjectTitle").value = project.project_title;
        document.getElementById("editProjectDescription").value = project.project_description;
        document.getElementById("editProjectType").value = project.project_category;
        document.getElementById("editVisibility").value = project.visibility;
        document.getElementById("editFeaturedToggle").checked = !!project.featured;
        document.getElementById("editProjectForm").dataset.id = project.id;
        document.getElementById("editprojectId").value = project.id;


        //links
        document.getElementById("editDownload").value = project.download_link;
        document.getElementById("editGithub").value = project.github_link;
        document.getElementById("editLive").value = project.live_link;

        const techTagsContainer = document.getElementById("techTagsContainer");
        const oldTechInput = document.getElementById("editProjectTech");

        // local array of current technologies
        let currentTechs = [...(project.technologies || [])];

        // Replace input to clear old listeners
        oldTechInput.replaceWith(oldTechInput.cloneNode(true));
        const techInput = document.getElementById("editProjectTech");

        // Function to render tags with ❌
        function renderTechTags() {
          techTagsContainer.innerHTML = "";
          currentTechs.forEach((tag, index) => {
            const span = document.createElement("span");
            span.classList.add("tech-tag", "me-1", "mb-1", "d-inline-flex", "align-items-center");
            span.innerHTML = `
          ${tag}
          <button type="button" class="btn-close btn-sm ms-2" style="font-size:10px;" aria-label="Remove"></button>
        `;
            // remove on click
            span.querySelector("button").addEventListener("click", () => {
              currentTechs.splice(index, 1);
              renderTechTags();
            });
            techTagsContainer.appendChild(span);
          });
          // sync hidden input for backend
          document.getElementById("hiddenTechInput").value = currentTechs.join(",");
        }

        // initial render
        renderTechTags();

        // Add new tech on Enter
        techInput.addEventListener("keydown", (e) => {
          if (e.key === "Enter") {
            e.preventDefault();
            const newTech = techInput.value.trim();
            if (newTech && !currentTechs.includes(newTech)) {
              currentTechs.push(newTech);
              renderTechTags();
            }
            techInput.value = "";
          }
        });

        //image
        const imagesContainer = document.getElementById("editImagesContainer");
        const imageInput = document.getElementById("editProjectImageUpload");
        const addImageBtn = document.getElementById("changeProjectImageBtn");

        currentImages = [...(project.images || [])];
        newImages = [];

        function renderImages() {
          imagesContainer.innerHTML = "";

          // Render old DB images
          currentImages.forEach((imgPath, index) => {
            const wrapper = document.createElement("div");
            wrapper.classList.add("position-relative");
            wrapper.style.width = "100px";
            wrapper.style.height = "100px";

            wrapper.innerHTML = `
      <img src="../../../backend/${imgPath}" 
           class="img-fluid rounded" 
           style="width:100%;height:100%;object-fit:cover;">
      <button type="button" 
              class="btn-close position-absolute top-0 end-0 bg-white rounded-circle p-1" 
              aria-label="Remove"></button>
    `;

            wrapper.querySelector("button").addEventListener("click", () => {
              currentImages.splice(index, 1); // remove from DB array
              renderImages();
            });

            imagesContainer.appendChild(wrapper);
          });

          // Render new uploaded images
          newImages.forEach((file, index) => {
            const wrapper = document.createElement("div");
            wrapper.classList.add("position-relative");
            wrapper.style.width = "100px";
            wrapper.style.height = "100px";

            const fileUrl = URL.createObjectURL(file);

            wrapper.innerHTML = `
      <img src="${fileUrl}" 
           class="img-fluid rounded" 
                style="width:100%;height:100%;object-fit:cover;">
            <button type="button" 
                    class="btn-close position-absolute top-0 end-0 bg-white rounded-circle p-1" 
                    aria-label="Remove"></button>
          `;

            wrapper.querySelector("button").addEventListener("click", () => {
              newImages.splice(index, 1); // remove from new uploads
              renderImages();
            });

            imagesContainer.appendChild(wrapper);
          });

          // Update hidden input with only DB images
          document.getElementById("hiddenImagesInput").value = currentImages.join(",");

          // Limit 8 total images
          addImageBtn.disabled = (currentImages.length + newImages.length) >= 8;
        }

        // Initial render
        renderImages();

        // Trigger file input
        addImageBtn.onclick = () => imageInput.click();

        // Handle new files
        imageInput.onchange = (e) => {
          const files = Array.from(e.target.files);
          files.forEach((file) => {
            if ((currentImages.length + newImages.length) < 8) {
              newImages.push(file);
            }
          });
          renderImages();
          imageInput.value = ""; // reset input
        };



      });
    }
  }




  fetch("../../../backend/api/get_project.php")
    .then(res => res.json())
    .then(data => {
      console.log(data);
      if (!data.success) {
        console.error("Error:", data.message || "Failed to fetch posts");
        return;
      }

      allProjects = data.posts;
      renderProjectsTable(allProjects, "all-projects");

    })

  editForm.addEventListener("submit", function (e) {
    e.preventDefault();
    e.stopPropagation();

    const dataForm = new FormData(editForm);

    const projectId = editForm.getAttribute("data-id");
    dataForm.append("projectId", projectId);

    newImages.forEach((file) => {
      dataForm.append("new_images[]", file);
    });

    // Keep DB images
    dataForm.append("existing_images", currentImages.join(","));

    document.getElementById("editProjectUploadOverlay").classList.remove("d-none");
    document.getElementById("editProjectUploadLoader").classList.remove("d-none");
    document.getElementById("editProjectUploadSuccess").classList.add("d-none");

    document.getElementById("editProjectGeneralUploadError").classList.add("d-none");

    console.log([...dataForm.entries()]);

    fetch("../../../backend/api/edit_student_project.php", {
      method: "POST",
      body: dataForm,
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          console.log("✅ project edited:", data);
          document.getElementById("editProjectUploadLoader").classList.add("d-none");
          document.getElementById("editProjectUploadSuccess").classList.remove("d-none");


          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          document.getElementById("editProjectUploadLoader").classList.add("d-none");
          document.getElementById("editProjectUploadOverlay").classList.add("d-none");
          document.getElementById("editProjectGeneralUploadError").classList.remove("d-none");
          document.getElementById("editProjectGeneralUploadError").innerText = data.errors || "Failed to edit post.";
        }
      })
      .catch(err => {
        console.error("❌ Error:", err);
        document.getElementById("editProjectGeneralUploadError").classList.remove("d-none");
        document.getElementById("editProjectGeneralUploadError").innerText = "Unexpected error while editing post.";
      });

  })
})

