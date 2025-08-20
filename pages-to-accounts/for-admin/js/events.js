document.addEventListener("DOMContentLoaded", () => {
    const eventForm = document.getElementById("eventForm");
    const tableHead = document.getElementById("events-table-head");
    const tableBody = document.getElementById("events-table-body");
    const table = document.getElementById("eventsTable");

    const editForm = document.getElementById("editEventForm");


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

    fetch("../../../backend/api/admin/get_all_events.php")
        .then(res => res.json())
        .then(data => {

            if (data.events.length === 0) {
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

                data.events.forEach(event => {
                    const newEl = document.createElement("tr");

                    let badgeClass = "";
                    switch (event.status.toLowerCase()) {
                        case "ended":
                            badgeClass = "bg-danger";
                            break;
                        case "active":
                            badgeClass = "bg-success";
                            break;
                        case "draft":
                            badgeClass = "bg-secondary";
                            break;
                        case "upcoming":
                            badgeClass = "bg-warning";
                            break;
                        default:
                            badgeClass = "bg-info";
                    }

                    newEl.innerHTML = `
                    <td>${event.id}</td>
                    <td>
                        <img src="../../../backend/${event.event_image}" class="img-thumbnail" width="80" alt="Event Image">
                    </td>
                    <td>${event.title}</td>
                    <td>${formatDateTime(event.start_date)}</td>
                    <td>${formatDateTime(event.end_date)}</td>
                    <td><span class="badge ${badgeClass}">${event.status}</span></td>
                    <td>
                        <button id="showEditBtn-${event.id}" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editEventModal"><i class="ri-edit-line"></i></button>
                        <button id="deleteEventBtn-${event.id}" class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                    </td>`

                    tableBody.appendChild(newEl);

                    const showEditBtn = newEl.querySelector(`#showEditBtn-${event.id}`);
                    showEditBtn.addEventListener('click', () => {
                        console.log(event.carousel_status)
                        document.getElementById("editEventId").value = event.id;
                        document.getElementById("editEventTitle").value = event.title;
                        document.getElementById("editEventStatus").value = event.status;
                        document.getElementById("editEventStartDate").value = event.start_date;
                        document.getElementById("editEventEndDate").value = event.end_date;
                        document.getElementById("editEventImagePreview").src = `../../../backend/${event.event_image}`;

                        // Checkbox for feature status
                        document.getElementById("editFeatureEvent").checked = (event.carousel_status === 1);
                    })

                    const deleteBtn = newEl.querySelector(`#deleteEventBtn-${event.id}`);
                    deleteBtn.addEventListener("click", () => {
                        if (confirm(`Are you sure you want to delete "${event.title}"?`)) {
                            fetch("../../../backend/api/admin/delete_event.php", {
                                method: "POST",
                                headers: { "Content-Type": "application/json" },
                                body: JSON.stringify({ id: event.id })
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

    //this handles the creation of events
    eventForm.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const formData = new FormData(eventForm);
        // Reset overlays
        document.getElementById("eventUploadOverlay").classList.remove("d-none");
        document.getElementById("eventUploadLoader").classList.remove("d-none");
        document.getElementById("eventUploadSuccess").classList.add("d-none");
        document.getElementById("eventGeneralUploadError").classList.add("d-none");

        fetch("../../../backend/api/admin/add_event.php", {
            credentials: "include",
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                document.getElementById("eventUploadLoader").classList.add("d-none");

                if (data.success) {
                    // Show success overlay
                    document.getElementById("eventUploadSuccess").classList.remove("d-none");

                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById("addEventModal"));
                        modal.hide();
                        document.getElementById("eventUploadOverlay").classList.add("d-none");

                        eventForm.reset();
                        window.location.reload();
                    }, 1500);

                } else {
                    // Handle errors from API
                    document.getElementById("eventUploadOverlay").classList.add("d-none");

                    if (data.errors) {
                        // Example: show inline validation messages
                        if (data.errors.title) {
                            document.getElementById("eventGeneralUploadError").innerText = data.errors.title;
                            document.getElementById("eventGeneralUploadError").classList.remove("d-none");
                        }
                        if (data.errors.status) {
                            document.getElementById("eventGeneralUploadError").innerText = data.errors.status;
                            document.getElementById("eventGeneralUploadError").classList.remove("d-none");

                        }
                        if (data.errors.startDate) {
                            document.getElementById("eventGeneralUploadError").innerText = data.errors.startDate;
                            document.getElementById("eventGeneralUploadError").classList.remove("d-none");
                        }
                        if (data.errors.endDate) {
                            document.getElementById("eventGeneralUploadError").innerText = data.errors.endDate;
                            document.getElementById("eventGeneralUploadError").classList.remove("d-none");
                        }
                        if (data.errors.image) {
                            document.getElementById("eventGeneralUploadError").innerText = data.errors.image;
                            document.getElementById("eventGeneralUploadError").classList.remove("d-none");
                        }
                        if (data.errors.general || data.errors.server) {
                            document.getElementById("eventGeneralUploadError").innerText = data.errors.general || data.errors.server;
                            document.getElementById("eventGeneralUploadError").classList.remove("d-none");
                        }

                        Object.entries(data.errors).forEach(([key, msg]) => {
                            if (!["title", "status", "startDate", "endDate", "image", "general", "server"].includes(key)) {
                                document.getElementById("eventGeneralUploadError").innerText = msg;
                                document.getElementById("eventGeneralUploadError").classList.remove("d-none");
                            }
                        });
                    } else {
                        // Fallback generic error
                        document.getElementById("eventGeneralUploadError").innerText = "Something went wrong. Please try again.";
                        document.getElementById("eventGeneralUploadError").classList.remove("d-none");
                    }
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
                document.getElementById("eventUploadOverlay").classList.add("d-none");
                document.getElementById("eventGeneralUploadError").innerText = "Network error. Please try again.";
                document.getElementById("eventGeneralUploadError").classList.remove("d-none");
            });
    });

    //this handle the editing of events
    editForm.addEventListener('submit', function (e) {
        e.preventDefault();

        document.getElementById("editEventUploadOverlay").classList.remove("d-none");
        document.getElementById("editEventUploadLoader").classList.remove("d-none");
        document.getElementById("editEventUploadSuccess").classList.add("d-none");

        document.getElementById("editEventGeneralUploadError").classList.add("d-none");

        // const eventTitle = document.getElementById("editEventTitle");
        // const eventStatus = document.getElementById("editEventStatus");
        // const eventStartDate = document.getElementById("editEventStartDate");
        // const eventEndDate = document.getElementById("editEventEndDate");
        // const eventImage = document.getElementById("editEventImage");
        // const eventFeatures = document.getElementById("editFeatureEvent");

        const editFormData = new FormData(editForm);

        fetch("../../../backend/api/admin/edit_event.php", {
            method: "POST",
            body: editFormData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("editEventUploadLoader").classList.add("d-none");
                    document.getElementById("editEventUploadSuccess").classList.remove("d-none");

                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById("editEventModal"));
                        modal.hide();
                        document.getElementById("editEventUploadOverlay").classList.add("d-none");

                        editForm.reset();
                        window.location.reload();
                    }, 1500);
                } else {
                    document.getElementById("editEventUploadOverlay").classList.add("d-none");
                    console.log("not nice")
                    if (data.errors) {

                        if (data.errors.empty_id) {
                            document.getElementById("editEventGeneralUploadError").innerText = data.errors.empty_id;
                            document.getElementById("editEventGeneralUploadError").classList.remove("d-none");
                        }

                        if (data.errors.empty_fields) {
                            document.getElementById("editEventGeneralUploadError").innerText = data.errors.empty_fields;
                            document.getElementById("editEventGeneralUploadError").classList.remove("d-none");
                        }

                        if (data.errors.invalid_url) {
                            document.getElementById("editEventGeneralUploadError").innerText = data.errors.invalid_url;
                            document.getElementById("editEventGeneralUploadError").classList.remove("d-none");
                        }

                        if (data.errors.invalid_category) {
                            document.getElementById("editEventGeneralUploadError").innerText = data.errors.invalid_category;
                            document.getElementById("editEventGeneralUploadError").classList.remove("d-none");
                        }

                        Object.entries(data.errors).forEach(([key, msg]) => {
                            if (!["empty_fields", "invalid_url", "invalid_category", "empty_id"].includes(key)) {
                                document.getElementById("editEventGeneralUploadError").innerText = msg;
                                document.getElementById("editEventGeneralUploadError").classList.remove("d-none");
                            }
                        });
                    }
                }
            })

    })
});
