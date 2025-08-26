document.addEventListener("DOMContentLoaded", () => {
    const postForm = document.getElementById('postForm');
    const tagInput = document.getElementById("postTags")
    const tagWrapper = document.getElementById("tagsWrapper");

    const tableHead = document.getElementById("tableHeadPost");
    const tableBody = document.getElementById("tableBodyPost")
    const table = document.getElementById("allPostsTable");

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
                            <div class="d-flex align-items-center">
                              <i class="ri-star-fill text-success me-1"></i> 1,243
                              <i class="ri-chat-3-fill text-info ms-3 me-1"></i> 56
                            </div>
                          </td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <button data-id="${post.id}" class="dropdown-item editPostBtn"  data-bs-toggle="modal" data-bs-target="#editPostModal">
                                        <i class="ri-edit-line me-2"></i>Edit
                                    </button>
                                </li>
                                <li>
                                    <button data-id="${post.id}" class="dropdown-item viewPostBtn"  data-bs-toggle="modal" data-bs-target="#viewPostModal">
                                        <i class="ri-eye-line me-2"></i>View
                                    </button>
                                </li>
                                <li>
                                    <button data-id="${post.id}" class="dropdown-item archivePostBtn" ><i class="ri-archive-line me-2"></i>Archive</button>
                                </li>
                                <li>
                                  <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <button data-id="${post.id}" class="dropdown-item text-danger deletePostBtn" ><i class="ri-delete-bin-line me-2"></i>Delete</button>
                                </li>
                              </ul>
                            </div>
                        </td>
                    `
                    tableBody.appendChild(newEl);
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