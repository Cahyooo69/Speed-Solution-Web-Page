<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat History Test</title>
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
            background: #e9ecef; 
            color: #333; 
        }
    </style>
</head>
<body>
    <h1>Chat History Test</h1>
    
    <div class="test-section">
        <h3>1. Check Session & Send Test Message</h3>
        <button onclick="checkSession()">Check Session ID</button>
        <button onclick="sendTestMessage()">Send Test Message</button>
        <input type="text" id="testMessageInput" placeholder="Test message..." value="Test message from history test">
    </div>
    
    <div class="test-section">
        <h3>2. Test Load History</h3>
        <button onclick="loadHistory()">Load Chat History</button>
        <button onclick="clearMessages()">Clear Messages</button>
    </div>
    
    <div class="test-section">
        <h3>3. Current Session Messages</h3>
        <div id="messages-container" style="border: 1px solid #ccc; padding: 10px; min-height: 200px; background: white;">
            <p style="color: #666;">Messages will appear here...</p>
        </div>
    </div>
    
    <div id="results">
        <h4>Test Results:</h4>
        <div id="output"></div>
    </div>

    <script>
        let currentSessionId = null;

        function log(message) {
            const output = document.getElementById('output');
            output.innerHTML += '<div>' + new Date().toLocaleTimeString() + ': ' + message + '</div>';
            console.log(message);
        }

        function checkSession() {
            currentSessionId = localStorage.getItem('chat_session_id');
            if (!currentSessionId) {
                currentSessionId = 'test-session-' + Date.now();
                localStorage.setItem('chat_session_id', currentSessionId);
                log('Created new session: ' + currentSessionId);
            } else {
                log('Current session: ' + currentSessionId);
            }
        }

        function sendTestMessage() {
            checkSession();
            const message = document.getElementById('testMessageInput').value;
            log('Sending test message: "' + message + '"');
            
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                log('ERROR: CSRF token not found');
                return;
            }

            const formData = new FormData();
            formData.append('message', message);
            formData.append('session_id', currentSessionId);
            formData.append('name', 'Test User');
            formData.append('_token', token.getAttribute('content'));

            fetch('/api/chat/send', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    log('✅ Message sent successfully');
                    // Add to UI immediately
                    addMessageToUI(message, 'sent');
                } else {
                    log('❌ Failed to send message: ' + data.message);
                }
            })
            .catch(error => {
                log('❌ Error: ' + error.message);
            });
        }

        function loadHistory() {
            checkSession();
            log('Loading chat history for session: ' + currentSessionId);
            
            fetch('/api/chat/session/' + currentSessionId + '/messages')
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
            document.getElementById('messages-container').innerHTML = '<p style="color: #666;">Messages will appear here...</p>';
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

        // Auto check session on load
        window.addEventListener('load', checkSession);
    </script>
</body>
</html>
