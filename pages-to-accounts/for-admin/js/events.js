document.addEventListener("DOMContentLoaded", () => {
    const eventForm = document.getElementById("eventForm");

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
});
