document.addEventListener("DOMContentLoaded", () => {
    const socket = new WebSocket("ws://localhost:8080");

    socket.onmessage = (event) => {
        let data;
        try {
            data = JSON.parse(event.data);
        } catch (e) {
            console.error("❌ Failed to parse message as JSON:", e);
            return;
        }

        console.log(data.type);

        if (data.type === "addPostComment") {
            const modal = document.getElementById("viewPostModal");
            if (!modal.classList.contains("show")) return;

            const openPostId = modal.dataset.postId;
            if (parseInt(openPostId) !== parseInt(data.postId)) return;

            // Insert comment in modal
            const viewCommentsContainer = document.getElementById("viewCommentsContainer");
            const newCommentEl = document.createElement("div");
            newCommentEl.className = "post-comment mb-3 position-relative";
            newCommentEl.innerHTML = `
                <div class="d-flex align-items-start">
                    <img src="${data.student_photo ? `../../../backend/${data.student_photo}` : "../../assets/img/default-pic.jpg"}"
                        class="rounded-circle me-2" width="32" height="32" alt="User">
                    <div>
                        <strong class="d-block">${data.student_name}</strong>
                        <span>${data.comment}</span>
                    </div>
                </div>
                <button data-id="${data.comment_id}" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 p-1 comment-delete-btn" title="Delete comment">
                    <i class="ri-delete-bin-line"></i>
                </button>
            `;
            viewCommentsContainer.prepend(newCommentEl);

            // 🔹 Update modal counter
            const commentCountEl = document.getElementById("adminViewCommentCount");
            const countMatch = commentCountEl.innerText.match(/\d+/);
            let count = countMatch ? parseInt(countMatch[0]) : 0;
            commentCountEl.innerText = `Comments (${count + 1})`;

            // 🔹 Update table counter directly (no global posts)
            const tableCounter = document.querySelector(
                `.post-stats[data-id="${data.postId}"] .comment-count`
            );
            if (tableCounter) {
                tableCounter.innerText = parseInt(tableCounter.innerText) + 1;
            }
        }

        if (data.type === "adminDeleteComment") {
            const modal = document.getElementById("viewPostModal");

            // Only update modal if it's open for the same post
            if (modal.classList.contains("show") && modal.dataset.postId === String(data.postId)) {
                // Remove the deleted comment element
                const commentEl = document.querySelector(
                    `.post-comment .comment-delete-btn[data-id="${data.commentId}"]`
                )?.closest(".post-comment");

                if (commentEl) {
                    commentEl.remove();
                }

                // Update modal counter
                const adminViewCommentCount = document.getElementById("adminViewCommentCount");
                const countMatch = adminViewCommentCount.innerText.match(/\d+/);
                let count = countMatch ? parseInt(countMatch[0]) : 0;
                adminViewCommentCount.innerText = `Comments (${Math.max(count - 1, 0)})`;

                // Update the comment button in modal
                const commentBtn = document.getElementById("adminViewComment");
                if (commentBtn) {
                    commentBtn.innerHTML = `<i class="ri-chat-3-line"></i> ${Math.max(count - 1, 0)}`;
                }
            }

            // Always update table counter
            const tableCommentCount = document.querySelector(
                `.post-stats[data-id="${data.postId}"] .comment-count`
            );
            if (tableCommentCount) {
                tableCommentCount.innerText = Math.max(parseInt(tableCommentCount.innerText) - 1, 0);
            }
        }

    }

    socket.onerror = (err) => {
        console.error("❌ WebSocket error", err);
    };

    document.getElementById("changeImageBtn").addEventListener("click", () => {
        document.getElementById("editImageUpload").click(); // open hidden file input
    });

    // Show preview when file selected
    document.getElementById("editImageUpload").addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (ev) => {
                document.getElementById("editImagePreview").src = ev.target.result; // update preview
            };
            reader.readAsDataURL(file);
        }
    });

    const postForm = document.getElementById('postForm');
    const tagInput = document.getElementById("postTags")
    const tagWrapper = document.getElementById("tagsWrapper");

    const tableHead = document.getElementById("tableHeadPost");
    const tableBody = document.getElementById("tableBodyPost");
    const table = document.getElementById("allPostsTable");

    const tagEditInput = document.getElementById("editPostTags");
    tagArray = document.getElementById("editTagsContainer");

    const editForm = document.getElementById("editPostForm");


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
                           <div class="post-stats d-flex align-items-center" data-id="${post.id}">
                            <i class="ri-star-fill text-success me-1"></i> <span class="like-count">${post.like_count}</span>
                            <i data-id="${post.id}" class="ri-chat-3-fill text-info ms-3 me-1"></i> <span class="comment-count">${post.comment_count}</span>
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

                            document.getElementById("editPostId").value = postId;
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
                            document.getElementById("viewPostModal").dataset.postId = postId;

                            const adminViewTagContainer = document.getElementById("adminViewTagContainer");
                            const viewCommentsContainer = document.getElementById("viewCommentsContainer");
                            const addCommentInput = document.getElementById("adminViewAddComment");
                            const addCommentBtn = document.getElementById("adminViewSubmitComment");
                            const adminViewCommentCount = document.getElementById("adminViewCommentCount");

                            // Populate post details (same as before)
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


                            async function renderComments() {
                                try {
                                    const res = await fetch(`../../../backend/api/admin/get_post_comments.php?post_id=${postId}`);
                                    const data = await res.json();

                                    viewCommentsContainer.innerHTML = "";

                                    if (data.success && data.comments.length > 0) {
                                        data.comments.forEach(comment => {
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

                                    // Update modal comment counter
                                    adminViewCommentCount.innerText = `Comments (${data.comments.length})`;
                                    commentBtn.innerHTML = `<i class="ri-chat-3-line"></i> ${data.comments.length}`;

                                    attachDeleteEvents();
                                } catch (err) {
                                    console.error("Failed to fetch comments:", err);
                                    viewCommentsContainer.innerHTML = `<p class="text-danger">Failed to load comments.</p>`;
                                }
                            }

                            function attachDeleteEvents() {
                                document.querySelectorAll(".comment-delete-btn").forEach(btn => {
                                    btn.addEventListener("click", async function () {
                                        const button = this;
                                        const commentWrapper = button.closest(".post-comment");
                                        const commentId = button.dataset.id;

                                        if (confirm("Are you sure you want to delete this comment?")) {
                                            try {
                                                const res = await fetch("../../../backend/api/admin/admin_delete_comment.php", {
                                                    method: "POST",
                                                    headers: { "Content-Type": "application/json" },
                                                    body: JSON.stringify({ id: commentId, postId: postId })
                                                });
                                                const data = await res.json();
                                                if (data.success) {
                                                    commentWrapper.remove();
                                                }
                                            } catch (err) {
                                                console.error("Error deleting comment:", err);
                                            }
                                        }
                                    });
                                });
                            }

                            // Add new comment
                            addCommentBtn.onclick = async () => {
                                const commentText = addCommentInput.value.trim();
                                if (!commentText) return alert("Please enter a comment.");

                                try {
                                    const res = await fetch("../../../backend/api/admin/admin_add_comment.php", {
                                        method: "POST",
                                        headers: { "Content-Type": "application/json" },
                                        body: JSON.stringify({ post_id: postId, comment: commentText })
                                    });
                                    const data = await res.json();
                                    if (data.success) {
                                        addCommentInput.value = "";
                                        renderComments(); // 🔥 re-fetch latest after add
                                    }
                                } catch (err) {
                                    console.error("Error adding comment:", err);
                                }
                            };

                            renderComments();
                        });
                    }


                    if (archivePostBtn) {
                        archivePostBtn.addEventListener("click", function (e) {
                            const postId = e.target.dataset.id;

                            if (confirm("Are you sure you want to archive this post?")) {
                                fetch("../../../backend/api/admin/admin_archive_post.php", {
                                    method: "POST",
                                    headers: { "Content-type": "application/json" },
                                    body: JSON.stringify({ postId })
                                })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            window.location.reload();
                                        } else {
                                            alert("❌ Failed to archive post: " + (data.message || ""));
                                        }
                                    })
                                    .catch(err => console.error("Error:", err));
                            }
                        });
                    }

                    if (deletePostBtn) {
                        deletePostBtn.addEventListener("click", function (e) {
                            const postId = e.target.dataset.id;

                            if (confirm("Are you sure you want to delete this post? This cannot be undone.")) {
                                fetch("../../../backend/api/admin/delete_post.php", {
                                    method: "POST",
                                    headers: { "Content-Type": "application/json" },
                                    body: JSON.stringify({ postId })
                                })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert("✅ Post deleted successfully");
                                            window.location.reload();
                                        } else {
                                            alert("❌ Failed to delete post: " + (data.message || ""));
                                        }
                                    })
                                    .catch(err => console.error("Error:", err));
                            }
                        });
                    }


                    if (restorePostBtn) {
                        restorePostBtn.addEventListener("click", function (e) {
                            const postId = e.target.dataset.id;
                            if (confirm("Do you really want to restore this post?")) {
                                fetch("../../../backend/api/admin/restore_post.php", {
                                    method: "POST",
                                    headers: { "Content-Type": "application/json" },
                                    body: JSON.stringify({ postId })
                                })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert("✅ Post restored successfully");
                                            window.location.reload();
                                        } else {
                                            alert("❌ Failed to restore post: " + (data.message || ""));
                                        }
                                    })
                                    .catch(err => console.error("Error:", err));
                            }
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
                        postForm.reset();
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

    editForm.addEventListener("submit", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const form = new FormData(editForm);

        document.getElementById("editPostUploadOverlay").classList.remove("d-none");
        document.getElementById("editPostUploadLoader").classList.remove("d-none");
        document.getElementById("editPostUploadSuccess").classList.add("d-none");

        document.getElementById("editPostGeneralUploadError").classList.add("d-none");

        editTags.forEach(tag => {
            form.append('tags[]', tag);
        });

        fetch("../../../backend/api/admin/admin_edit_post.php", {
            method: "POST",
            body: form
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    console.log("✅ Post edited:", data);
                    document.getElementById("editPostUploadLoader").classList.add("d-none");
                    document.getElementById("editPostUploadSuccess").classList.remove("d-none");
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    document.getElementById("editPostGeneralUploadError").classList.remove("d-none");
                    document.getElementById("editPostGeneralUploadError").innerText = data.errors || "Failed to edit post.";
                }
            })
            .catch(err => {
                console.error("❌ Error:", err);
                document.getElementById("editPostGeneralUploadError").classList.remove("d-none");
                document.getElementById("editPostGeneralUploadError").innerText = "Unexpected error while editing post.";
            });


    })

})