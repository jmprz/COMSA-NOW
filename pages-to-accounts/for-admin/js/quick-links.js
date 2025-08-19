document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById("quickLinkForm");
    const title = document.getElementById("linkTitle");
    const link = document.getElementById("linkUrl");
    const category = document.getElementById("linkCategory");
    const icon = document.getElementById("linkIcon");
    const table = document.getElementById("link-table");
    const tableHead = document.getElementById("link-table-head");
    const tableBody = document.getElementById("link-table-body");

    const editForm = document.getElementById("editQuickLinkForm");


    fetch("../../../backend/api/admin/get_all_quick_links.php")
        .then(res => res.json())
        .then(data => {

            if (data.links.length === 0) {
                tableHead.classList.add('d-none');
                tableBody.classList.add('d-none');
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

                data.links.forEach((link, index) => {
                    const newEl = document.createElement("tr");

                    let badgeClass = "";
                    switch (link.category.toLowerCase()) {
                        case "academic":
                            badgeClass = "bg-primary";
                            break;
                        case "support":
                            badgeClass = "bg-success";
                            break;
                        case "opportunity":
                            badgeClass = "bg-info";
                            break;
                        case "resource":
                            badgeClass = "bg-warning";
                            break;
                        default:
                            badgeClass = "bg-secondary";
                    }

                    newEl.innerHTML = `
                    <tr>
                        <td>${link.id}</td>
                        <td>${link.title}</td>
                        <td>${link.url}</td>
                        <td><span class="badge ${badgeClass}">${link.category}</span></td>
                        <td>
                            <button id="showEditBtn-${link.id}" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editQuickLinkModal"><i class="ri-edit-line"></i></button>
                            <button id="deleteLinkBtn-${link.id}" class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                        </td>
                    </tr>
                    `
                    tableBody.appendChild(newEl);

                    const showEditBtn = newEl.querySelector(`#showEditBtn-${link.id}`);
                    showEditBtn.addEventListener('click', () => {
                        document.getElementById("editLinkTitle").value = link.title;
                        document.getElementById("editLinkUrl").value = link.url;
                        document.getElementById("editLinkCategory").value = link.category.toLowerCase();
                        document.getElementById("editLinkIcon").value = link.remix_icon ?? "";
                        document.getElementById("editLinkId").value = link.id;
                    })

                    const deleteBtn = newEl.querySelector(`#deleteLinkBtn-${link.id}`);
                    deleteBtn.addEventListener("click", () => {
                        if (confirm(`Are you sure you want to delete "${link.title}"?`)) {
                            fetch("../../../backend/api/admin/delete_quick_link.php", {
                                method: "POST",
                                headers: { "Content-Type": "application/json" },
                                body: JSON.stringify({ id: link.id })
                            })
                                .then(res => res.json())
                                .then(result => {
                                    if (result.success) {
                                        newEl.remove(); // remove row from table without reload
                                    } else {
                                        alert(result.message || "Failed to delete link");
                                    }
                                })
                                .catch(err => console.error("Delete error:", err));
                        }
                    });

                })
            }
        })
    //this handles the editing of quick links
    editForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const linkId = document.getElementById("editLinkId").value;
        const title = document.getElementById("editLinkTitle").value;
        const url = document.getElementById("editLinkUrl").value;
        const category = document.getElementById("editLinkCategory").value;
        const icon = document.getElementById("editLinkIcon").value;

        const editFormdata = new FormData(editForm);

        console.log(linkId, title, url, category, icon);
        fetch("../../../backend/api/admin/edit_quick_link.php", {
            method: "POST",
            body: editFormdata
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("editUploadLoader").classList.add("d-none");
                    document.getElementById("editUploadSuccess").classList.remove("d-none");

                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById("editQuickLinkModal"));
                        modal.hide();
                        document.getElementById("editUploadOverlay").classList.add("d-none");

                        editForm.reset();
                        window.location.reload();
                    }, 1500);
                } else {
                    document.getElementById("editUploadOverlay").classList.add("d-none");
                    console.log("not nice")
                    if (data.errors) {
                        console.log(data.id, data.title, data.category, data.url, data.icon)

                        if (data.errors.empty_id) {
                            document.getElementById("editGeneralUploadError").innerText = data.errors.empty_id;
                            document.getElementById("editGeneralUploadError").classList.remove("d-none");
                        }

                        if (data.errors.empty_fields) {
                            document.getElementById("editGeneralUploadError").innerText = data.errors.empty_fields;
                            document.getElementById("editGeneralUploadError").classList.remove("d-none");
                        }

                        if (data.errors.invalid_url) {
                            document.getElementById("editGeneralUploadError").innerText = data.errors.invalid_url;
                            document.getElementById("editGeneralUploadError").classList.remove("d-none");
                        }

                        if (data.errors.invalid_category) {
                            document.getElementById("editGeneralUploadError").innerText = data.errors.invalid_category;
                            document.getElementById("editGeneralUploadError").classList.remove("d-none");
                        }

                        Object.entries(data.errors).forEach(([key, msg]) => {
                            if (!["empty_fields", "invalid_url", "invalid_category", "empty_id"].includes(key)) {
                                document.getElementById("editGeneralUploadError").innerText = msg;
                                document.getElementById("editGeneralUploadError").classList.remove("d-none");
                            }
                        });
                    }
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
            });
    })



    //this handles the submission of quick links
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("clicked")
        const formdata = new FormData(form);

        document.getElementById("uploadOverlay").classList.remove("d-none");
        document.getElementById("uploadLoader").classList.remove("d-none");
        document.getElementById("uploadSuccess").classList.add("d-none");

        document.getElementById("generalUploadError").classList.add("d-none");

        fetch("../../../backend/api/admin/add_quick_links.php", {
            credentials: 'include',
            method: 'POST',
            body: formdata
        })
            .then(async res => {
                const text = await res.text();
                console.log("Raw response:", text);

                try {
                    return JSON.parse(text);
                } catch (err) {
                    console.error("Invalid JSON:", err);
                    throw err;
                }
            })
            .then(response => {
                if (response.success) {
                    console.log("nicee")
                    document.getElementById("uploadLoader").classList.add("d-none");
                    document.getElementById("uploadSuccess").classList.remove("d-none");

                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById("addQuickLinkModal"));
                        modal.hide();
                        document.getElementById("uploadOverlay").classList.add("d-none");

                        form.reset();
                        title.innerHTML = "";
                        link.innerHTML = "";
                        category.innerHTML = "";
                        icon.innerHTML = "";
                        window.location.reload();
                    }, 1500);

                } else {
                    document.getElementById("uploadOverlay").classList.add("d-none");
                    console.log("not nice")
                    if (response.errors) {
                        if (response.errors.empty_fields) {
                            document.getElementById("generalUploadError").innerText = response.errors.empty_empty_fields;
                            document.getElementById("generalUploadError").classList.remove("d-none");
                        }

                        if (response.errors.invalid_url) {
                            document.getElementById("generalUploadError").innerText = response.errors.empty_invalid_url;
                            document.getElementById("generalUploadError").classList.remove("d-none");
                        }

                        Object.entries(response.errors).forEach(([key, msg]) => {
                            if (!["empty_fields", "invalid_url"].includes(key)) {
                                document.getElementById("generalUploadError").innerText = msg;
                                document.getElementById("generalUploadError").classList.remove("d-none");
                            }
                        });
                    }
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
            });
    })


})