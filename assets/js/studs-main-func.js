
document.addEventListener('DOMContentLoaded', function() {
  // Like button functionality
  document.querySelectorAll('.like-btn').forEach(button => {
    button.addEventListener('click', function() {
      const icon = this.querySelector('i');
      const isLiked = icon.classList.contains('bi-star-fill');
      
      if (isLiked) {
        icon.classList.remove('bi-star-fill');
        icon.classList.add('bi-star');
        this.classList.remove('active');
      } else {
        icon.classList.remove('bi-star');
        icon.classList.add('bi-star-fill');
        this.classList.add('active');
      }
    });
  });
  
  // Double click to like on post image
  document.querySelectorAll('.post-image').forEach(image => {
    image.addEventListener('dblclick', function() {
      const likeBtn = this.closest('.post-container').querySelector('.like-btn');
      const icon = likeBtn.querySelector('i');
      
      // Only trigger if not already liked
      if (!icon.classList.contains('bi-star-fill')) {
        icon.classList.remove('bi-star');
        icon.classList.add('bi-star-fill');
        likeBtn.classList.add('active');
      }
    });
  });
  
  // Comment button functionality - toggle comments section
  document.querySelectorAll('.comment-btn').forEach(button => {
    button.addEventListener('click', function() {
      const postId = this.getAttribute('data-post');
      const commentsSection = document.getElementById(`comments${postId}`);
      const addCommentSection = document.getElementById(`addComment${postId}`);
      
      // Toggle both comments and add comment sections
      commentsSection.classList.toggle('expanded');
      addCommentSection.classList.toggle('expanded');
      
      // Scroll to comments if expanding
      if (commentsSection.classList.contains('expanded')) {
        commentsSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }
    });
  });
  
  // Comment submit functionality
  document.querySelectorAll('.comment-submit').forEach(button => {
    button.addEventListener('click', function() {
      const postId = this.getAttribute('data-post');
      const commentInput = this.previousElementSibling;
      const commentsContainer = document.getElementById(`comments${postId}`);
      
      if (commentInput.value.trim().length > 0) {
        // Create new comment element
        const commentElement = document.createElement('div');
        commentElement.className = 'post-comment';
        commentElement.innerHTML = `
          <span class="post-comment-username">you</span>
          ${commentInput.value}
        `;
        
        // Add the new comment
        commentsContainer.appendChild(commentElement);
        
        // Clear input
        commentInput.value = '';
        
        // Ensure comments section stays expanded
        commentsContainer.classList.add('expanded');
      }
    });
  });
  
  // Press Enter to submit comment
  document.querySelectorAll('.comment-input').forEach(input => {
    input.addEventListener('keypress', function(e) {
      if (e.key === 'Enter' && this.value.trim().length > 0) {
        const postId = this.getAttribute('data-post');
        const submitBtn = document.querySelector(`.comment-submit[data-post="${postId}"]`);
        submitBtn.click();
      }
    });
  });
});







const postTypeHandler = (function() {
  function init() {
    document.querySelector('[href="#"] i.bi-patch-plus').closest('a').addEventListener('click', function(e) {
      e.preventDefault();
      const modal = new bootstrap.Modal(document.getElementById('postTypeModal'));
      modal.show();
    });

    document.querySelectorAll('.post-type-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const postType = this.dataset.postType;
        console.log('Selected post type:', postType);
        // Here you would handle the post type selection
        // For example: window.location.href = `/create-post?type=${postType}`;
        bootstrap.Modal.getInstance(document.getElementById('postTypeModal')).hide();
      });
    });
  }
  
  return { init };
})();

document.addEventListener('DOMContentLoaded', postTypeHandler.init);