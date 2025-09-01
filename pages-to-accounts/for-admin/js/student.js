document.addEventListener("DOMContentLoaded", function (e) {

    const addStudentForm = document.getElementById("addStudentForm");

    // Initialize DataTable
    const table = $('#allStudentsTable').DataTable({
        lengthChange: true,
        pageLength: 10,
        info: true,
        searching: true,
        columns: [
            { data: "student_number" },
            {
                data: null,
                render: function (student) {
                    return `
                        <div class="d-flex align-items-center">
                          <img src="${student.profile_photo ? `../../../backend/${student.profile_photo}` : '../../assets/img/default-pic.jpg'}" class="student-avatar me-2">
                          <span>${student.name}</span>
                        </div>
                    `;
                }
            },
            { data: "email" },
            {
                data: null,
                orderable: false,
                render: function (student) {
                    return `
                        <div class="dropdown action-dropdown">
                          <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="ri-more-2-fill"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <button data-id="${student.id}" class="dropdown-item studentsViewBtn" data-bs-toggle="modal" data-bs-target="#viewStudentModal"><i class="ri-eye-line me-2"></i>View</button>
                            </li>
                            <li>
                              <button data-id="${student.id}" class="dropdown-item studentsEditBtn" data-bs-toggle="modal" data-bs-target="#editStudentModal"><i class="ri-edit-line me-2"></i>Edit</button>
                            </li> 
                            <li><hr class="dropdown-divider"></li>
                            <li>
                              <button data-id="${student.id}" class="dropdown-item text-danger studentsDeleteBtn"><i class="ri-delete-bin-line me-2"></i>Delete</button>
                            </li>
                          </ul>
                        </div>
                    `;
                }
            }
        ]
    });

    // Fetch and populate DataTable
    fetch("../../../backend/api/admin/get_all_students.php")
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                table.clear();
                table.rows.add(data.students); // <-- let DataTables handle rows
                table.draw();
            } else {
                console.error("Error:", data.message || "Failed to fetch students");
            }
        });

    document.getElementById("allStudentsTable").addEventListener("click", function (e) {
        
        if (e.target.closest(".studentsViewBtn")) {
            const id = e.target.closest(".studentsViewBtn").dataset.id;
            console.log("View student:", id);

            fetch("../../../backend/api/admin/view_student.php?id=" + id) // reuse view API to prefill
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Prefill edit form fields
                        document.getElementById("editStudentId").value = data.student.id;
                        document.getElementById("editStudentName").value = data.student.name;
                        document.getElementById("editStudentEmail").value = data.student.email;
                        document.getElementById("editStudentNumber").value = data.student.student_number;
                    }
                });

        }

        if (e.target.closest(".studentsEditBtn")) {
            const id = e.target.closest(".studentsEditBtn").dataset.id;
            console.log("Edit student:", id);
            // 👉 Add your fetch logic for edit here
        }

        if (e.target.closest(".studentsDeleteBtn")) {
            const id = e.target.closest(".studentsDeleteBtn").dataset.id;
            console.log("Delete student:", id);

            if (confirm("Are you sure you want to delete this student?")) {
                fetch("../../../backend/api/admin/delete_student.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert("Student deleted successfully!");
                            window.location.reload();
                        } else {
                            alert("Error deleting student: " + data.message);
                        }
                    });
            }
        }
    });

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
});

