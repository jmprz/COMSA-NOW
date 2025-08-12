// Wait for DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
  // =============================================
  // DARK MODE FUNCTIONALITY
  // =============================================
  const darkModeToggle = document.getElementById("darkModeToggle");
  const body = document.body;

  // Function to set dark mode
  const setDarkMode = (enabled) => {
    if (enabled) {
      body.classList.add("dark-mode");
      localStorage.setItem("darkMode", "dark");
      darkModeToggle.checked = true;
      console.log("Dark mode enabled");
    } else {
      body.classList.remove("dark-mode");
      localStorage.setItem("darkMode", "light");
      darkModeToggle.checked = false;
      console.log("Dark mode disabled");
    }

    // Dispatch custom event for other components to listen to
    document.dispatchEvent(
      new CustomEvent("darkModeChange", {
        detail: { isDarkMode: enabled },
      })
    );
  };

  // Check for saved user preference or use system preference
  const initializeDarkMode = () => {
    try {
      const savedMode = localStorage.getItem("darkMode");
      const systemPrefersDark = window.matchMedia(
        "(prefers-color-scheme: dark)"
      ).matches;

      if (savedMode === "dark" || (!savedMode && systemPrefersDark)) {
        setDarkMode(true);
      } else {
        setDarkMode(false);
      }
    } catch (error) {
      console.error("Error initializing dark mode:", error);
      // Fallback to light mode if there's an error
      setDarkMode(false);
    }
  };

  // Initialize dark mode
  initializeDarkMode();

  // Listen for system preference changes
  window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", (e) => {
      if (!localStorage.getItem("darkMode")) {
        // Only auto-change if no explicit preference
        setDarkMode(e.matches);
      }
    });

  // Toggle dark mode
  if (darkModeToggle) {
    darkModeToggle.addEventListener("change", function () {
      setDarkMode(this.checked);
    });
  }

  // =============================================
  // PROFILE PICTURE MODAL FUNCTIONALITY
  // =============================================
  const initializeProfilePictureModal = () => {
    console.log("initializesss")

    function getInitials(name) {
      const parts = name.trim().split(" ").filter(Boolean);
      return parts.length === 1
        ? parts[0][0].toUpperCase()
        : (parts[0][0] + parts[1][0]).toUpperCase();
    }



    try {
      const profilePicModalEl = document.getElementById("profilePicModal");
      const profilePicUpload = document.getElementById("profilePicUpload");

      const profilePicInitial = document.getElementById("profileInitialsPreview")
      const profilePicPreview = document.getElementById("profilePicPreview");

      const removeProfilePic = document.getElementById("removeProfilePic");
      const saveProfilePic = document.getElementById("saveProfilePic");

      let hasProfileInDB = false;
      let removePhotoFlag = false;

      profilePicModalEl.addEventListener("show.bs.modal", () => {
        console.log("working")
        fetch("../../../backend/api/get_user_avatar.php")
          .then(res => res.json())
          .then(data => {
            console.log(data)
            if (data.success && data.filepath) {
              console.log(data.filepath)
              profilePicPreview.src = `../../../backend/${data.filepath}`;
              profilePicPreview.classList.remove("d-none");
              profilePicInitial.classList.add("d-none")
              hasProfileInDB = true;
            } else {
              fetch("../../../backend/api/get_initials.php")
                .then(res => res.json())
                .then(data => {
                  profilePicInitial.textContent = getInitials(data.name);
                  profilePicPreview.classList.add("d-none");
                  profilePicInitial.classList.remove("d-none")
                  hasProfileInDB = false;
                });
            }
          });
      });

      // Preview uploaded image
      profilePicUpload.addEventListener("change", e => {
        const file = e.target.files[0];
        if (file) {
          if (!["image/jpeg", "image/png", "image/gif"].includes(file.type)) {
            alert("Please select a valid image file (JPEG, PNG, GIF)");
            e.target.value = "";
            return;
          }
          if (file.size > 5 * 1024 * 1024) {
            alert("Image size must be less than 5MB");
            e.target.value = "";
            return;
          }
          const reader = new FileReader();
          reader.onload = ev => {
            profilePicPreview.src = ev.target.result;
            profilePicPreview.classList.remove("d-none");
            profilePicInitial.classList.add("d-none")
            removePhotoFlag = false;
          };
          reader.readAsDataURL(file);
        }
      });

      // Remove current profile picture
      removeProfilePic.addEventListener("click", () => {
        if (!hasProfileInDB) return; // Do nothing if already no profile photo
        profilePicPreview.classList.add("d-none");
        profilePicInitial.classList.remove("d-none")
        profilePicPreview.src = "";
        removePhotoFlag = true;
        profilePicUpload.value = "";
      });

      // Save profile picture
      saveProfilePic.addEventListener("click", () => {
        const formData = new FormData();
        if (removePhotoFlag) {
          formData.append("action", "remove");
        } else if (profilePicUpload.files.length > 0) {
          formData.append("action", "upload");
          formData.append("profile_photo", profilePicUpload.files[0]);
        } else {
          alert("No changes made.");
          return;
        }

        saveProfilePic.disabled = true;
        saveProfilePic.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';

        fetch("../../../backend/api/update_user_avatar.php", {
          method: "POST",
          body: formData
        })
          .then(res => res.json())
          .then(data => {
            saveProfilePic.disabled = false;
            saveProfilePic.textContent = "Save Changes";
            if (data.success) {
              alert("Profile picture updated successfully!");
              bootstrap.Modal.getInstance(profilePicModalEl).hide();
            } else {
              alert("Error: " + data.message);
            }
          })
          .catch(err => {
            console.error(err);
            alert("An error occurred while updating profile picture.");
          });
      });
    } catch (error) {
      console.error("Error initializing profile picture modal:", error);
    }
  };

  // =============================================
  // TOOLTIP INITIALIZATION
  // =============================================
  const initializeTooltips = () => {
    try {
      const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );
      tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl, {
          trigger: "hover focus",
        });
      });
    } catch (error) {
      console.error("Error initializing tooltips:", error);
    }
  };

  // =============================================
  // MODAL INITIALIZATION
  // =============================================
  const initializeModals = () => {
    try {
      // Initialize all modals with enhanced options
      const modals = document.querySelectorAll(".modal");
      modals.forEach((modal) => {
        new bootstrap.Modal(modal, {
          backdrop: "static",
          keyboard: false,
        });
      });

      // Add custom behavior to policy modals
      const policyModals = ["#privacyPolicyModal", "#termsModal"];
      policyModals.forEach((modalId) => {
        const modalEl = document.querySelector(modalId);
        if (modalEl) {
          modalEl.addEventListener("shown.bs.modal", function () {
            const policyContent = this.querySelector(".policy-content");
            if (policyContent) {
              policyContent.scrollTop = 0; // Reset scroll position
            }
          });
        }
      });
    } catch (error) {
      console.error("Error initializing modals:", error);
    }
  };

  // =============================================
  // ACCOUNT ACTIVITY TABLE ENHANCEMENTS
  // =============================================
  const enhanceActivityTable = () => {
    try {
      const activityTable = document.querySelector(".activity-table");
      if (activityTable) {
        // Make table rows interactive
        const rows = activityTable.querySelectorAll("tbody tr");
        rows.forEach((row) => {
          row.addEventListener("click", function () {
            rows.forEach((r) => r.classList.remove("table-active"));
            this.classList.add("table-active");
          });
        });
      }
    } catch (error) {
      console.error("Error enhancing activity table:", error);
    }
  };

  // =============================================
  // INITIALIZE ALL COMPONENTS
  // =============================================
  initializeProfilePictureModal();
  initializeTooltips();
  initializeModals();
  enhanceActivityTable();

  // Add resize observer for responsive adjustments
  const resizeObserver = new ResizeObserver((entries) => {
    // Handle responsive adjustments here if needed
  });

  resizeObserver.observe(document.body);

  // Cleanup on page unload
  window.addEventListener("beforeunload", function () {
    resizeObserver.disconnect();
  });
});
