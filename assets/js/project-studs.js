
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





