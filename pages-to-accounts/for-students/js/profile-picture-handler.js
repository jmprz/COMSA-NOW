  
  fetch("../../../backend/api/get_user_avatar.php")
    .then(res => res.json())
    .then(data => {
      const avatarImg = document.getElementById("user-avatar");
      const initialsDiv = document.getElementById("avatar-initials");
      
      if (data.success && data.filepath) {
        console.log("hiiii")
        avatarImg.src = `../../../backend/${data.filepath}`;
        avatarImg.classList.remove("d-none");
        initialsDiv.classList.add("d-none");
      } else {
        console.log("hello")
        const name = document.querySelector(".profile-info h4").textContent;
        initialsDiv.textContent = getInitials(name);
        initialsDiv.classList.remove("d-none");
        avatarImg.classList.add("d-none");
      }

    });

  function getInitials(name) {
    const parts = name.trim().split(" ").filter(Boolean);
    return parts.length === 1
      ? parts[0][0].toUpperCase()
      : (parts[0][0] + parts[1][0]).toUpperCase();
  }