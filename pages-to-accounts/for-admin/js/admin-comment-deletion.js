 document.addEventListener('DOMContentLoaded', function() {
      // Handle comment deletion
      document.querySelectorAll('.comment-delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
          const comment = this.closest('.post-comment');
          if (confirm('Are you sure you want to delete this comment?')) {
            comment.style.transition = 'opacity 0.3s';
            comment.style.opacity = '0';
            setTimeout(() => {
              comment.remove();
              // Here you would normally send a request to the server to delete the comment
            }, 300);
          }
        });
      });

      // Dark mode support for comments section
      const darkModeToggle = document.querySelector('.dark-mode-toggle');
      if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
          setTimeout(() => {
            const isDarkMode = document.body.classList.contains('dark-mode');
            const commentsContainer = document.querySelector('.comments-container');
            if (commentsContainer) {
              if (isDarkMode) {
                commentsContainer.style.scrollbarColor = '#7db832 #2a2a2a';
              } else {
                commentsContainer.style.scrollbarColor = '#7db832 #f1f1f1';
              }
            }
          }, 100);
        });
      }
    });