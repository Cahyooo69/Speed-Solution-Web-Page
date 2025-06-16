<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Chat Test (Logged In)</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        button { padding: 10px 15px; margin: 5px; cursor: pointer; }
        #results { margin: 20px 0; padding: 15px; background: #f5f5f5; }
        .message { 
            margin: 10px 0; 
            padding: 10px; 
            border-radius: 10px; 
            max-width: 80%;
        }
        .sent { 
            background: #007bff; 
            color: white; 
            margin-left: auto; 
            text-align: right;
        }
        .received { 
            background: #CD0505; 
            color: white; 
        }
        .auth-info {
            background: #e8f5e8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>User Chat Test (Logged In)</h1>
    
    <div class="auth-info" id="authInfo">
        <strong>Loading authentication info...</strong>
    </div>
    
    <div class="test-section">
        <h3>1. Send User Message</h3>
        <input type="text" id="testMessageInput" placeholder="Your message..." value="Hello, I need help with my motorcycle service">
        <button onclick="sendUserMessage()">Send Message</button>
    </div>
    
    <div class="test-section">
        <h3>2. Load User Chat History</h3>
        <button onclick="loadUserHistory()">Load My Chat History</button>
        <button onclick="clearMessages()">Clear Messages</button>
        <button onclick="checkAuthStatus()">Check Auth Status</button>
    </div>
    
    <div class="test-section">
        <h3>3. My Chat History</h3>
        <div id="messages-container" style="border: 1px solid #ccc; padding: 10px; min-height: 200px; background: white;">
            <p style="color: #666;">Your chat history will appear here...</p>
        </div>
    </div>
    
    <div id="results">
        <h4>Test Results:</h4>
        <div id="output"></div>
    </div>

    <script>
        let userSessionId = null;
        let isAuthenticated = false;

        function log(message) {
            const output = document.getElementById('output');
            output.innerHTML += '<div>' + new Date().toLocaleTimeString() + ': ' + message + '</div>';
            console.log(message);
        }

        function checkAuthStatus() {
            log('Checking authentication status...');
            
            fetch('/api/auth/check')
                .then(response => response.json())
                .then(data => {
                    isAuthenticated = data.authenticated;
                    const authInfo = document.getElementById('authInfo');
                    
                    if (data.authenticated) {
                        authInfo.innerHTML = `
                            <strong>✅ Logged in as:</strong> ${data.user.name} (${data.user.email})
                            <br><strong>User ID:</strong> ${data.user.id}
                        `;
                        log('✅ User is authenticated: ' + data.user.name);
                        getUserSession();
                    } else {
                        authInfo.innerHTML = '<strong>❌ Not logged in</strong> - Please login first';
                        log('❌ User is not authenticated');
                    }
                })
                .catch(error => {
                    log('❌ Error checking auth: ' + error.message);
                    const authInfo = document.getElementById('authInfo');
                    authInfo.innerHTML = '<strong>❌ Error checking authentication</strong>';
                });
        }

        function getUserSession() {
            if (!isAuthenticated) {
                log('❌ User not authenticated, cannot get session');
                return;
            }
            
            log('Getting user chat session...');
            
            fetch('/api/chat/user-session')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        userSessionId = data.session_id;
                        log('✅ User session ID: ' + userSessionId);
                        log('Has history: ' + data.has_history);
                    } else {
                        log('❌ Failed to get user session: ' + data.message);
                    }
                })
                .catch(error => {
                    log('❌ Error getting user session: ' + error.message);
                });
        }

        function sendUserMessage() {
            const message = document.getElementById('testMessageInput').value;
            
            if (!isAuthenticated) {
                log('❌ Please login first');
                return;
            }
            
            if (!userSessionId) {
                log('❌ No session ID available');
                return;
            }
            
            log('Sending user message: "' + message + '"');
            
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                log('ERROR: CSRF token not found');
                return;
            }

            const formData = new FormData();
            formData.append('message', message);
            formData.append('session_id', userSessionId);
            formData.append('_token', token.getAttribute('content'));

            fetch('/api/chat/send', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    log('✅ Message sent successfully');
                    addMessageToUI(message, 'sent');
                    document.getElementById('testMessageInput').value = '';
                } else {
                    log('❌ Failed to send message: ' + data.message);
                }
            })
            .catch(error => {
                log('❌ Error: ' + error.message);
            });
        }

        function loadUserHistory() {
            if (!isAuthenticated) {
                log('❌ Please login first');
                return;
            }
            
            log('Loading user chat history...');
            
            fetch('/api/chat/user-history')
                .then(response => {
                    log('Response status: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    log('History response: ' + JSON.stringify(data));
                    if (data.success && data.data) {
                        log('✅ Found ' + data.data.length + ' messages in history');
                        clearMessages();
                        data.data.forEach(message => {
                            addMessageToUI(
                                message.message + ' (' + message.created_at + ')',
                                message.sender_type === 'user' ? 'sent' : 'received'
                            );
                        });
                    } else {
                        log('❌ No history found or error: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    log('❌ Error loading history: ' + error.message);
                });
        }

        function clearMessages() {
            document.getElementById('messages-container').innerHTML = '<p style="color: #666;">Your chat history will appear here...</p>';
        }

        function addMessageToUI(message, type) {
            const container = document.getElementById('messages-container');
            // Remove the placeholder if it exists
            if (container.children.length === 1 && container.children[0].tagName === 'P') {
                container.innerHTML = '';
            }
            
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message ' + type;
            messageDiv.textContent = message;
            container.appendChild(messageDiv);
        }

        // Auto check auth on load
        window.addEventListener('load', checkAuthStatus);
    </script>
</body>
</html>
