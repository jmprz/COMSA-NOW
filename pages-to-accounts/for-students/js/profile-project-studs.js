// profile-projects.js - Displays projects for the logged-in student only
document.addEventListener('DOMContentLoaded', function() {

    const projectsContainer = document.getElementById('studentProjectsContainer');
    const uploadBtn = document.getElementById('uploadProjectBtn');

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

    function truncateText(text, maxLength) {
        return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
    }

    // Fetch student projects
    async function fetchStudentProjects() {
        try {
            const response = await fetch(`../../../backend/api/get_student_projects.php`);
            const data = await response.json();

            if (data.success && data.posts && data.posts.length > 0) {
                window.studentProjectsData = data.posts;
                displayProjects(data.posts);
                updateProjectStats(data.total_projects || data.posts.length);
                updateTotalStars(data.total_stars || 0);
            } else {
                displayNoProjectsMessage();
                updateProjectStats(0);
                updateTotalStars(0);
            }
        } catch (error) {
            console.error('Error fetching projects:', error);
            displayError();
            updateProjectStats(0);
            updateTotalStars(0);
        }
    }

    function updateTotalStars(count) {
        const starsCountEl = document.getElementById('totalStarsCount');
        if (starsCountEl) starsCountEl.textContent = count;
    }

    function updateProjectStats(count) {
        const projectCountEl = document.querySelector('.stat-item .stat-number');
        if (projectCountEl) projectCountEl.textContent = count;
    }

    // Display projects
    function displayProjects(projects) {
        projectsContainer.innerHTML = '';

        projects.forEach((project, index) => {
            const projectCol = document.createElement('div');
            projectCol.className = 'col-12 col-md-12 col-lg-12 mb-2';

            const categoryKey = project.project_category.toLowerCase().trim();
            const categoryClass = categoryClassMap[categoryKey] || 'all';

            projectCol.innerHTML = `
                <div class="project-card shadow-sm h-100 position-relative overflow-hidden cursor-pointer" data-index="${index}">
                    <span class="project-badge ${categoryClass}-badge position-absolute top-0 end-0 m-2">${project.project_category}</span>
                    ${project.images && project.images.length > 0 ? 
                        `<img src="../../../backend/${project.images[0]}" class="project-card-img w-100" alt="${project.project_title}">` :
                        `<div class="project-card-img placeholder d-flex align-items-center justify-content-center">
                            <i class="ri-image-line fs-1 text-muted"></i>
                        </div>`
                    }
                    <div class="project-card-body p-3">
                        <h5 class="project-title mt-3 mb-2">${project.project_title}</h5>
                        <p class="project-description mb-3" data-full="${project.project_description}">
                            ${truncateText(project.project_description, 100)}
                            ${project.project_description.length > 100 ? '<span class="read-more text-primary" style="cursor:pointer;"> Read More</span>' : ''}
                        </p>
                        <div class="project-card-tech mb-3">
                            ${project.technologies && project.technologies.length > 0 ?
                                project.technologies.map(tech => `<span class="tech-tag me-1 mb-1">${tech}</span>`).join('') :
                                `<span class="text-muted">No technologies listed</span>`
                            }
                        </div>
                        <div class="d-flex justify-content-start gap-3 mb-2">
                            <i class="ri-heart-3-fill text-comsa-highlight"></i> ${project.like_count || 0} Likes
                            <i class="ri-chat-3-line"></i> ${project.comment_count || 0} Comments
                        </div>
                    </div>
                </div>
            `;
            projectsContainer.appendChild(projectCol);
        });

        addCardClickListeners();
        addReadMoreToggle();
    }

    // Click card to open modal
    function addCardClickListeners() {
        document.querySelectorAll('.project-card').forEach(card => {
            card.addEventListener('click', async function(e) {
                // Prevent opening modal if clicking inside buttons
                if (e.target.closest('.edit-project') || e.target.closest('.delete-project')) return;

                const index = this.dataset.index;
                const projectData = window.studentProjectsData[index];
                openProjectModal(projectData);
            });
        });
    }

    async function openProjectModal(projectData) {
        const projectId = projectData.id;

        document.getElementById('viewProjectModalTitle').textContent = projectData.project_title;

        // Carousel
        const carouselInner = document.getElementById('viewProjectModalImages');
        carouselInner.innerHTML = '';
        if (projectData.images && projectData.images.length > 0) {
            projectData.images.forEach((img, index) => {
                const item = document.createElement('div');
                item.className = `carousel-item ${index === 0 ? 'active' : ''}`;
                item.innerHTML = `<img src="../../../backend/${img}" class="d-block w-100" alt="Project Image ${index+1}">`;
                carouselInner.appendChild(item);
            });
        } else {
            carouselInner.innerHTML = `<div class="text-center text-muted">No images available</div>`;
        }

        document.getElementById('viewProjectModalDescription').textContent = projectData.project_description;

        document.getElementById('viewProjectModalTech').innerHTML = projectData.technologies && projectData.technologies.length > 0
            ? projectData.technologies.map(t => `<span class="badge bg-secondary me-1 mb-1">${t}</span>`).join('')
            : '<span class="text-muted">No technologies listed</span>';

        const linksContainer = document.getElementById('viewProjectModalLinks');
        linksContainer.innerHTML = '';
        if (projectData.download_link) linksContainer.innerHTML += `<a href="${projectData.download_link}" target="_blank" class="btn btn-outline-secondary rounded-pill px-3">Download</a>`;
        if (projectData.live_link) linksContainer.innerHTML += `<a href="${projectData.live_link}" target="_blank" class="btn btn-outline-secondary rounded-pill px-3">Live Demo</a>`;
        if (projectData.github_link) linksContainer.innerHTML += `<a href="${projectData.github_link}" target="_blank" class="btn btn-outline-secondary rounded-pill px-3">GitHub</a>`;

        // Likes & comments
        const likeIcon = document.getElementById('modalLikeIcon');
        const likeCount = document.getElementById('modalLikeCount');
        const commentCount = document.getElementById('modalCommentCount');
        const commentsEl = document.getElementById('modalComments');
        const commentInput = document.getElementById('modalCommentInput');

        likeCount.textContent = projectData.like_count || 0;
        commentCount.textContent = projectData.comment_count || 0;
        likeIcon.className = projectData.liked_by_user ? 'ri-heart-3-fill text-comsa-highlight fs-6' : 'ri-heart-3-line fs-6';

        commentsEl.innerHTML = `<div class="text-muted">Loading comments...</div>`;
        try {
            const res = await fetch(`../../../backend/api/get_comments.php?project_id=${projectId}`);
            const commentsData = await res.json();
            commentsEl.innerHTML = commentsData.length
                ? commentsData.map(c => `<div class="mb-2"><strong>${c.name}</strong>: ${c.comment}</div>`).join('')
                : `<div class="text-muted">No comments yet.</div>`;
        } catch(err) {
            commentsEl.innerHTML = `<div class="text-danger">Failed to load comments.</div>`;
        }

        document.getElementById('modalLikeBtn').onclick = async () => {
            const liked = likeIcon.classList.contains('ri-heart-3-fill');
            likeIcon.classList.toggle('ri-heart-3-fill', !liked);
            likeIcon.classList.toggle('text-comsa-highlight', !liked);
            likeIcon.classList.toggle('ri-heart-3-line', liked);
            likeCount.textContent = Number(likeCount.textContent) + (liked ? -1 : 1);

            await fetch("../../../backend/api/like_project.php", {
                method: 'POST',
                headers: { "Content-type": "application/json" },
                credentials: 'include',
                body: JSON.stringify({ project_id: projectId })
            });
        };

        document.getElementById('modalAddCommentBtn').onclick = async () => {
            const comment = commentInput.value.trim();
            if (!comment) return;
            const res = await fetch("../../../backend/api/add_comment.php", {
                method: 'POST',
                headers: { "Content-type": "application/json" },
                credentials: 'include',
                body: JSON.stringify({ project_id: projectId, comment })
            });
            const data = await res.json();
            if (data.success) {
                commentInput.value = '';
                commentsEl.innerHTML += `<div class="mb-2"><strong>You</strong>: ${comment}</div>`;
                commentCount.textContent = Number(commentCount.textContent) + 1;
            }
        };

        // Edit/Delete inside modal
        const editBtn = document.getElementById('modalEditBtn');
        const deleteBtn = document.getElementById('modalDeleteBtn');
        editBtn.dataset.id = projectId;
        deleteBtn.dataset.id = projectId;

        editBtn.onclick = () => editProject(projectId);
        deleteBtn.onclick = () => deleteProject(projectId);

        const modal = new bootstrap.Modal(document.getElementById('viewProjectModal'));
        modal.show();
    }

    function addReadMoreToggle() {
        projectsContainer.querySelectorAll('.project-description .read-more').forEach(btn => {
            btn.addEventListener('click', function() {
                const p = this.closest('.project-description');
                const fullText = p.dataset.full;

                if (this.textContent.trim() === 'Read More') {
                    p.innerHTML = fullText + ' <span class="read-more text-primary" style="cursor:pointer;"> Read Less</span>';
                } else {
                    p.innerHTML = truncateText(fullText, 100) + ' <span class="read-more text-primary" style="cursor:pointer;"> Read More</span>';
                }
                p.querySelector('.read-more').addEventListener('click', arguments.callee);
            });
        });
    }


    // Function to display message when no projects exist
    function displayNoProjectsMessage() {
        projectsContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="ri-folder-open-line fs-1 text-muted mb-3"></i>
                <h4>No Projects Yet</h4>
                <p class="text-muted">You haven't uploaded any projects yet.</p>
                <button class="btn btn-primary" id="uploadProjectBtnEmpty">
                    <i class="ri-upload-line me-2"></i>Upload Your First Project
                </button>
            </div>
        `;
        
        // Add event listener to the empty state button
        document.getElementById('uploadProjectBtnEmpty')?.addEventListener('click', () => {
            const uploadModal = new bootstrap.Modal(document.getElementById('projectUploadModal'));
            uploadModal.show();
        });
    }

    // Function to display error message
    function displayError() {
        projectsContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="ri-error-warning-line fs-1 text-danger mb-3"></i>
                <h4>Error Loading Projects</h4>
                <p class="text-muted">We couldn't load your projects. Please try again later.</p>
            </div>
        `;
    }

    // Function to add event listeners for project actions
    function addProjectActionListeners() {
        // Edit project buttons
        document.querySelectorAll('.edit-project').forEach(btn => {
            btn.addEventListener('click', function() {
                const projectId = this.dataset.id;
                editProject(projectId);
            });
        });
        
        // Delete project buttons
        document.querySelectorAll('.delete-project').forEach(btn => {
            btn.addEventListener('click', function() {
                const projectId = this.dataset.id;
                deleteProject(projectId);
            });
        });
    }

    // Function to handle project editing
    async function editProject(projectId) {
        try {
            const response = await fetch(`../../../backend/api/get_project_details.php?id=${projectId}`);
            const data = await response.json();
            
            if (data.success && data.project) {
                const project = data.project;
                
                // Populate the edit modal
                document.getElementById('editProjectTitle').value = project.project_title;
                document.getElementById('editProjectType').value = project.project_category;
                document.getElementById('editProjectDescription').value = project.project_description;
                document.getElementById('editDownloadLink').value = project.download_link || '';
                document.getElementById('editLiveLink').value = project.live_link || '';
                document.getElementById('editGithubLink').value = project.github_link || '';
                
                // Set technologies
                const techTagsContainer = document.getElementById('editTechTags');
                techTagsContainer.innerHTML = '';
                if (project.technologies && project.technologies.length > 0) {
                    project.technologies.forEach(tech => {
                        const tag = document.createElement('span');
                        tag.className = 'badge bg-secondary px-2 py-1 rounded-pill d-flex align-items-center me-1 mb-1';
                        tag.innerHTML = `
                            ${tech}
                            <button type="button" class="btn-close btn-close-white btn-sm ms-2 remove-tech-tag"></button>
                        `;
                        techTagsContainer.appendChild(tag);
                    });
                }
                
                // Set team members
                const memberTagsContainer = document.getElementById('editMemberTags');
                memberTagsContainer.innerHTML = '';
                if (project.team_members && project.team_members.length > 0) {
                    project.team_members.forEach(member => {
                        const tag = document.createElement('span');
                        tag.className = 'badge bg-secondary px-2 py-1 rounded-pill d-flex align-items-center me-1 mb-1';
                        tag.innerHTML = `
                            ${member}
                            <button type="button" class="btn-close btn-close-white btn-sm ms-2 remove-member-tag"></button>
                        `;
                        memberTagsContainer.appendChild(tag);
                    });
                }


                            const imagesContainer = document.getElementById('currentProjectImages');
            imagesContainer.innerHTML = '';
            
            if (project.images && project.images.length > 0) {
                project.images.forEach((imagePath, index) => {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.className = 'position-relative';
                    imgWrapper.style.width = '100px';
                    imgWrapper.style.height = '100px';
                    
                    imgWrapper.innerHTML = `
                        <img src="../../../backend/${imagePath}" 
                             class="img-thumbnail w-100 h-100 object-fit-cover" 
                             alt="Project image ${index + 1}"
                             style="object-fit: cover;">
                    `;
                    imagesContainer.appendChild(imgWrapper);
                });
            } else {
                imagesContainer.innerHTML = `
                    <div class="text-center w-100 py-3">
                        <i class="ri-image-line fs-3 text-muted"></i>
                        <p class="small text-muted mb-0">No images available</p>
                    </div>
                `;
            }
                
                // Store project ID for update
                document.getElementById('editProjectForm').dataset.projectId = projectId;
                
                // Show edit modal
                const editModal = new bootstrap.Modal(document.getElementById('editProjectModal'));
                editModal.show();
                
            } else {
                throw new Error(data.message || 'Failed to load project');
            }
        } catch (error) {
            console.error('Error editing project:', error);
            alert('Failed to load project details: ' + error.message);
        }
    }

    // Function to handle project deletion
    async function deleteProject(projectId) {
        if (confirm('Are you sure you want to delete this project? This action cannot be undone.')) {
            try {
                const response = await fetch(`../../../backend/api/delete_project.php`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: projectId })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Refresh project list
                    fetchStudentProjects();
                    alert('Project deleted successfully');
                } else {
                    throw new Error(result.message || 'Failed to delete project');
                }
            } catch (error) {
                console.error('Error deleting project:', error);
                alert('Failed to delete project: ' + error.message);
            }
        }
    }

    // Initialize edit modal functionality
    function initEditModal() {
        const editForm = document.getElementById('editProjectForm');
        
        // Handle form submission
        editForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const projectId = this.dataset.projectId;
            const formData = new FormData(this);
            
            try {
                // Add technologies and members to form data
                const techTags = Array.from(document.querySelectorAll('#editTechTags .badge'))
                    .map(tag => tag.textContent.trim());
                const memberTags = Array.from(document.querySelectorAll('#editMemberTags .badge'))
                    .map(tag => tag.textContent.trim());
                
                techTags.forEach((tech, index) => {
                    formData.append(`technologies[${index}]`, tech);
                });
                
                memberTags.forEach((member, index) => {
                    formData.append(`team_members[${index}]`, member);
                });
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
                
                const response = await fetch(`../../../backend/api/update_project.php?id=${projectId}`, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
            showEditProjectSuccess();
            
            // Wait for success animation before closing
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('editProjectModal'));
                modal.hide();
                fetchStudentProjects();
            }, 1500);
        } else {
            throw new Error(result.message || 'Failed to update project');
        }
    } catch (error) {
        console.error('Error updating project:', error);
        showEditProjectError(error.message);
    } finally {
        const submitBtn = editForm.querySelector('button[type="submit"]');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Save Changes';
        
        // Auto-hide error after 3 seconds
        if (!document.getElementById('editProjectError').classList.contains('d-none')) {
            setTimeout(hideEditProjectOverlay, 3000);
        }
    }
});
        
        // Initialize tag functionality for edit modal
        initEditTagInput('editProjectTechnologies', 'editTechTags');
        initEditTagInput('editProjectTeam', 'editMemberTags');
    }

    // Reset loader when modal is hidden
document.getElementById('editProjectModal').addEventListener('hidden.bs.modal', function() {
    hideEditProjectOverlay();
    document.getElementById('editProjectLoader').classList.remove('d-none');
    document.getElementById('editProjectSuccess').classList.add('d-none');
    document.getElementById('editProjectError').classList.add('d-none');
});


// Function to show edit project loader
function showEditProjectLoader() {
    const overlay = document.getElementById('editProjectOverlay');
    const loader = document.getElementById('editProjectLoader');
    const success = document.getElementById('editProjectSuccess');
    const error = document.getElementById('editProjectError');
    
    overlay.classList.remove('d-none');
    loader.classList.remove('d-none');
    success.classList.add('d-none');
    error.classList.add('d-none');
    error.textContent = '';
}

// Function to show edit project success
function showEditProjectSuccess() {
    const loader = document.getElementById('editProjectLoader');
    const success = document.getElementById('editProjectSuccess');
    
    loader.classList.add('d-none');
    success.classList.remove('d-none');
    
    
    setTimeout(() => {
        hideEditProjectOverlay();
    }, 1500);
}

function showEditProjectError(message) {
    const loader = document.getElementById('editProjectLoader');
    const error = document.getElementById('editProjectError');
    
    loader.classList.add('d-none');
    error.classList.remove('d-none');
    error.textContent = message || 'Failed to update project';
}

function hideEditProjectOverlay() {
    const overlay = document.getElementById('editProjectOverlay');
    overlay.classList.add('d-none');
}



    // Initialize tag input for edit modal
    function initEditTagInput(inputId, containerId) {
        const input = document.getElementById(inputId);
        const container = document.getElementById(containerId);
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const value = this.value.trim();
                
                if (value && !Array.from(container.querySelectorAll('.badge'))
                    .some(tag => tag.textContent.trim() === value)) {
                    
                    const tag = document.createElement('span');
                    tag.className = 'badge bg-secondary px-2 py-1 rounded-pill d-flex align-items-center me-1 mb-1';
                    tag.innerHTML = `
                        ${value}
                        <button type="button" class="btn-close btn-close-white btn-sm ms-2 remove-tag"></button>
                    `;
                    container.appendChild(tag);
                    this.value = '';
                }
            }
        });
        
        // Handle tag removal
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-tag') || e.target.classList.contains('remove-tech-tag') || e.target.classList.contains('remove-member-tag')) {
                e.target.closest('.badge').remove();
            }
        });
    }

    // Initialize the page
    fetchStudentProjects();
    initEditModal();
    
    // Handle upload button click
    uploadBtn.addEventListener('click', function() {
        const uploadModal = new bootstrap.Modal(document.getElementById('projectUploadModal'));
        
        
        // Reset the modal for new uploada
        document.getElementById('projectUploadForm').reset();
        document.getElementById('tagsWrapper').innerHTML = '';
        document.getElementById('tagsMemberWrapper').innerHTML = '';
        document.getElementById('mediaPreview').innerHTML = '';
        document.getElementById('mediaCounter').textContent = '0/8 images selected';
        document.getElementById('projectUploadForm').removeAttribute('data-project-id');
        uploadModal.show();

        
        uploadModal.show();
    });

    // Handle successful project upload/update
    document.getElementById('projectUploadForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        

        // After successful upload/update, refresh the projects list:
        fetchStudentProjects();
    });
});