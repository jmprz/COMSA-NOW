// Unique namespace for our modal functionality
const comsaModalManager = (function() {
  // Check if modal should be shown
  function shouldShowModal() {
    return localStorage.getItem('comsaEventsModalDisabled') !== 'true';
  }
  
  // Initialize modal behavior
  function init() {
    if (shouldShowModal()) {
      const modalElement = document.getElementById('comsaEventsModal');
      const modal = new bootstrap.Modal(modalElement, {
        backdrop: 'static', // This prevents closing when clicking outside
        keyboard: false    // This prevents closing with ESC key
      });
      modal.show();
    }
  }
  
  return {
    init: init
  };
})();

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', comsaModalManager.init);