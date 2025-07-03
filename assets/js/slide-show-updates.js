
// Unique namespace for our modal functionality
const comsaModalManager = (function() {
  // Check if modal should be shown
  function shouldShowModal() {
    return localStorage.getItem('comsaEventsModalDisabled') !== 'true';
  }
  
  // Set modal disabled flag
  function disableModal() {
    localStorage.setItem('comsaEventsModalDisabled', 'true');
  }
  
  // Initialize modal behavior
  function init() {
    if (shouldShowModal()) {
      const modal = new bootstrap.Modal(document.getElementById('comsaEventsModal'));
      modal.show();
      
      // Handle "Don't show again" checkbox
      const dontShowCheckbox = document.getElementById('comsaDontShowAgain');
      dontShowCheckbox.addEventListener('change', function() {
        if (this.checked) {
          disableModal();
        }
      });
      
      // Also disable if user closes modal without checking (optional)
      const modalElement = document.getElementById('comsaEventsModal');
      modalElement.addEventListener('hidden.bs.modal', function() {
        if (dontShowCheckbox.checked) {
          disableModal();
        }
      });
    }
  }
  
  return {
    init: init
  };
})();

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', comsaModalManager.init);