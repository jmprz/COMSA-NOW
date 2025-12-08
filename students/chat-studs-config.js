

    // WebSocket connection
    let socket = null;
    let currentChatUserId = null;

    // Initialize WebSocket connection
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

   
    function startChatWithUser(userId, userName) {
      currentChatUserId = userId;

   
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

     
      document.getElementById('messageInputContainer').style.display = 'block';
      document.getElementById('messageInput').disabled = false;
      document.getElementById('sendMessageBtn').disabled = false;

     
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
 