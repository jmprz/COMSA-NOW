
const uploadForm = document.getElementById("projectUploadForm");
const closeUpload = document.querySelectorAll(".close-uploadInfo");

const techInput = document.getElementById("projectTechnologies");
const tagWrapper = document.getElementById("tagsWrapper");

const projMemberInput = document.getElementById("projectTeam");
const tagMemberWrapper = document.getElementById("tagsMemberWrapper");

const uploadArea = document.getElementById("mediaUploadArea");
const uploadInput = document.getElementById("mediaUpload");
const mediaPreview = document.getElementById("mediaPreview");
const mediaCounter = document.getElementById("mediaCounter");

let members = [];
let tags = [];
let selectedFiles = [];

techInput.addEventListener("keydown", (e) => {
    if (e.key === " " || e.key === "Enter") {

        e.preventDefault();
        const value = techInput.value.trim();

        if (value !== "" && !tags.includes(value)) {

            //inser in array
            tags.push(value);
            console.log("Current tags:", tags);

            //new element
            const tag = document.createElement("span");
            tag.className = "badge bg-secondary px-2 py-1 rounded-pill d-flex align-items-center";
            tag.innerText = value;

            //close button
            const closeBtn = document.createElement("button");
            closeBtn.className = "btn-close btn-close-white btn-sm ms-2";
            closeBtn.type = "button";
            closeBtn.innerHTML = "&times;";
            closeBtn.onclick = () => {
                const index = tags.indexOf(value);
                if (index > -1) tags.splice(index, 1);
                console.log("Updated tags:", tags);

                //remove element in html
                tag.remove();
            }

            tag.appendChild(closeBtn);
            tagWrapper.appendChild(tag);
            techInput.value = "";

        }

    }
});

projMemberInput.addEventListener("keydown", (e) => {

    if (e.key === "Enter") {
        e.preventDefault();

        const value = projMemberInput.value.trim();

        if (value !== "" && !tags.includes(value)) {

            members.push(value);
            console.log("Current tags:", tags);

            const tag = document.createElement("span");
            tag.className = "badge bg-secondary px-2 py-1 rounded-pill d-flex align-items-center";
            tag.innerText = value;

            const closeBtn = document.createElement("button");
            closeBtn.className = "btn-close btn-close-white btn-sm ms-2";
            closeBtn.type = "button";
            closeBtn.innerHTML = "&times;";
            closeBtn.onclick = () => {
                const index = members.indexOf(value);
                if (index > -1) members.splice(index, 1);
                console.log("Updated tags:", members);

                //remove element in html
                tag.remove();
            }

            tag.appendChild(closeBtn);
            tagMemberWrapper.appendChild(tag);
            projMemberInput.value = "";
        }
    }
})

uploadArea.addEventListener("click", () => {
    uploadInput.click();
})

uploadInput.addEventListener("change", () => {
    const newFiles = Array.from(uploadInput.files);

    // Merge and limit to 8
    const availableSlots = 8 - selectedFiles.length;
    const filesToAdd = newFiles.slice(0, availableSlots);
    selectedFiles = [...selectedFiles, ...filesToAdd];

    renderPreview();

    uploadInput.value = "";
    console.log("Currently selected:", selectedFiles.map(f => f.name));

});

function renderPreview() {
    mediaPreview.innerHTML = "";

    let filesProcessed = 0;


    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = (e) => {
            const wrapper = document.createElement("div");
            wrapper.style.position = "relative";

            const img = document.createElement("img");
            img.src = e.target.result;
            img.className = "rounded";
            img.style.width = "100px";
            img.style.height = "auto";

            const removeBtn = document.createElement("button");
            removeBtn.innerHTML = "✖";
            removeBtn.type = "button";
            removeBtn.style.position = "absolute";
            removeBtn.style.top = "0";
            removeBtn.style.right = "0";
            removeBtn.style.background = "rgba(0,0,0,0.5)";
            removeBtn.style.color = "white";
            removeBtn.style.border = "none";
            removeBtn.style.borderRadius = "50%";
            removeBtn.style.cursor = "pointer";
            removeBtn.style.width = "20px";
            removeBtn.style.height = "20px";
            removeBtn.style.fontSize = "12px";
            removeBtn.title = "Remove";

            removeBtn.addEventListener("click", () => {
                selectedFiles.splice(index, 1); // remove from array
                renderPreview(); // re-render
            });

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            mediaPreview.appendChild(wrapper);

            filesProcessed++;

            // ✅ Only update counter after all files processed
            if (filesProcessed === selectedFiles.length) {
                mediaCounter.innerText = `${selectedFiles.length}/8 images selected`;
            }
        };

        reader.readAsDataURL(file);
    });

    if (selectedFiles.length === 0) {
        mediaCounter.innerText = "0/8 images selected";
    }
}

function showFieldError(fieldId) {
    const input = document.getElementById(fieldId);
    if (!input) return;

    input.classList.add("is-invalid");

    let feedback = document.createElement("div");
    feedback.className = "invalid-feedback";
    feedback.innerText = "This field is required.";
    if (!input.nextElementSibling || !input.nextElementSibling.classList.contains("invalid-feedback")) {
        input.parentNode.appendChild(feedback);
    }
}

function clearFieldErrors() {
    document.querySelectorAll(".is-invalid").forEach(el => el.classList.remove("is-invalid"));
    document.querySelectorAll(".invalid-feedback").forEach(el => el.remove());
}

closeUpload.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        e.preventDefault();

        uploadForm.reset();

        tags = [];
        members = [];
        selectedFiles = [];

        tagWrapper.innerHTML = "";
        tagMemberWrapper.innerHTML = "";
        mediaPreview.innerHTML = "";

        mediaCounter.textContent = "0/8 images selected";
        console.log("Form and arrays cleared");
    })

})

uploadForm.addEventListener("submit", function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (this.checkValidity()) {
        const formData = new FormData();

        formData.append("projectTitle", document.getElementById("projectTitle").value);
        formData.append("projectType", document.getElementById("projectType").value);
        formData.append("projectDescription", document.getElementById("projectDescription").value);
        formData.append("downloadLink", document.getElementById("downloadLink").value);
        formData.append("githubLink", document.getElementById("githubLink").value);
        formData.append("liveLink", document.getElementById("liveLink").value);

        tags.forEach((tag, index) => {
            formData.append('tags[]', tag);
        })
        members.forEach((member, index) => {
            formData.append('members[]', member);
        })
        selectedFiles.forEach((file, index) => {
            formData.append('selectedFiles[]', file);
        })

        document.getElementById("uploadOverlay").classList.remove("d-none");
        document.getElementById("uploadLoader").classList.remove("d-none");
        document.getElementById("uploadSuccess").classList.add("d-none");

        clearFieldErrors();
        document.getElementById("generalUploadError").classList.add("d-none");

        fetch("../../backend/api/student_upload_proj.php", {
            method: "POST",
            body: formData,
        })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    document.getElementById("uploadLoader").classList.add("d-none");
                    document.getElementById("uploadSuccess").classList.remove("d-none");

                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById("projectUploadModal"));
                        modal.hide();
                        document.getElementById("uploadOverlay").classList.add("d-none");

                        // Reset form and visuals
                        uploadForm.reset();
                        selectedFiles = [];
                        tags = [];
                        members = [];
                        tagWrapper.innerHTML = "";
                        tagMemberWrapper.innerHTML = "";
                        mediaPreview.innerHTML = "";
                        mediaCounter.innerText = "0/8 images selected";
                    }, 1500);
                } else {
                    // Hide overlay
                    document.getElementById("uploadOverlay").classList.add("d-none");

                    if (response.errors) {
                        if (response.errors.empty_input) {
                            showFieldError("projectTitle");
                            showFieldError("projectType");
                            showFieldError("projectDescription");
                        }

                        if (response.errors.empty_images) {
                            document.getElementById("generalUploadError").innerText = response.errors.empty_images;
                            document.getElementById("generalUploadError").classList.remove("d-none");
                        }

                        // Server or unknown errors
                        Object.entries(response.errors).forEach(([key, msg]) => {
                            if (!["empty_input", "empty_images"].includes(key)) {
                                document.getElementById("generalUploadError").innerText = msg;
                                document.getElementById("generalUploadError").classList.remove("d-none");
                            }
                        });
                    }
                }
            })
            .catch(err => {
                console.error("Upload failed:", err);
                document.getElementById("uploadOverlay").classList.add("d-none");
                document.getElementById("generalUploadError").innerText = "An unexpected error occurred.";
                document.getElementById("generalUploadError").classList.remove("d-none");
            });
    }
})




