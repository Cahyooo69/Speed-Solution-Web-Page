<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        button { padding: 10px 15px; margin: 5px; cursor: pointer; }
        #results { margin: 20px 0; padding: 15px; background: #f5f5f5; }
    </style>
</head>
<body>
    <h1>Chat API Test</h1>
    
    <div class="test-section">
        <h3>1. Test Basic API Connection</h3>
        <button onclick="testAPI()">Test API Connection</button>
    </div>
    
    <div class="test-section">
        <h3>2. Test Chat Send Message</h3>
        <input type="text" id="testMessage" placeholder="Enter test message..." value="Hello from test page">
        <button onclick="testSendMessage()">Send Message</button>
    </div>
    
    <div class="test-section">
        <h3>3. Generate Session ID</h3>
        <button onclick="testGenerateSession()">Generate Session</button>
    </div>
    
    <div id="results">
        <h4>Results:</h4>
        <div id="output"></div>
    </div>

    <script>
        function log(message) {
            const output = document.getElementById('output');
            output.innerHTML += '<div>' + new Date().toLocaleTimeString() + ': ' + message + '</div>';
            console.log(message);
        }

        function testAPI() {
            log('Testing basic API connection...');
            fetch('/api/chat/user-session')
                .then(response => {
                    log('Response status: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    log('API Response: ' + JSON.stringify(data));
                })
                .catch(error => {
                    log('Error: ' + error.message);
                });
        }

        function testGenerateSession() {
            log('Testing session generation...');
            fetch('/api/chat/session')
                .then(response => {
                    log('Response status: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    log('Session Response: ' + JSON.stringify(data));
                })
                .catch(error => {
                    log('Error: ' + error.message);
                });
        }

        function testSendMessage() {
            const message = document.getElementById('testMessage').value;
            log('Testing send message: "' + message + '"');
            
            // Generate session ID
            const sessionId = 'test-session-' + Date.now();
            
            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                log('ERROR: CSRF token not found');
                return;
            }

            const formData = new FormData();
            formData.append('message', message);
            formData.append('session_id', sessionId);
            formData.append('name', 'Test User');
            formData.append('_token', token.getAttribute('content'));

            log('Sending to /api/chat/send with session: ' + sessionId);

            fetch('/api/chat/send', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                log('Response status: ' + response.status);
                log('Response headers: ' + JSON.stringify([...response.headers.entries()]));
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        log('Raw response: ' + text);
                        throw new Error('Invalid JSON response');
                    }
                });
            })
            .then(data => {
                log('Success Response: ' + JSON.stringify(data));
            })
            .catch(error => {
                log('Error: ' + error.message);
            });
        }
    </script>
</body>
</html>
