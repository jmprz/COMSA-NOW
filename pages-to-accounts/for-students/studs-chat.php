<?php
require_once "../../../backend/config/session.php";
require_once '../../../backend/middleware/student_middleware.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>COMSA-NOW - Student Chat</title>
  <meta name="description" content="Chat with other students in real-time">
  <meta name="keywords" content="student chat, messaging, real-time communication">

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/favicon/site.webmanifest">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet" />
  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link rel="stylesheet" href="../../assets/css/chat-studs-design.css">
  <link rel="stylesheet" href="../../assets/css/search-profile-design.css">
  <link rel="stylesheet" href="../../assets/css/project-studs-design.css">  <!-- Also responsible for nav design-->
  <link rel="stylesheet" href="../../assets/css/dark-mode.css">
  <link rel="stylesheet" href="../../assets/css/student-chat.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="index-page">


  <!-- Main Content -->
  <div class="main-content d-flex justify-content-center">
    <div class="container-fluid">
      <div class="row">
        <!-- Side Navigation -->
        <div class="col-md-2 d-none d-lg-block bg-light min-vh-100">
          <div class="side-nav py-4 px-3 d-flex flex-column justify-content-between h-100">

            <!-- Side Nav Header -->
            <div>
              <div class="text-center mb-5 side-nav-header">
                <img src="../../assets/img/logo.png" class="img-fluid" alt="COMSA Logo">
                <h3 class="fw-bold">COMSA-NOW</h3>
              </div>

              <!-- Nav Menu -->
              <div class="side-nav-menu d-flex flex-column gap-3">
                <a href="../../pages-to-accounts/for-students/student-dashboard.php" class="btn text-start d-flex align-items-center gap-2">
                  <i class="ri-home-9-line"></i> <span>Home</span>
                </a>
                <a href="../../pages-to-accounts/for-students/project-studs.php" class="btn text-start d-flex align-items-center gap-2">
                  <i class="ri-shapes-line"></i> <span>Projects</span>
                </a>
                <a href="../../pages-to-accounts/for-students/studs-chat.php" class="btn text-start d-flex align-items-center gap-2 btn-active">
                  <i class="ri-chat-smile-3-line"></i> <span>Chat</span>
                </a>
                <a href="#" id="search-toggle" class="btn text-start d-flex align-items-center gap-2">
                  <i class="ri-search-line"></i> <span>Search</span>
                </a>
                <a href="../../pages-to-accounts/for-students/profile-studs.php" class="btn text-start d-flex align-items-center gap-2">
                  <i class="ri-user-line"></i> <span>Profile</span>
                </a>
                <a href="../../pages-to-accounts/for-students/settings-studs.php" class="btn text-start d-flex align-items-center gap-2">
                  <i class="ri-settings-line"></i> <span>Settings</span>
                </a>
              </div>

            </div>
            <!-- Side Nav Footer -->
            <div class="text-muted small text-center mt-4">
              Experimental Nav
            </div>
          </div>
        </div>

        <!-- Chat Column -->
        <div class="col-lg-10 col-md-12">
          <div class="chat-container">

            <!-- Mobile Only Header -->
            <div class="d-lg-none d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
              <div class="d-flex align-items-center">
                <h5 class="ms-2 mb-0 fw-bold">COMSA-NOW Chat</h5>
              </div>

              <div class="d-flex align-items-center gap-2">
                <!-- Search Button -->
                <button class="btn p-2" type="button" id="search-toggle">
                  <i class="ri-search-line fs-1"></i>
                </button>

                <!-- Profile Icon Button -->
                <button type="button" class="btn p-0 border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#profileModal">
                  <img src="../../assets/img/team/sampleTeam.jpg" class="rounded-circle" alt="Profile" style="width: 40px; height: 40px;">
                </button>
              </div>
            </div>

            <!-- Chat Interface -->
            <div class="chat-interface">
              <!-- Online Users Sidebar -->
              <div class="online-users-sidebar">
                <div class="chat-header">
                  <h4>Online Students</h4>
                  <div class="search-box">
                    <input type="text" id="userSearch" placeholder="Search students...">
                    <i class="ri-search-line"></i>
                  </div>
                </div>
                <div class="online-users-list" id="onlineUsersList">
                  <!-- Online users will be populated here -->
                  <div class="user-item loading">
                    <div class="spinner-border spinner-border-sm" role="status"></div>
                    <span>Loading users...</span>
                  </div>
                </div>
              </div>

              <!-- Chat Area -->
              <div class="chat-area">
                <div class="chat-header" id="currentChatHeader">
                  <div class="d-flex align-items-center">
                    <div class="user-avatar me-2">
                      <i class="ri-group-line"></i>
                    </div>
                    <div>
                      <h5>Select a user to start chatting</h5>
                      <span class="user-status">Click on a user from the list</span>
                    </div>
                  </div>
                </div>

                <div class="messages-container" id="messagesContainer">
                  <div class="welcome-message">
                    <i class="ri-chat-3-line"></i>
                    <h4>Welcome to COMSA-NOW Chat</h4>
                    <p>Select a student from the online users list to start a conversation</p>
                  </div>
                </div>

                <div class="message-input-container" id="messageInputContainer" style="display: none;">
                  <div class="message-input-wrapper">
                    <input type="text" id="messageInput" placeholder="Type your message here..." disabled>
                    <button id="sendMessageBtn" disabled>
                      <i class="ri-send-plane-fill"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Navigation Bar (for md and below) -->
      <nav class="d-lg-none fixed-bottom bg-light border-top">
        <div class="d-flex justify-content-around py-2">
          <a href="../../pages-to-accounts/for-students/student-dashboard.php" class="text-center mt-2">
            <i class="ri-home-9-line fs-1"></i>
          </a>
          <a href="../../pages-to-accounts/for-students/project-studs.php" class="text-center mt-2">
            <i class="ri-shapes-line fs-1"></i>
          </a>
          <a href="../../pages-to-accounts/for-students/studs-chat.php" class="text-center mt-2 btn-active-mobile">
            <i class="ri-chat-3-line fs-1"></i>
          </a>
          <a href="#" class="text-center mt-2">
            <i class="ri-notification-3-line fs-1"></i>
          </a>
          <a href="../../pages-to-accounts/for-students/settings-studs.php" class="text-center mt-2">
            <i class="ri-settings-line fs-1"></i>
          </a>
        </div>
      </nav>

      <!-- Search Modal -->
      <div class="search-popup" id="searchPopup">
        <div class="search-container">
          <button class="search-close-button" id="searchCloseButton">
            <i class="ri-close-line"></i>
          </button>
          <div class="search-input-container">
            <input type="text" placeholder="Search students by name, nickname, or student number..."
              class="search-input" id="searchInput">
            <button class="search-button" id="searchButton">
              <i class="ri-search-line"></i>
            </button>
          </div>
          <div class="search-results-container">
            <div class="search-results-header">
              <span>Search Results</span>
              <span class="search-results-count">0 results</span>
            </div>
            <div class="search-results-list" id="searchResultsList">
              <!-- Results will be populated here -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>
  <script src="../../assets/vendor/aos/aos.js"></script>
  <script src="../../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="../../assets/js/main.js"></script>
  <script src="../for-students/js/profile-search-studs.js" defer></script>

  <script>
    // Session data
    const studentId = <?php echo json_encode($_SESSION['user_id']); ?>;
    const currentStudentId = <?php echo json_encode($_SESSION['user_id']); ?>;
    const studentName = <?php echo json_encode($_SESSION['full_name']); ?>;

    // WebSocket connection
    let socket = null;
    let currentChatUserId = null;

    // Initialize WebSocket connection
// Replace the initWebSocket function in studs-chat.php
function initWebSocket() {
  try {
    // Connect to PHP WebSocket server
    socket = new WebSocket('ws://localhost:8080');
    
    socket.onopen = function(event) {
      console.log('WebSocket connection established');
      
      // Send authentication message
      const authMessage = {
        type: 'auth',
        userId: studentId,
        userName: studentName
      };
      socket.send(JSON.stringify(authMessage));
    };
    
    socket.onmessage = function(event) {
      try {
        const message = JSON.parse(event.data);
        handleWebSocketMessage(message);
      } catch (error) {
        console.error('Error parsing WebSocket message:', error);
      }
    };
    
    socket.onclose = function(event) {
      console.log('WebSocket connection closed');
      // Attempt to reconnect after 3 seconds
      setTimeout(initWebSocket, 3000);
    };
    
    socket.onerror = function(error) {
      console.error('WebSocket error:', error);
    };
  } catch (error) {
    console.error('Error initializing WebSocket:', error);
  }
}

// Add these helper functions to the JavaScript
function sendMessage() {
  const messageInput = document.getElementById('messageInput');
  const message = messageInput.value.trim();
  
  if (message && currentChatUserId && socket && socket.readyState === WebSocket.OPEN) {
    const messageData = {
      type: 'message',
      sender_id: studentId,
      receiver_id: currentChatUserId,
      content: message
    };
    
    socket.send(JSON.stringify(messageData));
    messageInput.value = '';
    
    // Display the message immediately in the UI (optimistic update)
    displayMessage({
      sender_id: studentId,
      content: message,
      timestamp: new Date().toISOString()
    });
  }
}

function requestMessageHistory(conversationId) {
  if (socket && socket.readyState === WebSocket.OPEN) {
    const historyRequest = {
      type: 'get_history',
      conversation_id: conversationId
    };
    socket.send(JSON.stringify(historyRequest));
  }
}

function sendTypingIndicator(isTyping) {
  if (currentChatUserId && socket && socket.readyState === WebSocket.OPEN) {
    const typingData = {
      type: 'typing',
      sender_id: studentId,
      receiver_id: currentChatUserId,
      is_typing: isTyping
    };
    socket.send(JSON.stringify(typingData));
  }
}

function sendReadReceipt(conversationId) {
  if (socket && socket.readyState === WebSocket.OPEN) {
    const readReceipt = {
      type: 'read_receipt',
      conversation_id: conversationId,
      user_id: studentId
    };
    socket.send(JSON.stringify(readReceipt));
  }
}

// Update the startChatWithUser function
function startChatWithUser(userId, userName) {
  currentChatUserId = userId;
  
  // Update chat header
  document.getElementById('currentChatHeader').innerHTML = `
    <div class="d-flex align-items-center">
      <div class="user-avatar me-2">
        <span>${userName.charAt(0).toUpperCase()}</span>
        <span class="status-indicator online"></span>
      </div>
      <div>
        <h5>${userName}</h5>
        <span class="user-status">Online</span>
      </div>
    </div>
  `;
  
  // Show message input
  document.getElementById('messageInputContainer').style.display = 'block';
  document.getElementById('messageInput').disabled = false;
  document.getElementById('sendMessageBtn').disabled = false;
  
  // Clear welcome message
  document.getElementById('messagesContainer').innerHTML = '<div class="text-center p-3">Loading messages...</div>';
  
  // In a real implementation, you would get the conversation ID first
  // For now, we'll assume it's created on first message
}

// Add typing indicator functionality
let typingTimer;
document.getElementById('messageInput').addEventListener('input', function() {
  // Send typing indicator
  sendTypingIndicator(true);
  
  // Clear previous timer
  clearTimeout(typingTimer);
  
  // Set timer to stop typing indicator after 1 second of inactivity
  typingTimer = setTimeout(function() {
    sendTypingIndicator(false);
  }, 1000);
});
    // Handle incoming WebSocket messages
    function handleWebSocketMessage(message) {
      switch (message.type) {
        case 'user_list':
          updateOnlineUsersList(message.users);
          break;
        case 'message':
          displayMessage(message);
          break;
        case 'message_history':
          displayMessageHistory(message.messages);
          break;
        case 'user_status':
          updateUserStatus(message.userId, message.status);
          break;
        case 'error':
          console.error('WebSocket error:', message.message);
          break;
        default:
          console.log('Unknown message type:', message.type);
      }
    }

    // Update online users list
    function updateOnlineUsersList(users) {
      const onlineUsersList = document.getElementById('onlineUsersList');

      // Filter out current user
      const otherUsers = users.filter(user => user.id !== studentId);

      if (otherUsers.length === 0) {
        onlineUsersList.innerHTML = `
          <div class="user-item empty">
            <i class="ri-user-search-line"></i>
            <span>No other users online</span>
          </div>
        `;
        return;
      }

      onlineUsersList.innerHTML = otherUsers.map(user => `
        <div class="user-item" data-user-id="${user.id}" data-user-name="${user.name}">
          <div class="user-avatar">
            ${user.avatar ? 
              `<img src="../../../backend/${user.avatar}" alt="${user.name}">` : 
              `<span>${user.name.charAt(0).toUpperCase()}</span>`
            }
            <span class="status-indicator ${user.status || 'online'}"></span>
          </div>
          <div class="user-info">
            <span class="user-name">${user.name}</span>
            <span class="user-status">${user.status || 'Online'}</span>
          </div>
        </div>
      `).join('');

     
      document.querySelectorAll('.user-item:not(.empty):not(.loading)').forEach(item => {
        item.addEventListener('click', function() {
          const userId = this.getAttribute('data-user-id');
          const userName = this.getAttribute('data-user-name');
          startChatWithUser(userId, userName);
        });
      });
    }

    // Start chat with a user
    function startChatWithUser(userId, userName) {
      currentChatUserId = userId;

      // Update chat header
      document.getElementById('currentChatHeader').innerHTML = `
        <div class="d-flex align-items-center">
          <div class="user-avatar me-2">
            <span>${userName.charAt(0).toUpperCase()}</span>
            <span class="status-indicator online"></span>
          </div>
          <div>
            <h5>${userName}</h5>
            <span class="user-status">Online</span>
          </div>
        </div>
      `;

      // Show message input
      document.getElementById('messageInputContainer').style.display = 'block';
      document.getElementById('messageInput').disabled = false;
      document.getElementById('sendMessageBtn').disabled = false;

      // Request message history
      if (socket && socket.readyState === WebSocket.OPEN) {
        const historyRequest = {
          type: 'get_history',
          userId: studentId,
          targetUserId: userId
        };
        socket.send(JSON.stringify(historyRequest));
      }

      // Clear welcome message
      document.getElementById('messagesContainer').innerHTML = '';
    }

    // Display message history
    function displayMessageHistory(messages) {
      const messagesContainer = document.getElementById('messagesContainer');

      if (messages.length === 0) {
        messagesContainer.innerHTML = `
          <div class="empty-chat">
            <i class="ri-chat-new-line"></i>
            <p>No messages yet. Start the conversation!</p>
          </div>
        `;
        return;
      }

      messagesContainer.innerHTML = messages.map(message => {
        const isOwnMessage = message.sender_id == studentId;
        return `
          <div class="message ${isOwnMessage ? 'own-message' : 'other-message'}">
            <div class="message-content">
              <p>${message.content}</p>
              <span class="message-time">${formatMessageTime(message.timestamp)}</span>
            </div>
          </div>
        `;
      }).join('');

      // Scroll to bottom
      messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Display a single message
    function displayMessage(message) {
      // Only display if it's for the current chat
      if (message.sender_id == currentChatUserId ||
        (message.sender_id == studentId && message.receiver_id == currentChatUserId)) {

        const messagesContainer = document.getElementById('messagesContainer');

        // Remove empty chat message if present
        if (messagesContainer.querySelector('.empty-chat')) {
          messagesContainer.innerHTML = '';
        }

        const isOwnMessage = message.sender_id == studentId;
        const messageElement = document.createElement('div');
        messageElement.className = `message ${isOwnMessage ? 'own-message' : 'other-message'}`;
        messageElement.innerHTML = `
          <div class="message-content">
            <p>${message.content}</p>
            <span class="message-time">${formatMessageTime(message.timestamp)}</span>
          </div>
        `;

        messagesContainer.appendChild(messageElement);

        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
      }
    }

    // Format message timestamp
    function formatMessageTime(timestamp) {
      const date = new Date(timestamp);
      return date.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit'
      });
    }

    // Update user status
    function updateUserStatus(userId, status) {
      if (userId === currentChatUserId) {
        const statusElement = document.querySelector('#currentChatHeader .user-status');
        if (statusElement) {
          statusElement.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        }
      }

      const userItem = document.querySelector(`.user-item[data-user-id="${userId}"]`);
      if (userItem) {
        const statusIndicator = userItem.querySelector('.status-indicator');
        if (statusIndicator) {
          statusIndicator.className = `status-indicator ${status}`;
        }

        const statusText = userItem.querySelector('.user-status');
        if (statusText) {
          statusText.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        }
      }
    }

    // Send message
    function sendMessage() {
      const messageInput = document.getElementById('messageInput');
      const message = messageInput.value.trim();

      if (message && currentChatUserId && socket && socket.readyState === WebSocket.OPEN) {
        const messageData = {
          type: 'message',
          sender_id: studentId,
          receiver_id: currentChatUserId,
          content: message,
          timestamp: new Date().toISOString()
        };

        socket.send(JSON.stringify(messageData));
        messageInput.value = '';
      }
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize WebSocket connection
      initWebSocket();

      // Send message on button click
      document.getElementById('sendMessageBtn').addEventListener('click', sendMessage);

      // Send message on Enter key
      document.getElementById('messageInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          sendMessage();
        }
      });

      // User search functionality
      document.getElementById('userSearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const userItems = document.querySelectorAll('.user-item');

        userItems.forEach(item => {
          const userName = item.getAttribute('data-user-name').toLowerCase();
          if (userName.includes(searchTerm)) {
            item.style.display = 'flex';
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  </script>
</body>

</html>