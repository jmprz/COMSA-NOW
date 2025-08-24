// profile-projects.js - Displays projects for the logged-in student only
document.addEventListener('DOMContentLoaded', function() {


    const projectsContainer = document.getElementById('studentProjectsContainer');
    const uploadBtn = document.getElementById('uploadProjectBtn');
    
    // Function to fetch and display projects
async function fetchStudentProjects() {
    try {
        const response = await fetch(`../../../backend/api/get_student_projects.php?student_id=${studentId}`);
        const data = await response.json();
        
        if (data.success && data.posts.length > 0) {
            displayProjects(data.posts);
            updateProjectStats(data.posts.length);
            updateTotalStars(data.total_stars);
        } else {
            displayNoProjectsMessage();
            updateProjectStats(0);
            updateTotalStars(0); // Set to 0 if no projects
        }
    } catch (error) {
        console.error('Error fetching projects:', error);
        displayError();
        updateTotalStars(0); // Set to 0 on error
    }
}

// Function to update total stars
function updateTotalStars(count) {
    const starsCountEl = document.getElementById('totalStarsCount');
    if (starsCountEl) {
        starsCountEl.textContent = count;
    }
}

    // Function to update project stats in the header
    function updateProjectStats(count) {
        const projectCountEl = document.querySelector('.stat-item .stat-number');
        if (projectCountEl) {
            projectCountEl.textContent = count;
        }
    }

    // Function to display projects
    function displayProjects(projects) {
        // Clear existing content
        projectsContainer.innerHTML = '';
        
        // Create project cards for each project
        projects.forEach(project => {
            const projectCol = document.createElement('div');
            projectCol.className = 'col-md-6 mb-4';
            
            projectCol.innerHTML = `
                <div class="project-card">
                    ${project.images && project.images.length > 0 ? 
                        `<img src="../../../backend/${project.images[0]}" class="project-card-img" alt="${project.project_title}">` : 
                        `<div class="project-card-img bg-light d-flex align-items-center justify-content-center">
                            <i class="ri-image-line fs-1 text-muted"></i>
                        </div>`
                    }
                    <div class="project-card-body">
                        <h5 class="project-card-title">${project.project_title}</h5>
                        <p class="project-card-desc">${project.project_description}</p>
                        <div class="project-card-tech">
                            ${project.technologies.map(tech => `<span class="badge bg-secondary me-1">${tech}</span>`).join('')}
                        </div>
                        <div class="project-card-footer">
                            <span class="project-card-type">${project.project_category}</span>
                            <div class="project-card-actions">
                                <button class="btn btn-sm btn-outline-primary edit-project" data-id="${project.id}">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-project" data-id="${project.id}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            projectsContainer.appendChild(projectCol);
        });
        
        // Add event listeners for edit/delete buttons
        addProjectActionListeners();
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
                    // Close modal and refresh projects
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editProjectModal'));
                    modal.hide();
                    fetchStudentProjects();
                    alert('Project updated successfully');
                } else {
                    throw new Error(result.message || 'Failed to update project');
                }
            } catch (error) {
                console.error('Error updating project:', error);
                alert('Failed to update project: ' + error.message);
            } finally {
                const submitBtn = editForm.querySelector('button[type="submit"]');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Save Changes';
            }
        });
        
        // Initialize tag functionality for edit modal
        initEditTagInput('editProjectTechnologies', 'editTechTags');
        initEditTagInput('editProjectTeam', 'editMemberTags');
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
        
        // Reset the modal for new upload
        document.querySelector('#projectUploadModal .modal-title').textContent = 'Upload Your Project';
        document.querySelector('#projectUploadModal .modal-footer button[type="submit"]').textContent = 'Upload Project';
        document.getElementById('projectUploadForm').reset();
        document.getElementById('tagsWrapper').innerHTML = '';
        document.getElementById('tagsMemberWrapper').innerHTML = '';
        document.getElementById('mediaPreview').innerHTML = '';
        document.getElementById('mediaCounter').textContent = '0/8 images selected';
        document.getElementById('projectUploadForm').removeAttribute('data-project-id');
        
        uploadModal.show();
    });

    // Handle successful project upload/update
    document.getElementById('projectUploadForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Your existing upload form handling code...
        // After successful upload/update, refresh the projects list:
        fetchStudentProjects();
    });
});