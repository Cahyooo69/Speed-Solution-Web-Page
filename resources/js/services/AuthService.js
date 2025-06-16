// AuthService untuk manage authentication state secara global
class AuthService {
    constructor() {
        this.isAuthenticated = false;
        this.user = null;
        this.callbacks = [];
    }

    // Subscribe to auth state changes
    subscribe(callback) {
        this.callbacks.push(callback);
        return () => {
            this.callbacks = this.callbacks.filter(cb => cb !== callback);
        };
    }

    // Notify all subscribers
    notify() {
        this.callbacks.forEach(callback => callback({
            isAuthenticated: this.isAuthenticated,
            user: this.user
        }));
    }    // Update auth state
    setAuth(isAuthenticated, user = null) {
        const previousUser = this.user;
        this.isAuthenticated = isAuthenticated;
        this.user = user;
        
        // Clear chat data only when user changes (not on logout)
        if (previousUser && user && previousUser.id !== user.id) {
            // Different user logged in
            this.clearChatData();
        } else if (previousUser && !user) {
            // User logged out - don't clear chat data, just close chat if open
            this.closeChatUI();
        }
        
        this.notify();
    }
    
    // Clear chat data (only for user switching)
    clearChatData() {
        localStorage.removeItem('chat_session_id');
        localStorage.removeItem('chat_user_name');
        localStorage.removeItem('chat_user_id');
        
        // Call global clearChatData function if available
        if (typeof window.clearChatData === 'function') {
            window.clearChatData();
        } else {
            // Fallback: Clear chat UI if available
            const chatMessages = document.getElementById('chat-messages');
            if (chatMessages) {
                chatMessages.innerHTML = '<div class="chat-message message-received">Halo! Selamat datang di Speed Solution. Ada yang bisa saya bantu dengan kendaraan Anda?</div>';
            }
        }
    }
    
    // Close chat UI (for logout)
    closeChatUI() {
        const chatContainer = document.getElementById('chat-container');
        if (chatContainer && chatContainer.style.display === 'flex') {
            chatContainer.style.display = 'none';
        }
    }

    // Check authentication status
    async checkAuth() {
        try {
            const response = await window.axios.get('/api/auth/check');
            if (response.data.success) {
                this.setAuth(
                    response.data.data.isAuthenticated,
                    response.data.data.user
                );
                return response.data.data;
            }
        } catch (error) {
            console.error('Auth check failed:', error);
            this.setAuth(false, null);
        }
        return { isAuthenticated: false, user: null };
    }

    // Login
    async login(credentials) {
        try {
            const response = await window.axios.post('/api/login', credentials);
            if (response.data.success) {
                this.setAuth(true, response.data.data.user);
                return response.data;
            }
            return response.data;
        } catch (error) {
            throw error;
        }
    }

    // Logout
    async logout() {
        try {
            await window.axios.post('/api/logout');
            this.setAuth(false, null);
            return true;
        } catch (error) {
            console.error('Logout failed:', error);
            // Force logout anyway
            this.setAuth(false, null);
            return false;
        }
    }
}

// Create singleton instance
window.authService = new AuthService();

export default window.authService;
