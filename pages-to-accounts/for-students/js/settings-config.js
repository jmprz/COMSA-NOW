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
    try {
      const profilePicModal = new bootstrap.Modal("#profilePicModal");
      const profilePicUpload = document.getElementById("profilePicUpload");
      const profilePicPreview = document.getElementById("profilePicPreview");
      const removeProfilePic = document.getElementById("removeProfilePic");
      const saveProfilePic = document.getElementById("saveProfilePic");

      if (!profilePicUpload || !profilePicPreview) return;

      // Preview uploaded image
      profilePicUpload.addEventListener("change", function (e) {
        const file = e.target.files[0];
        if (file) {
          // Validate file type and size
          const validTypes = ["image/jpeg", "image/png", "image/gif"];
          const maxSize = 5 * 1024 * 1024; // 5MB

          if (!validTypes.includes(file.type)) {
            alert("Please select a valid image file (JPEG, PNG, GIF)");
            this.value = "";
            return;
          }

          if (file.size > maxSize) {
            alert("Image size must be less than 5MB");
            this.value = "";
            return;
          }

          const reader = new FileReader();
          reader.onloadstart = () => {
            // Show loading indicator
          };
          reader.onload = (event) => {
            profilePicPreview.src = event.target.result;
          };
          reader.onerror = () => {
            alert("Error reading image file");
            //should display the default avatar
          };
          reader.readAsDataURL(file);
        }
      });

      // Remove current profile picture
      if (removeProfilePic) {
        removeProfilePic.addEventListener("click", function () {
          profilePicPreview.src = "../../../assets/img/default-profile.png";
          profilePicUpload.value = "";
        });
      }

      // Save profile picture
      if (saveProfilePic) {
        saveProfilePic.addEventListener("click", function () {
          // Simulate upload delay
          this.disabled = true;
          this.innerHTML =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';

          // In a real app, you would upload to server here
          setTimeout(() => {
            // Show success message with Toast
            const toastHTML = `
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                  <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-success text-white">
                      <strong class="me-auto">Success</strong>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                      Profile picture updated successfully!
                    </div>
                  </div>
                </div>
              `;

            document.body.insertAdjacentHTML("beforeend", toastHTML);

            // Remove toast after 3 seconds
            setTimeout(() => {
              const toast = document.querySelector(".toast");
              if (toast) {
                toast.classList.remove("show");
                setTimeout(() => toast.remove(), 300);
              }
            }, 3000);

            // Reset button and close modal
            this.disabled = false;
            this.textContent = "Save Changes";
            profilePicModal.hide();
          }, 1500);
        });
      }
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
