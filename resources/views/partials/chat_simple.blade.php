<!-- Floating Chat Button -->
<div id="floating-chat-btn" style="position: fixed !important; bottom: 30px !important; right: 30px !important; width: 80px !important; height: 80px !important; background: white !important; border-radius: 50% !important; z-index: 99999 !important; cursor: pointer !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important; border: none !important; transition: transform 0.3s ease !important;">
    <img src="{{ asset('images/mechanic_mascot.png') }}" alt="Speed Solution Chat" style="width: 70px !important; height: 70px !important; border-radius: 50% !important; object-fit: cover !important;">
</div>

<!-- Chat Container -->
<div id="chat-container" style="display: none !important; position: fixed !important; bottom: 120px !important; right: 30px !important; width: 380px !important; height: 500px !important; background: white !important; border-radius: 15px !important; box-shadow: 0 8px 25px rgba(0,0,0,0.2) !important; z-index: 99998 !important; flex-direction: column !important; overflow: hidden !important; border: 2px solid #CD0505 !important;">
    <!-- Header -->
    <div style="background: #CD0505 !important; color: white !important; padding: 20px !important; display: flex !important; justify-content: space-between !important; align-items: center !important;">
        <h3 style="margin: 0 !important; font-size: 18px !important;">Speed Solution Chat</h3>
        <button id="close-chat" style="background: none !important; border: none !important; color: white !important; font-size: 24px !important; cursor: pointer !important; width: 30px !important; height: 30px !important;">&times;</button>
    </div>
      <!-- Messages -->
    <div style="padding: 20px !important; flex: 1 !important; overflow-y: auto !important; background: #f8f9fa !important;">
        <div id="chat-messages" style="display: flex !important; flex-direction: column !important;">
            <div class="static-welcome" style="margin-bottom: 15px !important; padding: 12px 16px !important; border-radius: 18px !important; max-width: 80% !important; background: #CD0505 !important; color: white !important;">
                Halo! Selamat datang di Speed Solution. Ada yang bisa saya bantu?
            </div>
        </div>
    </div>
    
    <!-- Input -->
    <div style="display: flex !important; padding: 15px !important; border-top: 1px solid #e9ecef !important; background: white !important;">
        <input type="text" id="message-input" placeholder="Ketik pesan..." style="flex: 1 !important; border: 2px solid #e9ecef !important; border-radius: 25px !important; padding: 12px 18px !important; margin-right: 10px !important; outline: none !important;">
        <button id="send-message" style="background: #CD0505 !important; color: white !important; border: none !important; border-radius: 25px !important; padding: 12px 20px !important; cursor: pointer !important; font-weight: bold !important;">Kirim</button>    </div>
</div>

<style>
@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0; }
}
</style>

<script>
// Wait for page to load
window.addEventListener('load', function() {
    console.log('=== CHAT DEBUG START ===');
    
    // Wait a bit more to ensure everything is loaded
    setTimeout(function() {
        console.log('Initializing chat...');
        
        // Get elements
        var floatingBtn = document.getElementById('floating-chat-btn');
        var chatContainer = document.getElementById('chat-container');
        var closeBtn = document.getElementById('close-chat');
        var messageInput = document.getElementById('message-input');
        var sendBtn = document.getElementById('send-message');
        var chatMessages = document.getElementById('chat-messages');
        
        console.log('Chat elements check:', {
            floatingBtn: !!floatingBtn,
            chatContainer: !!chatContainer,
            closeBtn: !!closeBtn,
            messageInput: !!messageInput,
            sendBtn: !!sendBtn,
            chatMessages: !!chatMessages
        });
        
        if (!floatingBtn) {
            console.error('FLOATING BUTTON NOT FOUND!');
            return;
        }
        
        if (!chatContainer) {
            console.error('CHAT CONTAINER NOT FOUND!');
            return;
        }        // Show chat function
        function showChat() {
            console.log('=== SHOWING CHAT ===');
            try {
                // Force reset all styles
                chatContainer.style.display = 'flex';
                chatContainer.style.position = 'fixed';
                chatContainer.style.bottom = '120px';
                chatContainer.style.right = '30px';
                chatContainer.style.zIndex = '99998';
                chatContainer.style.flexDirection = 'column';
                chatContainer.style.overflow = 'hidden';
                
                console.log('Chat should be visible now');
                console.log('Chat container display:', chatContainer.style.display);
                console.log('Chat container computed display:', window.getComputedStyle(chatContainer).display);
                
                // Check if this is first time opening chat
                showWelcomeMessage();
                
            } catch (error) {
                console.error('Error showing chat:', error);
            }
        }
        
        // Hide chat function
        function hideChat() {
            console.log('=== HIDING CHAT ===');
            try {
                chatContainer.style.display = 'none';
                console.log('Chat hidden');
                console.log('Chat container display after hide:', chatContainer.style.display);
            } catch (error) {
                console.error('Error hiding chat:', error);
            }
        }          // Show welcome message with typing effect
        function showWelcomeMessage() {
            var hasShownWelcome = localStorage.getItem('chat_welcome_shown');
            
            // First, try to load chat history
            loadChatHistory().then(function(hasMessages) {
                if (!hasMessages && !hasShownWelcome) {
                    console.log('No history found, showing welcome message...');
                    
                    // Show typing indicator first
                    setTimeout(function() {
                        showTypingIndicator();
                        
                        // After 2 seconds, show welcome messages
                        setTimeout(function() {
                            hideTypingIndicator();
                            
                            var welcomeMessages = [
                                "Halo! 👋 Selamat datang di Speed Solution!",
                                "Saya siap membantu Anda dengan segala kebutuhan service motor.",
                                "Ada yang bisa saya bantu hari ini? 😊"
                            ];
                            
                            showMessagesWithDelay(welcomeMessages, 0);
                            
                            // Mark welcome as shown
                            localStorage.setItem('chat_welcome_shown', 'true');
                            
                        }, 2000);
                    }, 500);
                } else if (hasMessages) {
                    console.log('Chat history loaded successfully');
                }
            });
        }        // Load chat history from server
        function loadChatHistory() {
            return new Promise(function(resolve) {
                console.log('Loading chat history...');
                
                // First check if user is authenticated and get appropriate session
                checkAuthAndGetSession().then(function(sessionInfo) {
                    if (!sessionInfo || !sessionInfo.sessionId) {
                        console.log('No session available, no history to load');
                        resolve(false);
                        return;
                    }

                    var apiUrl;
                    if (sessionInfo.isAuthenticated) {
                        // For authenticated users, use user-history endpoint
                        apiUrl = '/api/chat/user-history';
                    } else {
                        // For guest users, use session-based endpoint
                        apiUrl = '/api/chat/session/' + sessionInfo.sessionId + '/messages';
                    }

                    console.log('Loading history from:', apiUrl);

                    fetch(apiUrl)
                        .then(function(response) {
                            if (!response.ok) {
                                throw new Error('Failed to load history');
                            }
                            return response.json();
                        })
                        .then(function(data) {
                            if (data.success && data.data && data.data.length > 0) {
                                console.log('Found chat history:', data.data.length + ' messages');
                                
                                // Clear existing messages
                                chatMessages.innerHTML = '';
                                
                                // Display each message
                                data.data.forEach(function(message) {
                                    addMessage(message.message, message.sender_type === 'user' ? 'sent' : 'received');
                                });
                                
                                resolve(true);
                            } else {
                                console.log('No chat history found');
                                resolve(false);
                            }
                        })
                        .catch(function(error) {
                            console.error('Error loading chat history:', error);
                            resolve(false);
                        });
                });
            });
        }

        // Check authentication status and get appropriate session
        function checkAuthAndGetSession() {
            return new Promise(function(resolve) {
                // First check if user is authenticated
                fetch('/api/auth/check')
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(authData) {
                        if (authData.authenticated) {
                            console.log('User is authenticated, getting user session');
                            // Get user session
                            fetch('/api/chat/user-session')
                                .then(function(response) {
                                    return response.json();
                                })
                                .then(function(sessionData) {
                                    if (sessionData.success) {
                                        resolve({
                                            isAuthenticated: true,
                                            sessionId: sessionData.session_id,
                                            hasHistory: sessionData.has_history
                                        });
                                    } else {
                                        resolve(null);
                                    }
                                })
                                .catch(function() {
                                    resolve(null);
                                });
                        } else {
                            console.log('User is guest, using local session');
                            // Guest user, use localStorage session
                            var sessionId = localStorage.getItem('chat_session_id');
                            if (!sessionId) {
                                sessionId = 'session-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
                                localStorage.setItem('chat_session_id', sessionId);
                            }
                            resolve({
                                isAuthenticated: false,
                                sessionId: sessionId,
                                hasHistory: false
                            });
                        }
                    })
                    .catch(function() {
                        console.log('Auth check failed, assuming guest');
                        // Assume guest if auth check fails
                        var sessionId = localStorage.getItem('chat_session_id');
                        if (!sessionId) {
                            sessionId = 'session-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
                            localStorage.setItem('chat_session_id', sessionId);
                        }
                        resolve({
                            isAuthenticated: false,
                            sessionId: sessionId,
                            hasHistory: false
                        });
                    });
            });
        }
        
        // Show typing indicator
        function showTypingIndicator() {
            if (chatMessages) {
                var typingDiv = document.createElement('div');
                typingDiv.id = 'typing-indicator';
                typingDiv.style.cssText = 'margin-bottom: 15px !important; padding: 12px 16px !important; border-radius: 18px !important; max-width: 80% !important; background: #CD0505 !important; color: white !important; margin-right: auto !important; word-wrap: break-word !important;';
                typingDiv.innerHTML = '<span style="animation: blink 1.4s infinite both;">Admin sedang mengetik</span><span style="animation: blink 1.4s infinite both; animation-delay: 0.2s;">.</span><span style="animation: blink 1.4s infinite both; animation-delay: 0.4s;">.</span><span style="animation: blink 1.4s infinite both; animation-delay: 0.6s;">.</span>';
                
                chatMessages.appendChild(typingDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }
        
        // Hide typing indicator
        function hideTypingIndicator() {
            var typingIndicator = document.getElementById('typing-indicator');
            if (typingIndicator) {
                typingIndicator.remove();
            }
        }
        
        // Show messages with delay for natural conversation feel
        function showMessagesWithDelay(messages, index) {
            if (index < messages.length) {
                showTypingIndicator();
                
                setTimeout(function() {
                    hideTypingIndicator();
                    addMessage(messages[index], 'received');
                    
                    // Show next message after delay
                    setTimeout(function() {
                        showMessagesWithDelay(messages, index + 1);
                    }, 1000);
                }, 1500);
            }
        }
        function addMessage(text, type) {
            console.log('Adding message:', text, 'Type:', type || 'sent');
            try {
                if (chatMessages) {
                    var msgDiv = document.createElement('div');
                    
                    if (type === 'received') {
                        msgDiv.style.cssText = 'margin-bottom: 15px !important; padding: 12px 16px !important; border-radius: 18px !important; max-width: 80% !important; background: #CD0505 !important; color: white !important; margin-right: auto !important; word-wrap: break-word !important;';
                    } else {
                        msgDiv.style.cssText = 'margin-bottom: 15px !important; padding: 12px 16px !important; border-radius: 18px !important; max-width: 80% !important; background: #e9ecef !important; color: #333 !important; margin-left: auto !important; word-wrap: break-word !important;';
                    }
                    
                    var now = new Date();
                    var timeStr = now.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
                    
                    msgDiv.innerHTML = text + '<div style="font-size: 0.7rem; opacity: 0.7; margin-top: 5px; text-align: ' + (type === 'received' ? 'left' : 'right') + ';">' + timeStr + '</div>';
                    
                    chatMessages.appendChild(msgDiv);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    console.log('Message added successfully');
                }
            } catch (error) {
                console.error('Error adding message:', error);
            }
        }        // Add click event to floating button
        if (floatingBtn) {
            // Add hover effects
            floatingBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
                this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.4)';
            });
            
            floatingBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.3)';
            });
            
            // Clear any existing event listeners
            floatingBtn.onclick = null;
            floatingBtn.removeEventListener('click', showChat);
            
            // Add single click event listener
            floatingBtn.addEventListener('click', function(e) {
                console.log('=== CHAT BUTTON CLICKED ===');
                e.preventDefault();
                e.stopPropagation();
                
                // Check current state and toggle
                var currentDisplay = window.getComputedStyle(chatContainer).display;
                console.log('Current chat display state:', currentDisplay);
                
                if (currentDisplay === 'none' || chatContainer.style.display === 'none') {
                    showChat();
                } else {
                    console.log('Chat already visible');
                }
            });
            
            console.log('Click listener added to floating button');
        }
        
        // Add click event to close button
        if (closeBtn) {
            // Clear any existing listeners
            closeBtn.onclick = null;
            
            closeBtn.addEventListener('click', function(e) {
                console.log('=== CLOSE BUTTON CLICKED ===');
                e.preventDefault();
                e.stopPropagation();
                hideChat();
            });
        }
          // Add click event to send button
        if (sendBtn) {
            sendBtn.addEventListener('click', function() {
                var text = messageInput.value.trim();
                if (text) {
                    // Add message to UI immediately
                    addMessage(text, 'sent');
                    messageInput.value = '';
                    
                    // Send to backend
                    sendMessageToBackend(text);
                }
            });
        }
        
        // Add enter key event to input
        if (messageInput) {
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    var text = messageInput.value.trim();
                    if (text) {
                        // Add message to UI immediately
                        addMessage(text, 'sent');
                        messageInput.value = '';
                        
                        // Send to backend
                        sendMessageToBackend(text);
                    }
                }
            });
        }
          // Send message to backend
        function sendMessageToBackend(message) {
            console.log('Sending message to backend:', message);
            
            // Get appropriate session ID
            checkAuthAndGetSession().then(function(sessionInfo) {
                if (!sessionInfo || !sessionInfo.sessionId) {
                    console.error('No session available');
                    addMessage('❌ Error: No session available', 'received');
                    return;
                }

                // Get CSRF token
                var token = document.querySelector('meta[name="csrf-token"]');
                if (!token) {
                    console.error('CSRF token not found');
                    return;
                }

                var formData = new FormData();
                formData.append('message', message);
                formData.append('session_id', sessionInfo.sessionId);
                formData.append('name', sessionInfo.isAuthenticated ? '' : 'Guest User');
                formData.append('_token', token.getAttribute('content'));

                console.log('Sending to /api/chat/send with session:', sessionInfo.sessionId);

                fetch('/api/chat/send', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);
                    return response.json();
                })
                .then(data => {
                    console.log('Backend response:', data);
                    if (data.success) {
                        console.log('Message sent successfully to backend');
                    } else {
                        console.error('Failed to send message:', data.message);
                        // Show error to user
                        addMessage('❌ Error: ' + data.message, 'received');
                    }
                })
                .catch(error => {
                    console.error('Error sending message to backend:', error);
                    // Show error to user
                    addMessage('❌ Network error: ' + error.message, 'received');
                });
            });
        }
        
        console.log('=== CHAT INITIALIZATION COMPLETE ===');
          // Test function - you can call this from console
        window.testChatShow = function() {
            console.log('Manual test: showing chat');
            showChat();
        };
        
        window.testChatHide = function() {
            console.log('Manual test: hiding chat');
            hideChat();
        };
        
        // Reset welcome message (for testing)
        window.resetWelcome = function() {
            localStorage.removeItem('chat_welcome_shown');
            console.log('Welcome message reset. Close and reopen chat to see welcome again.');
        };

        // Test load chat history (for testing)
        window.testLoadHistory = function() {
            console.log('Testing load chat history...');
            loadChatHistory().then(function(hasMessages) {
                console.log('Load history result:', hasMessages);
            });
        };

        // Clear chat messages (for testing)
        window.clearChatMessages = function() {
            if (chatMessages) {
                chatMessages.innerHTML = '';
                console.log('Chat messages cleared');
            }
        };

        // Show current session ID (for testing)
        window.getSessionId = function() {
            var sessionId = localStorage.getItem('chat_session_id');
            console.log('Current session ID:', sessionId);
            return sessionId;
        };

        // Force reload history (for testing)
        window.forceReloadHistory = function() {
            console.log('Force reloading chat history...');
            chatMessages.innerHTML = '';
            loadChatHistory().then(function(hasMessages) {
                console.log('Force reload result:', hasMessages);
            });
        };

        // Debug function to check chat state
        window.debugChat = function() {
            console.log('=== CHAT DEBUG INFO ===');
            console.log('chatContainer.style.display:', chatContainer.style.display);
            console.log('computed display:', window.getComputedStyle(chatContainer).display);
            console.log('chatInitialized:', window.chatInitialized);
        };
        
        // Mark as initialized
        window.chatInitialized = true;
        console.log('=== CHAT INITIALIZATION COMPLETE ===');
        
    }, 1000); // Wait 1 second
});

// Backup initialization if window.load doesn't work
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - backup chat init');
    setTimeout(function() {
        if (!window.chatInitialized) {
            console.log('Running backup chat initialization...');
            // Simple backup version
            var btn = document.getElementById('floating-chat-btn');
            var container = document.getElementById('chat-container');
            
            if (btn && container) {
                // Clear any existing listeners
                btn.onclick = null;
                
                btn.addEventListener('click', function(e) {
                    console.log('BACKUP: Chat button clicked');
                    e.preventDefault();
                    e.stopPropagation();
                    
                    var currentDisplay = window.getComputedStyle(container).display;
                    if (currentDisplay === 'none' || container.style.display === 'none') {
                        container.style.display = 'flex';
                        container.style.position = 'fixed';
                        container.style.bottom = '120px';
                        container.style.right = '30px';
                        container.style.zIndex = '99998';
                        container.style.flexDirection = 'column';
                        console.log('BACKUP: Chat shown');
                    }
                });
                
                // Add close button listener
                var closeBtn = document.getElementById('close-chat');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function() {
                        container.style.display = 'none';
                        console.log('BACKUP: Chat closed');
                    });
                }
                
                console.log('Backup chat initialized');
                window.chatInitialized = true;
            }
        }
    }, 2000);
});

console.log('Chat script loaded');
</script>
