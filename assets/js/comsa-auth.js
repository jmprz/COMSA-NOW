const comsaAuthSystem = (function () {
  // Private variables
  const loginModal = document.getElementById('comsaLoginModal');
  const forgotModal = document.getElementById('comsaForgotModal');
  const successModal = document.getElementById('comsaSuccessModal');
  const loginForm = document.getElementById('comsaLoginForm');
  const forgotForm = document.getElementById('comsaForgotForm');
  const showForgotModalBtn = document.getElementById('comsaShowForgotModal');
  const showLoginModalBtn = document.getElementById('comsaShowLoginModal');
  const loginButton = document.getElementById('loginButton');

  // Initialize the system
  function init() {
    // Password toggle functionality
    console.log("loginButton exists?", loginButton);

    const passwordToggle = loginForm.querySelector('.comsa-password-toggle');
    const passwordInput = document.getElementById('comsaLoginPassword');

    passwordToggle.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.querySelector('i').classList.toggle('bi-eye');
      this.querySelector('i').classList.toggle('bi-eye-slash');
    });

    // Login form submission
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault();
      e.stopPropagation();

      if (this.checkValidity()) {
        const submitBtn = this.querySelector('.comsa-auth-btn');
        const btnText = submitBtn.querySelector('.comsa-btn-text');
        const btnSpinner = submitBtn.querySelector('.comsa-btn-spinner');

        // Show loading state
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');
        submitBtn.disabled = true;

        const formData = new FormData(this);

        fetch("../backend/api/login.php", {
          method: "POST",
          body: formData
        })
          .then(res => res.json())
          .then(data => {

            const errorMessage = document.getElementById('errorMessage');

            errorMessage.textContent = '';

            if (data.success) {
              const loginModalInstance = bootstrap.Modal.getInstance(loginModal);
              loginModalInstance.hide();

              btnText.classList.remove('d-none');
              btnSpinner.classList.add('d-none');
              submitBtn.disabled = false;
              this.classList.remove('was-validated');
              this.reset();

              //redirect
              window.location.href = "/comsa/COMSA-NOW/pages-to-accounts/for-students/student-dashboard.php";
            } else {
              // const errorList = Object.values(data.errors).join("\n");
              // alert(errorList || 'Login failed');


              if (data.errors?.empty_input) {
                errorMessage.textContent = data.errors.empty_input;
              } else if (data.errors?.email) {
                errorMessage.textContent = data.errors.email;
              } else if (data.errors?.password) {
                errorMessage.textContent = data.errors.password;
              }

              btnText.classList.remove('d-none');
              btnSpinner.classList.add('d-none');
              submitBtn.disabled = false;
            }
          })
          .catch(async error => {
            const raw = await error?.response?.text?.();
            console.error('Raw error response:', raw);
            console.error('Login error:', error);
            alert('An error occurred. Please try again later.');
            btnText.classList.remove('d-none');
            btnSpinner.classList.add('d-none');
            submitBtn.disabled = false;
          });
      }

      this.classList.add('was-validated');
    }, false);

    // Forgot password form submission
    forgotForm.addEventListener('submit', function (e) {
      e.preventDefault();
      e.stopPropagation();

      if (this.checkValidity()) {
        const submitBtn = this.querySelector('.comsa-auth-btn');
        const btnText = submitBtn.querySelector('.comsa-btn-text');
        const btnSpinner = submitBtn.querySelector('.comsa-btn-spinner');

        // Show loading state
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');
        submitBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
          // Show success modal
          const forgotModalInstance = bootstrap.Modal.getInstance(forgotModal);
          forgotModalInstance.hide();

          const successModalInstance = new bootstrap.Modal(successModal);
          successModalInstance.show();

          // Reset form
          btnText.classList.remove('d-none');
          btnSpinner.classList.add('d-none');
          submitBtn.disabled = false;
          this.classList.remove('was-validated');
          this.reset();
        }, 1500);
      }

      this.classList.add('was-validated');
    }, false);

    // Toggle between login and forgot modals
    showForgotModalBtn.addEventListener('click', function (e) {
      e.preventDefault();
      const loginModalInstance = bootstrap.Modal.getInstance(loginModal);
      loginModalInstance.hide();

      const forgotModalInstance = new bootstrap.Modal(forgotModal);
      forgotModalInstance.show();
    });

    showLoginModalBtn.addEventListener('click', function (e) {
      e.preventDefault();
      const forgotModalInstance = bootstrap.Modal.getInstance(forgotModal);
      forgotModalInstance.hide();

      const loginModalInstance = new bootstrap.Modal(loginModal);
      loginModalInstance.show();
    });

    loginButton.addEventListener('click', async function (e) {
      e.preventDefault();


      console.log("clicked and working");
      try {
        const res = await fetch("../backend/api/check_session.php", {
          credentials: "include",
        });

        const data = await res.json();

        if (data.loggedIn) {
          window.location.href = "../comsa/COMSA-NOW/pages-to-accounts/for-students/student-dashboard.php";
        } else {
          const loginModal = new bootstrap.Modal(document.getElementById('comsaLoginModal'));
          loginModal.show();
        }
      } catch (err) {
        console.error("Session check failed", err);
      }
    })
  }

  // Public methods
  return {
    init: init,
    showLogin: function () {
      const modal = new bootstrap.Modal(loginModal);
      modal.show();
    },
    showForgot: function () {
      const modal = new bootstrap.Modal(forgotModal);
      modal.show();
    }
  };
})();

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', comsaAuthSystem.init);

// Example of how to trigger the modals from other elements
// document.querySelector('.login-trigger').addEventListener('click', function() {
//   comsaAuthSystem.showLogin();
// });

// document.querySelector('.forgot-trigger').addEventListener('click', function() {
//   comsaAuthSystem.showForgot();
// });
