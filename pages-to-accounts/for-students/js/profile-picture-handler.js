fetch("../../../backend/api/get_user_avatar.php")
  .then(res => res.json())
  .then(data => {
    const avatarImgs = document.querySelectorAll(".user-avatar"); // select all avatars
    const initialsDivs = document.querySelectorAll(".avatar-initials"); // select all initials divs

    if (data.success && data.filepath) {
      console.log("Image found:", data.filepath);

      // Show image for all avatar elements
      avatarImgs.forEach(img => {
        img.src = `../../../backend/${data.filepath}`;
        img.classList.remove("d-none");
      });

      // Hide initials everywhere
      initialsDivs.forEach(div => div.classList.add("d-none"));
    } else {
      console.log("No image found — using initials");
      const name = document.querySelector(".profile-info h4").textContent;
      const initials = getInitials(name);

      initialsDivs.forEach(div => {
        div.textContent = initials;
        div.classList.remove("d-none");
      });

      avatarImgs.forEach(img => img.classList.add("d-none"));
    }
  })
  .catch(err => console.error("Error fetching avatar:", err));

function getInitials(name) {
  const parts = name.trim().split(" ").filter(Boolean);
  return parts.length === 1
    ? parts[0][0].toUpperCase()
    : (parts[0][0] + parts[1][0]).toUpperCase();
}
