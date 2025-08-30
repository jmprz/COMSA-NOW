document.addEventListener("DOMContentLoaded", function (e) {

    addStudentForm = document.getElementById("addStudentForm");

    addStudentForm.addEventListener("submit", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const dataForm = new FormData(addStudentForm);

        document.getElementById("studentUploadOverlay").classList.remove("d-none");
        document.getElementById("studentUploadLoader").classList.remove("d-none");
        document.getElementById("studentUploadSuccess").classList.add("d-none");

        document.getElementById("studentGeneralUploadError").classList.add("d-none");

        fetch("../../../backend/api/admin/admin_add_student.php", {
            method: "POST",
            body: dataForm
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("studentUploadLoader").classList.add("d-none");
                    document.getElementById("studentUploadSuccess").classList.remove("d-none");
                    console.log(data);
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById("addStudentModal"));
                        modal.hide();
                        document.getElementById("studentUploadOverlay").classList.add("d-none");

                        // Reset form and visuals
                        addStudentForm.reset();
                        window.location.reload();
                    }, 1500);
                } else {
                    document.getElementById("studentUploadOverlay").classList.add("d-none");

                    if (data.errors) {

                        if (data.errors.first_name) {
                            document.getElementById("studentGeneralUploadError").innerText = data.errors.first_name;
                            document.getElementById("studentGeneralUploadError").classList.remove("d-none");
                        }
                        if (data.errors.last_name) {
                            document.getElementById("studentGeneralUploadError").innerText = data.errors.last_name;
                            document.getElementById("studentGeneralUploadError").classList.remove("d-none");
                        }
                        if (data.errors.email) {
                            document.getElementById("studentGeneralUploadError").innerText = data.errors.email;
                            document.getElementById("studentGeneralUploadError").classList.remove("d-none");
                        }

                        if (data.errors.id) {
                            document.getElementById("studentGeneralUploadError").innerText = data.errors.id;
                            document.getElementById("studentGeneralUploadError").classList.remove("d-none");
                        }

                        if (data.errors.general) {
                            document.getElementById("studentGeneralUploadError").innerText = data.errors.general;
                            document.getElementById("studentGeneralUploadError").classList.remove("d-none");
                        }

                        // Server or unknown errors
                        Object.entries(data.errors).forEach(([key, msg]) => {
                            if (!["first_name", "last_name", "email", "id"].includes(key)) {
                                document.getElementById("studentGeneralUploadError").innerText = msg;
                                document.getElementById("studentGeneralUploadError").classList.remove("d-none");
                            }
                        });
                    }
                }
            })
    })
})