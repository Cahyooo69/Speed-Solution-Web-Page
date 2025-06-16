<!-- Floating Chat Button -->
<div class="floating-btn" id="floating-chat-btn" style="position: fixed; bottom: 30px; right: 30px; width: 80px; height: 80px; background: red; border-radius: 50%; z-index: 9999; cursor: pointer; display: flex; align-items: center; justify-content: center;">
    <span style="color: white; font-weight: bold;">CHAT</span>
</div>

<!-- Chat Container -->
<div class="chat-container" id="chat-container" style="display: none;">
    <div class="chat-header">
        <h3 id="chat-title">Speed Solution Konsultasi</h3>
        <button class="close-chat" id="close-chat">&times;</button>
    </div>
      @auth
        <!-- User Interface (All authenticated users use same interface) -->
        <div class="chat-body">
            <div class="chat-messages" id="chat-messages">
                <div class="chat-message message-received">
                    Halo! Selamat datang di Speed Solution. Ada yang bisa saya bantu dengan kendaraan Anda?
                </div>
            </div>
        </div>
        <div class="chat-input">
            <input type="text" id="message-input" placeholder="Ketik pesan Anda...">
            <button id="send-message">Kirim</button>
        </div>
    @else
    <!-- Guest User Interface -->
    <div class="chat-body">
        <div class="chat-messages" id="chat-messages">
            <div class="chat-message message-received">
                Halo! Selamat datang di Speed Solution. Ada yang bisa saya bantu dengan kendaraan Anda?
            </div>
        </div>
    </div>
    <div class="chat-input">
        <input type="text" id="message-input" placeholder="Ketik pesan Anda...">
        <button id="send-message">Kirim</button>
    </div>
    @endauth
</div>

<script>
// Global functions
function openChat() {
    console.log('openChat called via onclick');
    const chatContainer = document.getElementById('chat-container');
    if (chatContainer) {
        chatContainer.style.display = 'flex';
        // Load chat history when opening
        if (typeof loadChatHistory === 'function') {
            loadChatHistory();
        }
    }
}

function showChat() {
    console.log('showChat called');
    const chatContainer = document.getElementById('chat-container');
    if (chatContainer) {
        chatContainer.style.display = 'flex';
        // Load chat history when opening
        if (typeof loadChatHistory === 'function') {
            loadChatHistory();
        }
    }
}

function hideChat() {
    console.log('hideChat called');
    const chatContainer = document.getElementById('chat-container');
    if (chatContainer) {
        chatContainer.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Chat script loaded');
    
    // Common elements
    const floatingBtn = document.getElementById('floating-chat-btn');
    const chatContainer = document.getElementById('chat-container');
    const closeBtn = document.getElementById('close-chat');
    
    console.log('Floating button found:', floatingBtn);
    console.log('Chat container found:', chatContainer);
    console.log('Close button found:', closeBtn);
    
    // Add click listeners
    if (floatingBtn) {
        console.log('Adding click listener to floating button');
        floatingBtn.addEventListener('click', function(e) {
            console.log('Floating button clicked via event listener!', e);
            e.preventDefault();
            e.stopPropagation();
            showChat();
        });
    } else {
        console.error('Floating button not found!');
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', hideChat);
    }
    
    // Close chat when clicking outside
    document.addEventListener('click', function(e) {
        if (chatContainer && 
            chatContainer.style.display === 'flex' &&
            !chatContainer.contains(e.target) && 
            !floatingBtn.contains(e.target)) {
            hideChat();
        }
    });
    
    // Initialize user chat functions
    initUserChat();
});
        if (chatContainer && 
            chatContainer.style.display === 'flex' &&
            !chatContainer.contains(e.target) && 
            !floatingBtn.contains(e.target)) {
            hideChat();
        }
    });    // USER CHAT FUNCTIONS
    function initUserChat() {
        let chatSessionId = localStorage.getItem('chat_session_id');
        let userName = localStorage.getItem('chat_user_name');
        let currentUserId = localStorage.getItem('chat_user_id');
        let isLoadingHistory = false;
          // Check if user is authenticated and get user data        checkAuthenticatedUser().then(authUser => {
            if (authUser && authUser.name) {
                // Authenticated user
                userName = authUser.name;
                currentUserId = authUser.id.toString();
                localStorage.setItem('chat_user_name', userName);
                localStorage.setItem('chat_user_id', currentUserId);
                
                // For authenticated users, session_id is just for backend compatibility
                // The actual chat loading will be based on user_id
                if (!chatSessionId) {
                    chatSessionId = `user-${currentUserId}`;
                    localStorage.setItem('chat_session_id', chatSessionId);
                }
                
                console.log(`Authenticated user: ${userName} (ID: ${currentUserId})`);
            } else {
                // Guest user
                if (currentUserId) {
                    // Was authenticated before, now guest - clear data
                    localStorage.removeItem('chat_session_id');
                    localStorage.removeItem('chat_user_name');
                    localStorage.removeItem('chat_user_id');
                    chatSessionId = null;
                    userName = null;
                    currentUserId = null;
                    
                    // Clear chat messages in UI
                    const chatMessages = document.getElementById('chat-messages');
                    if (chatMessages) {
                        chatMessages.innerHTML = '<div class="chat-message message-received">Halo! Selamat datang di Speed Solution. Ada yang bisa saya bantu dengan kendaraan Anda?</div>';
                    }
                }
                
                // Generate guest session if needed
                if (!chatSessionId) {
                    generateSessionId();
                }
                
                console.log('Guest user - using session-based chat');
            }
        });
        // Generate session ID if not exists
        if (!chatSessionId) {
            generateSessionId();
        }
          async function generateUserSessionId(userId) {
            try {
                // For authenticated users, get existing session or create new one
                const response = await fetch('/api/chat/user-session');
                const data = await response.json();
                if (data.success) {
                    chatSessionId = data.session_id;
                    localStorage.setItem('chat_session_id', chatSessionId);
                    return data.has_history;
                } else {
                    // Fallback: create session with user ID prefix
                    chatSessionId = `user-${userId}-${Date.now()}`;
                    localStorage.setItem('chat_session_id', chatSessionId);
                    return false;
                }
            } catch (error) {
                console.error('Error getting user session:', error);
                chatSessionId = `user-${userId}-${Date.now()}`;
                localStorage.setItem('chat_session_id', chatSessionId);
                return false;
            }
        }
        
        const messageInput = document.getElementById('message-input');
        const sendBtn = document.getElementById('send-message');
        const chatMessages = document.getElementById('chat-messages');
        
        if (sendBtn) {
            sendBtn.addEventListener('click', sendMessage);
        }
        
        if (messageInput) {
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        }
        
        // Poll for new messages every 5 seconds when chat is open
        setInterval(() => {
            if (chatContainer.style.display === 'flex' && chatSessionId && !isLoadingHistory) {
                loadChatHistory();
            }        }, 5000);
        
        async function checkAuthenticatedUser() {
            try {
                const response = await fetch('/api/auth/check');
                const data = await response.json();
                if (data.success && data.data.isAuthenticated) {
                    return data.data.user;
                }
                return null;
            } catch (error) {
                console.error('Error checking authentication:', error);
                return null;
            }
        }
        
        async function generateSessionId() {
            try {
                const response = await fetch('/api/chat/session');
                const data = await response.json();
                if (data.success) {
                    chatSessionId = data.session_id;
                    localStorage.setItem('chat_session_id', chatSessionId);
                }
            } catch (error) {
                console.error('Error generating session ID:', error);
                chatSessionId = 'guest-' + Date.now();
                localStorage.setItem('chat_session_id', chatSessionId);
            }
        }
          async function loadChatHistory() {
            if (isLoadingHistory) return;
            
            isLoadingHistory = true;
            try {
                let response, data;
                
                // Check if user is authenticated
                const authUser = await checkAuthenticatedUser();
                
                if (authUser && authUser.id) {
                    // Authenticated user - load by user_id
                    response = await fetch('/api/chat/user-history');
                    data = await response.json();
                } else if (chatSessionId) {
                    // Guest user - load by session_id
                    response = await fetch(`/api/chat/session/${chatSessionId}/messages`);
                    data = await response.json();
                } else {
                    return; // No session available
                }
                
                if (data.success && data.data.length > 0) {
                    // Clear existing messages except welcome message
                    const welcomeMessage = chatMessages.querySelector('.chat-message');
                    chatMessages.innerHTML = '';
                    if (welcomeMessage && !data.data.some(msg => msg.message.includes('Selamat datang'))) {
                        chatMessages.appendChild(welcomeMessage);
                    }
                    
                    // Add history messages
                    data.data.forEach(message => {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `chat-message message-${message.sender_type === 'user' ? 'sent' : 'received'}`;
                        messageDiv.innerHTML = `
                            ${message.message}
                            <div class="message-time">${message.created_at}</div>
                        `;
                        chatMessages.appendChild(messageDiv);
                    });
                    
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            } catch (error) {
                console.error('Error loading chat history:', error);
            } finally {
                isLoadingHistory = false;
            }
        }async function sendMessage() {
            const message = messageInput.value.trim();
            if (message !== '' && chatSessionId) {
                // Ask for name if first message and user is not authenticated
                if (!userName) {
                    const authUser = await checkAuthenticatedUser();
                    if (authUser && authUser.name) {
                        userName = authUser.name;
                        const currentUserId = authUser.id.toString();
                        localStorage.setItem('chat_user_name', userName);
                        localStorage.setItem('chat_user_id', currentUserId);
                    } else {
                        userName = prompt('Silakan masukkan nama Anda:') || 'User';
                        localStorage.setItem('chat_user_name', userName);
                        // For guest users, remove user_id
                        localStorage.removeItem('chat_user_id');
                    }
                }

                // Add user message to UI immediately
                const userMessage = document.createElement('div');
                userMessage.className = 'chat-message message-sent';
                userMessage.innerHTML = `
                    ${message}
                    <div class="message-time">${new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}</div>
                `;
                chatMessages.appendChild(userMessage);

                // Clear input and scroll
                messageInput.value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;

                // Send to server
                try {
                    const response = await fetch('/api/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        },
                        body: JSON.stringify({
                            message: message,
                            session_id: chatSessionId,
                            name: userName
                        })
                    });

                    const data = await response.json();
                    
                    if (!data.success) {
                        console.error('Failed to send message:', data.message);
                        // Add error message
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'chat-message message-received error';
                        errorMessage.textContent = 'Maaf, pesan gagal terkirim. Silakan coba lagi.';
                        chatMessages.appendChild(errorMessage);
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
                } catch (error) {
                    console.error('Error sending message:', error);
                    // Add error message
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'chat-message message-received error';
                    errorMessage.textContent = 'Maaf, terjadi kesalahan. Silakan coba lagi.';
                    chatMessages.appendChild(errorMessage);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }
        }
          // Order service function (global)
        window.orderService = function(serviceName, price) {
            console.log('orderService called:', serviceName, price);
            showChat();
            
            setTimeout(() => {
                const serviceMessage = `Saya ingin memesan layanan ${serviceName}`;
                messageInput.value = serviceMessage;
                sendMessage();
            }, 500);
        };
        
        // Clear chat data function (global)
        window.clearChatData = function() {
            localStorage.removeItem('chat_session_id');
            localStorage.removeItem('chat_user_name');
            localStorage.removeItem('chat_user_id');
            chatSessionId = null;
            userName = null;
            
            // Clear chat UI
            const chatMessages = document.getElementById('chat-messages');
            if (chatMessages) {
                chatMessages.innerHTML = '<div class="chat-message message-received">Halo! Selamat datang di Speed Solution. Ada yang bisa saya bantu dengan kendaraan Anda?</div>';
            }
            
            // Generate new session
            generateSessionId();
        };
    }
});
</script>

<style>
.message-time {
    font-size: 0.7rem;
    color: #888;
    margin-top: 5px;
    text-align: right;
}

.message-sent .message-time {
    text-align: right;
}

.message-received .message-time {
    text-align: left;
}

.chat-message.error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}
</style>