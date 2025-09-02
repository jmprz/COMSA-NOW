// fetch-posts.js
document.addEventListener("DOMContentLoaded", function() {
    const postsContainer = document.querySelector('.posts-column');
    const socket = new WebSocket("ws://localhost:8080");
    
    // Fetch and display posts
    fetchPosts();
    
    // WebSocket for real-time updates
    socket.onmessage = function(event) {
        try {
            const data = JSON.parse(event.data);
            
            if (data.type === "newPost") {
                // Add new post to the top
                addPostToFeed(data.post);
            } else if (data.type === "postDeleted") {
                // Remove deleted post
                const postElement = document.querySelector(`[data-post-id="${data.postId}"]`);
                if (postElement) {
                    postElement.remove();
                }
            } else if (data.type === "postLiked") {
                // Update like count
                const likeCountElement = document.querySelector(`[data-post-id="${data.postId}"] .post-likes`);
                if (likeCountElement) {
                    likeCountElement.textContent = `${data.likeCount} likes`;
                }
            } else if (data.type === "addPostComment") {
                // Add new comment
                const commentsContainer = document.querySelector(`[data-post-id="${data.postId}"] .post-comments`);
                if (commentsContainer) {
                    const newComment = document.createElement('div');
                    newComment.className = 'post-comment';
                    newComment.innerHTML = `
                        <span class="post-comment-username">${data.student_name}</span>
                        ${data.comment}
                    `;
                    commentsContainer.appendChild(newComment);
                    
                    // Update comment count if needed
                    const commentCount = commentsContainer.querySelectorAll('.post-comment').length;
                    const commentBtn = document.querySelector(`[data-post-id="${data.postId}"] .comment-btn`);
                    if (commentBtn) {
                        commentBtn.innerHTML = `<i class="bi bi-chat-left"></i> ${commentCount}`;
                    }
                }
            }
        } catch (error) {
            console.error('Error processing WebSocket message:', error);
        }
    };
    
    socket.onerror = function(error) {
        console.error('WebSocket error:', error);
    };
    
    // Function to fetch posts from server
    function fetchPosts() {
        fetch('../../../backend/api/student/get_posts.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayPosts(data.posts);
                } else {
                    console.error('Failed to fetch posts:', data.message);
                    postsContainer.innerHTML = `
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle me-2"></i>
                            No posts available at the moment.
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error fetching posts:', error);
                postsContainer.innerHTML = `
                    <div class="alert alert-danger text-center">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Failed to load posts. Please try again later.
                    </div>
                `;
            });
    }
    
    // Function to display posts
    function displayPosts(posts) {
        if (posts.length === 0) {
            postsContainer.innerHTML = `
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    No posts available yet. Check back later!
                </div>
            `;
            return;
        }
        
        // Clear existing posts (except the first two example posts if they exist)
        const existingPosts = postsContainer.querySelectorAll('.post-container');
        if (existingPosts.length > 2) {
            existingPosts.forEach((post, index) => {
                if (index >= 2) post.remove(); // Keep first two example posts
            });
        }
        
        // Add new posts
        posts.forEach(post => {
            addPostToFeed(post);
        });
    }
    
    // Function to add a single post to the feed
    function addPostToFeed(post) {
        const postElement = document.createElement('div');
        postElement.className = 'post-container';
        postElement.setAttribute('data-post-id', post.id);
        
        // Format date
        const postDate = formatPostDate(post.created_at);
        
        postElement.innerHTML = `
            <div class="post-header">
                <img src="../../assets/img/team/sampleTeam.jpg" class="post-avatar" alt="Admin Avatar">
                <div class="d-flex row gy-0">
                    <p class="project-username">${post.admin_username || 'admin'}</p>
                    <p class="project-date">${postDate}</p>
                </div>
                <i class="bi bi-three-dots post-more"></i>
            </div>
            
            ${post.post_image ? `
                <img src="../../../backend/${post.post_image}" class="post-image" alt="Post Image" onerror="this.style.display='none'">
            ` : ''}
            
            <div class="post-actions">
                <button class="post-action like-btn" data-post="${post.id}" onclick="toggleLike(${post.id})">
                    <i class="bi bi-star${post.user_liked ? '-fill text-warning' : ''}"></i>
                </button>
                <button class="post-action comment-btn" data-post="${post.id}" onclick="focusCommentInput(${post.id})">
                    <i class="bi bi-chat-left"></i> ${post.comment_count || 0}
                </button>
            </div>
            
            <div class="post-likes">${post.like_count || 0} likes</div>
            
            <div class="post-caption">
                <span class="post-caption-username">${post.admin_username || 'admin'}</span>
                ${post.content}
            </div>
            
            ${post.tags && post.tags.length > 0 ? `
                <div class="post-tags">
                    ${post.tags.map(tag => `<span class="post-tag">#${tag}</span>`).join(' ')}
                </div>
            ` : ''}
            
            <div class="post-comments" id="comments${post.id}">
                ${post.comments && post.comments.length > 0 ? 
                    post.comments.map(comment => `
                        <div class="post-comment">
                            <span class="post-comment-username">${comment.student_name}</span>
                            ${comment.comment}
                        </div>
                    `).join('') : ''
                }
            </div>
            
            <div class="post-time">${formatTimeAgo(post.created_at)}</div>
            
            <div class="post-add-comment" id="addComment${post.id}">
                <input type="text" class="comment-input" placeholder="Add a comment..." data-post="${post.id}" 
                    onkeypress="if(event.key === 'Enter') addComment(${post.id})">
                <button class="comment-submit" data-post="${post.id}" onclick="addComment(${post.id})">Post</button>
            </div>
        `;
        
        // Insert at the top of the posts container (after any existing example posts)
        const firstPost = postsContainer.querySelector('.post-container');
        if (firstPost) {
            postsContainer.insertBefore(postElement, firstPost);
        } else {
            postsContainer.appendChild(postElement);
        }
    }
    
    // Function to format post date
    function formatPostDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric' 
        });
    }
    
    // Function to format time ago
    function formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);
        
        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
        if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 86400)} days ago`;
        
        return formatPostDate(dateString);
    }
});

// Global functions for post interactions
function toggleLike(postId) {
    fetch('../../../backend/api/student/toggle_like.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ post_id: postId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update like button and count
            const likeBtn = document.querySelector(`[data-post="${postId}"].like-btn`);
            const likeCount = document.querySelector(`[data-post-id="${postId}"] .post-likes`);
            
            if (likeBtn && likeCount) {
                likeBtn.innerHTML = `<i class="bi bi-star${data.liked ? '-fill text-warning' : ''}"></i>`;
                likeCount.textContent = `${data.like_count} likes`;
            }
        }
    })
    .catch(error => console.error('Error toggling like:', error));
}

function addComment(postId) {
    const commentInput = document.querySelector(`[data-post="${postId}"].comment-input`);
    const comment = commentInput.value.trim();
    
    if (!comment) return;
    
    fetch('../../../backend/api/student/add_comment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
            post_id: postId, 
            comment: comment 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Clear input
            commentInput.value = '';
            
            // Add new comment to the list
            const commentsContainer = document.getElementById(`comments${postId}`);
            const newComment = document.createElement('div');
            newComment.className = 'post-comment';
            newComment.innerHTML = `
                <span class="post-comment-username">${data.student_name}</span>
                ${comment}
            `;
            commentsContainer.appendChild(newComment);
            
            // Update comment count
            const commentBtn = document.querySelector(`[data-post="${postId}"].comment-btn`);
            if (commentBtn) {
                const commentCount = commentsContainer.querySelectorAll('.post-comment').length;
                commentBtn.innerHTML = `<i class="bi bi-chat-left"></i> ${commentCount}`;
            }
        }
    })
    .catch(error => console.error('Error adding comment:', error));
}

function focusCommentInput(postId) {
    const commentInput = document.querySelector(`[data-post="${postId}"].comment-input`);
    if (commentInput) {
        commentInput.focus();
    }
}