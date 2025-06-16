<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Reply Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        button { padding: 10px 15px; margin: 5px; cursor: pointer; }
        #results { margin: 20px 0; padding: 15px; background: #f5f5f5; }
        select, input { padding: 8px; margin: 5px; min-width: 200px; }
    </style>
</head>
<body>
    <h1>Admin Reply Test</h1>
    
    <div class="test-section">
        <h3>1. Select Session to Reply</h3>
        <select id="sessionSelect">
            <option value="">Select a session...</option>
        </select>
        <button onclick="loadSessions()">Load Sessions</button>
    </div>
    
    <div class="test-section">
        <h3>2. Send Admin Reply</h3>
        <input type="text" id="replyMessage" placeholder="Admin reply message..." value="Terima kasih telah menghubungi Speed Solution! Kami akan segera membantu Anda.">
        <button onclick="sendAdminReply()">Send Admin Reply</button>
    </div>
    
    <div class="test-section">
        <h3>3. Current Session Messages</h3>
        <div id="messages-container" style="border: 1px solid #ccc; padding: 10px; min-height: 200px; background: white;">
            <p style="color: #666;">Select a session and messages will appear here...</p>
        </div>
        <button onclick="loadSessionMessages()">Reload Messages</button>
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

        function loadSessions() {
            log('Loading admin sessions...');
            
            fetch('/api/admin/chat/sessions', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    const select = document.getElementById('sessionSelect');
                    select.innerHTML = '<option value="">Select a session...</option>';
                    
                    data.data.forEach(session => {
                        const option = document.createElement('option');
                        option.value = session.session_id;
                        option.textContent = `${session.user_name} - ${session.last_message.substring(0, 50)}... (${session.unread_count} unread)`;
                        select.appendChild(option);
                    });
                    
                    log('✅ Loaded ' + data.data.length + ' sessions');
                } else {
                    log('❌ Failed to load sessions: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                log('❌ Error loading sessions: ' + error.message);
            });
        }

        function sendAdminReply() {
            const sessionId = document.getElementById('sessionSelect').value;
            const message = document.getElementById('replyMessage').value;
            
            if (!sessionId) {
                log('❌ Please select a session first');
                return;
            }
            
            if (!message) {
                log('❌ Please enter a reply message');
                return;
            }
            
            currentSessionId = sessionId;
            log('Sending admin reply to session: ' + sessionId);
            
            fetch('/api/admin/chat/reply', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    message: message,
                    session_id: sessionId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    log('✅ Admin reply sent successfully');
                    loadSessionMessages();
                } else {
                    log('❌ Failed to send reply: ' + data.message);
                }
            })
            .catch(error => {
                log('❌ Error sending reply: ' + error.message);
            });
        }

        function loadSessionMessages() {
            const sessionId = document.getElementById('sessionSelect').value || currentSessionId;
            
            if (!sessionId) {
                log('❌ No session selected');
                return;
            }
            
            log('Loading messages for session: ' + sessionId);
            
            fetch(`/api/admin/chat/sessions/${sessionId}/messages`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    const container = document.getElementById('messages-container');
                    container.innerHTML = '';
                    
                    data.data.forEach(message => {
                        const messageDiv = document.createElement('div');
                        messageDiv.style.cssText = `
                            margin: 10px 0; 
                            padding: 10px; 
                            border-radius: 10px; 
                            max-width: 80%;
                            ${message.sender_type === 'admin' ? 
                                'background: #CD0505; color: white; margin-left: auto; text-align: right;' : 
                                'background: #e9ecef; color: #333;'}
                        `;
                        messageDiv.innerHTML = `
                            <div><strong>${message.sender_name}:</strong> ${message.message}</div>
                            <div style="font-size: 0.8em; opacity: 0.8;">${message.created_at}</div>
                        `;
                        container.appendChild(messageDiv);
                    });
                    
                    log('✅ Loaded ' + data.data.length + ' messages');
                } else {
                    log('❌ Failed to load messages: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                log('❌ Error loading messages: ' + error.message);
            });
        }

        // Event listener for session selection
        document.getElementById('sessionSelect').addEventListener('change', function() {
            if (this.value) {
                currentSessionId = this.value;
                loadSessionMessages();
            }
        });

        // Auto load sessions on page load
        window.addEventListener('load', loadSessions);
    </script>
</body>
</html>
