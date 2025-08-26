document.addEventListener("DOMContentLoaded", () => {
    const postForm = document.getElementById('postForm');
    const tagInput = document.getElementById("postTags")
    const tagWrapper = document.getElementById("tagsWrapper");

    const tableHead = document.getElementById("tableHeadPost");
    const tableBody = document.getElementById("tableBodyPost");
    const table = document.getElementById("allPostsTable");

    const tagEditInput = document.getElementById("editPostTags");
    tagArray = document.getElementById("editTagsContainer");


    document.getElementById("editPostModal").addEventListener("hidden.bs.modal", function () {
        document.getElementById("editTagsContainer").innerHTML = "";
    });

    document.getElementById("editPostModal").addEventListener("hidden.bs.modal", function () {
        tagArray.innerHTML = "";
        editTags = [];
        tagEditInput.value = "";
    });

    function formatDateTime(dateTimeStr) {
        const date = new Date(dateTimeStr);
        const options = {
            day: "2-digit",
            month: "short",
            year: "numeric",
            hour: "numeric",
            minute: "2-digit",
            hour12: true
        };
        return date.toLocaleString("en-US", options).replace(",", "");
    }

    let editTags = [];

    function createTagBadge(value) {
        const newTagEl = document.createElement("span");
        newTagEl.className = "badge bg-light text-dark tag-badge me-1 mb-1 d-inline-flex align-items-center";

        // Label
        const tagText = document.createElement("span");
        tagText.textContent = value;

        // Remove button
        const removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.className = "btn-close btn-close-black ms-2";
        removeBtn.style.fontSize = "0.7rem";
        removeBtn.style.float = "none";

        removeBtn.addEventListener("click", () => {
            // Remove from array
            editTags = editTags.filter(t => t !== value);
            console.log("Updated tags:", editTags);

            // Remove badge from DOM
            newTagEl.remove();
        });

        newTagEl.appendChild(tagText);
        newTagEl.appendChild(removeBtn);
        tagArray.appendChild(newTagEl);
    }

    tagEditInput.addEventListener("keydown", (e) => {
        if (e.key === " " || e.key === "Enter") {
            e.preventDefault();
            const value = tagEditInput.value.trim();

            if (value !== "" && !editTags.includes(value)) {
                editTags.push(value);
                createTagBadge(value);
                tagEditInput.value = "";
                console.log("Current tags:", editTags);
            }
        }
    });

    fetch("../../../backend/api/admin/get_all_posts.php")
        .then(res => res.json())
        .then(data => {

            if (!data.success) {
                console.error("Error:", data.message || "Failed to fetch events");
                return;
            }

            if (data.posts.length === 0) {
                tableHead.classList.add("d-none");
                tableBody.classList.add("d-none");
                table.innerHTML = `<div class="d-flex justify-content-center text-secondary">
                        <div class="d-flex flex-column align-items-center">
                          <i class="bi bi-emoji-frown fs-1 mb-2"></i>
                          <p class="text-center">You Haven't Added Any Quick Links For Now.</p>
                        </div>
                      </div>`

            }

            if (data.success) {
                tableHead.classList.remove('d-none');
                tableBody.classList.remove('d-none');

                data.posts.forEach(post => {
                    const newEl = document.createElement("tr");

                    let badgeClass = "";
                    switch (post.post_status.toLowerCase()) {
                        case "archived":
                            badgeClass = "bg-dark";
                            break;
                        case "published":
                            badgeClass = "bg-success";
                            break;
                        case "draft":
                            badgeClass = "bg-secondary";
                            break;
                        default:
                            badgeClass = "bg-info";
                    }

                    newEl.innerHTML = `
                        <td>${post.id}</td>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="../../../backend/${post.post_image}" class="rounded me-2" width="40" height="40">
                              <span>${post.title}</span>
                            </div>
                          </td>
                          <td>${formatDateTime(post.updated_at)}</td>
                          <td><span class="badge ${badgeClass}">${post.post_status}</span></td>
                          <td>
                            <div id="tableStatus" class="d-flex align-items-center">
                              <i class="ri-star-fill text-success me-1"></i> ${post.like_count}
                              <i class="ri-chat-3-fill text-info ms-3 me-1"></i> ${post.comment_count}
                            </div>
                          </td>
                          <td>
                            ${post.post_status.toLowerCase() !== 'archived' ?
                            (`<div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <button data-id="${post.id}" class="dropdown-item editPostBtn" data-bs-toggle="modal" data-bs-target="#editPostModal">
                                            <i class="ri-edit-line me-2"></i>Edit
                                        </button>
                                    </li>
                                    <li>
                                        <button data-id="${post.id}" class="dropdown-item viewPostBtn" data-bs-toggle="modal" data-bs-target="#viewPostModal">
                                            <i class="ri-eye-line me-2"></i>View
                                        </button>
                                    </li>
                                    <li>
                                        <button data-id="${post.id}" class="dropdown-item archivePostBtn" >
                                            <i class="ri-archive-line me-2"></i>Archive
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button data-id="${post.id}" class="dropdown-item text-danger deletePostBtn" >
                                            <i class="ri-delete-bin-line me-2"></i>Delete
                                        </button>
                                    </li>
                                </ul>
                            </div>`)
                            :
                            (`<div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                    <li>
                                        <button data-id="${post.id}" class="dropdown-item viewPostBtn" data-bs-toggle="modal" data-bs-target="#viewPostModal">
                                            <i class="ri-eye-line me-2"></i>View
                                        </button>
                                    </li>
                                    <li>
                                        <button data-id="${post.id}" class="dropdown-item restorePostBtn">
                                            <i class="ri-arrow-up-circle-line me-2"></i>Restore
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button data-id="${post.id}" class="dropdown-item text-danger deletePostBtn">
                                            <i class="ri-delete-bin-line me-2"></i>Delete
                                        </button>
                                    </li>
                                </ul>
                            </div>`)
                        }

                        </td>
                    `
                    tableBody.appendChild(newEl);

                    const editPostBtn = newEl.querySelector(".editPostBtn");
                    const viewPostBtn = newEl.querySelector(".viewPostBtn");
                    const archivePostBtn = newEl.querySelector(".archivePostBtn");
                    const deletePostBtn = newEl.querySelector(".deletePostBtn");
                    const restorePostBtn = newEl.querySelector(".restorePostBtn");

                    if (editPostBtn) {
                        editPostBtn.addEventListener("click", function (e) {
                            const postId = e.target.dataset.id;

                            document.getElementById("editPostTitle").value = post.title;
                            document.getElementById("editPostContent").value = post.content;
                            document.getElementById("editImagePreview").src = `../../../backend/${post.post_image}`;
                            document.getElementById("editPostStatus").value = post.post_status;


                            tagArray.innerHTML = "";
                            editTags = [];

                            // Add post tags as badges
                            post.tags.forEach(tag => {
                                editTags.push(tag);
                                createTagBadge(tag);
                            });

                        });
                    }

                    if (viewPostBtn) {
                        viewPostBtn.addEventListener("click", async function (e) {
                            const postId = e.target.dataset.id;
                            const adminViewTagContainer = document.getElementById("adminViewTagContainer");
                            const viewCommentsContainer = document.getElementById("viewCommentsContainer");
                            const addCommentInput = document.getElementById("adminViewAddComment");
                            const addCommentBtn = document.getElementById("adminViewSubmitComment");
                            const adminViewCommentCount = document.getElementById("adminViewCommentCount");

                            // Populate post details
                            document.getElementById("adminViewName").innerText = post.admin_username || "Admin";
                            document.getElementById("adminPostDate").innerText = formatDateTime(post.updated_at);
                            document.getElementById("adminViewTitle").innerText = post.title;
                            document.getElementById("adminViewImage").src = `../../../backend/${post.post_image}`;
                            document.getElementById("adminViewContent").innerText = post.content;
                            adminViewCommentCount.innerText = `Comments (${post.comment_count})`;

                            // Likes & comment icons
                            const likeBtn = document.getElementById("adminViewLike");
                            likeBtn.innerHTML = `<i class="ri-star-line"></i> ${post.like_count}`;

                            const commentBtn = document.getElementById("adminViewComment");
                            commentBtn.innerHTML = `<i class="ri-chat-3-line"></i> ${post.comment_count}`;

                            // Render tags
                            adminViewTagContainer.innerHTML = "";
                            post.tags.forEach(tag => {
                                const newTagEl = document.createElement("span");
                                newTagEl.className = "badge bg-light text-dark tag-badge";
                                newTagEl.innerText = tag.startsWith("#") ? tag : `#${tag}`;
                                adminViewTagContainer.appendChild(newTagEl);
                            });

                            // Render comments
                            const renderComments = () => {
                                viewCommentsContainer.innerHTML = "";
                                if (post.comments.length > 0) {
                                    post.comments.forEach(comment => {
                                        const newCommentEl = document.createElement("div");
                                        newCommentEl.className = "post-comment mb-3 position-relative";
                                        newCommentEl.innerHTML = `
                                            <div class="d-flex align-items-start">
                                                <img src="${comment.student_photo ? `../../../backend/${comment.student_photo}` : "../../assets/img/default-pic.jpg"}"
                                                    class="rounded-circle me-2" width="32" height="32" alt="User">
                                                <div>
                                                    <strong class="d-block">${comment.student_name}</strong>
                                                    <span>${comment.comment}</span>
                                                </div>
                                            </div>
                                            <button data-id="${comment.id}" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 p-1 comment-delete-btn" title="Delete comment">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        `;
                                        viewCommentsContainer.appendChild(newCommentEl);
                                    });
                                } else {
                                    viewCommentsContainer.innerHTML = `<p class="text-muted">No comments yet.</p>`;
                                }

                                attachDeleteEvents();
                            };

                            // Attach delete events
                            const attachDeleteEvents = () => {
                                document.querySelectorAll(".comment-delete-btn").forEach(btn => {
                                    btn.addEventListener("click", async function (e) {
                                        e.preventDefault();

                                        // Force reference to the button itself
                                        const button = this;
                                        const commentWrapper = button.closest(".post-comment");

                                        if (!commentWrapper) {
                                            console.error("No parent .post-comment found for delete button");
                                            return;
                                        }

                                        const commentId = button.dataset.id;

                                        if (confirm("Are you sure you want to delete this comment?")) {
                                            try {
                                                const res = await fetch("../../../backend/api/admin/admin_delete_comment.php", {
                                                    method: "POST",
                                                    headers: { "Content-Type": "application/json" },
                                                    body: JSON.stringify({ id: commentId })
                                                });

                                                const data = await res.json();

                                                if (data.success) {
                                                    commentWrapper.remove();

                                                    // update count
                                                    const commentCountEl = document.getElementById("adminViewCommentCount");
                                                    const countMatch = commentCountEl.innerText.match(/\d+/);
                                                    let count = countMatch ? parseInt(countMatch[0]) : 0;
                                                    commentCountEl.innerText = `Comments (${count - 1})`;
                                                    commentBtn.innerHTML = `<i class="ri-chat-3-line"></i> ${count - 1}`;
                                                    tableStatus.innerHTML = `
                                                        <i class="ri-star-fill text-success me-1"></i> ${post.like_count}
                                                        <i class="ri-chat-3-fill text-info ms-3 me-1"></i> ${count - 1}
                                                    `

                                                } else {
                                                    alert(data.message || "Failed to delete comment");
                                                }
                                            } catch (err) {
                                                console.error("Error deleting comment:", err);
                                                alert("An error occurred while deleting comment.");
                                            }
                                        }
                                    });

                                });
                            };

                            // Add new comment
                            addCommentBtn.onclick = async () => {
                                const commentText = addCommentInput.value.trim();
                                if (!commentText) {
                                    alert("Please enter a comment.");
                                    return;
                                }

                                try {
                                    const res = await fetch("../../../backend/api/admin/admin_add_comment.php", {
                                        method: "POST",
                                        body: JSON.stringify({
                                            post_id: postId,
                                            comment: commentText
                                        })
                                    });

                                    const data = await res.json();
                                    if (data.success) {
                                        addCommentInput.value = "";

                                        const newCommentEl = document.createElement("div");
                                        newCommentEl.className = "post-comment mb-3 position-relative";
                                        newCommentEl.innerHTML = `
                                            <div class="d-flex align-items-start">
                                                <img src="${data.student_photo ? `../../../backend/${data.student_photo}` : "../../assets/img/default-pic.jpg"}"
                                                    class="rounded-circle me-2" width="32" height="32" alt="User">
                                                <div>
                                                    <strong class="d-block">${data.student_name}</strong>
                                                    <span>${commentText}</span>
                                                </div>
                                            </div>
                                            <button data-id="${data.comment_id}" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 p-1 comment-delete-btn" title="Delete comment">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        `;

                                        viewCommentsContainer.prepend(newCommentEl);
                                        attachDeleteEvents();

                                        // update count
                                        const commentCountEl = document.getElementById("adminViewCommentCount");
                                        const tableStatus = document.getElementById("tableStatus");
                                        const countMatch = commentCountEl.innerText.match(/\d+/);
                                        let count = countMatch ? parseInt(countMatch[0]) : 0;
                                        commentCountEl.innerText = `Comments (${count + 1})`;
                                        commentBtn.innerHTML = `<i class="ri-chat-3-line"></i> ${count + 1}`;
                                        tableStatus.innerHTML = `
                                            <i class="ri-star-fill text-success me-1"></i> ${post.like_count}
                                            <i class="ri-chat-3-fill text-info ms-3 me-1"></i> ${count + 1}
                                        `
                                    } else {
                                        alert("Failed to add comment.");
                                    }
                                } catch (err) {
                                    console.error("Error adding comment:", err);
                                    alert("An error occurred while adding comment.");
                                }
                            };

                            // Initial render
                            renderComments();
                        });
                    }



                    if (archivePostBtn) {
                        archivePostBtn.addEventListener("click", function (e) {
                            const postId = e.target.dataset.id;
                            console.log("Restore clicked for post:", postId);
                        });
                    }
                    if (deletePostBtn) {
                        deletePostBtn.addEventListener("click", function (e) {
                            const postId = e.target.dataset.id;
                            console.log("Restore clicked for post:", postId);
                        });
                    }
                    if (restorePostBtn) {
                        restorePostBtn.addEventListener("click", function (e) {
                            const postId = e.target.dataset.id;
                            console.log("Restore clicked for post:", postId);
                        });
                    }


                })
            }
        })

    let tags = [];

    tagInput.addEventListener("keydown", (e) => {
        if (e.key === " " || e.key === "Enter") {
            e.preventDefault();
            const value = tagInput.value.trim();

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
                tagInput.value = "";
            }
        }
    });

    postForm.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const form = new FormData(postForm);

        tags.forEach((tag, index) => {
            form.append('tags[]', tag);
        });

        document.getElementById("uploadOverlay").classList.remove("d-none");
        document.getElementById("uploadLoader").classList.remove("d-none");
        document.getElementById("uploadSuccess").classList.add("d-none");

        document.getElementById("generalUploadError").classList.add("d-none");

        fetch("../../../backend/api/admin/add_post.php", {
            method: 'POST',
            body: form
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("uploadLoader").classList.add("d-none");
                    document.getElementById("uploadSuccess").classList.remove("d-none");
                    console.log(data);
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById("createPostModal"));
                        modal.hide();
                        document.getElementById("uploadOverlay").classList.add("d-none");

                        // Reset form and visuals
                        form.reset();
                        tags = [];
                        window.location.reload();
                    }, 1500);
                } else {
                    document.getElementById("uploadOverlay").classList.add("d-none");

                    if (data.errors) {

                        if (data.errors.title) {
                            document.getElementById("generalUploadError").innerText = data.errors.title;
                            document.getElementById("generalUploadError").classList.remove("d-none");
                        }
                        if (data.errors.content) {
                            document.getElementById("generalUploadError").innerText = data.errors.content;
                            document.getElementById("generalUploadError").classList.remove("d-none");
                        }
                        if (data.errors.image) {
                            document.getElementById("generalUploadError").innerText = data.errors.image;
                            document.getElementById("generalUploadError").classList.remove("d-none");
                        }

                        // Server or unknown errors
                        Object.entries(data.errors).forEach(([key, msg]) => {
                            if (!["title", "content", "image"].includes(key)) {
                                document.getElementById("generalUploadError").innerText = msg;
                                document.getElementById("generalUploadError").classList.remove("d-none");
                            }
                        });
                    }

                }
            })
    })


})