// Modal functionality for vanilla JS modals
document.addEventListener('DOMContentLoaded', function() {
  // Get all modal triggers
  const modalTriggers = document.querySelectorAll('[data-modal-trigger]');
  
  // Initialize each modal trigger
  modalTriggers.forEach(trigger => {
    const modalId = trigger.getAttribute('data-modal-trigger');
    const modal = document.getElementById(modalId);
    
    if (!modal) return;
    
    // Open modal when trigger is clicked
    trigger.addEventListener('click', function() {
      modal.style.display = 'block';
      document.body.classList.add('overflow-y-hidden');
    });
    
    // Close modal when clicking on backdrop or close button
    modal.querySelectorAll('.modal-backdrop, .modal-close-btn').forEach(element => {
      element.addEventListener('click', function() {
        modal.style.display = 'none';
        document.body.classList.remove('overflow-y-hidden');
      });
    });
    
    // Prevent closing when clicking inside the modal content
    modal.querySelector('.modal-content').addEventListener('click', function(e) {
      e.stopPropagation();
    });
  });
  
  // Handle Alpine.js modal event compatibility
  document.addEventListener('open-modal', function(e) {
    const modalId = e.detail;
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.style.display = 'block';
      document.body.classList.add('overflow-y-hidden');
    }
  });
  
  // Close modal with escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      const openModals = document.querySelectorAll('.modal-container[style="display: block;"]');
      openModals.forEach(modal => {
        modal.style.display = 'none';
        document.body.classList.remove('overflow-y-hidden');
      });
    }
  });
});