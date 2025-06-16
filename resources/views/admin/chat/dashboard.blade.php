@extends('layouts.admin')

@section('title', 'Admin Chat Dashboard - Speed Solution')

@section('content')
<div style="padding: 20px; background: #f8f9fa; min-height: 100vh;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <!-- Header Admin -->
        <div style="background: linear-gradient(135deg, #CD0505 0%, #B00404 100%); padding: 30px; border-radius: 12px; color: white; margin-bottom: 30px;">
            <h1 style="margin: 0 0 10px 0; font-size: 2rem;">🛠️ Admin Chat Dashboard</h1>
            <p style="margin: 0 0 20px 0; opacity: 0.9;">Kelola Chat dan Respon Customer Speed Solution</p>            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 25px; font-weight: 600;">
                    👤 Admin: {{ Auth::user()->name }}
                </span>                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: rgba(255,255,255,0.2); color: white; border: none; padding: 10px 20px; border-radius: 25px; cursor: pointer; transition: all 0.3s; font-size: 14px;" 
                            onmouseover="this.style.background='rgba(255,255,255,0.3)'" 
                            onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                        🚪 Log Out
                    </button>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 10px;">💬</div>
                <h3 style="margin: 0; font-size: 2rem; color: #CD0505;" id="total-sessions">0</h3>
                <p style="margin: 5px 0 0 0; color: #666;">Total Sesi Chat</p>
            </div>
            <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 10px;">🔔</div>
                <h3 style="margin: 0; font-size: 2rem; color: #CD0505;" id="unread-messages">0</h3>
                <p style="margin: 5px 0 0 0; color: #666;">Pesan Belum Dibaca</p>
            </div>
            <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 10px;">⏰</div>
                <h3 style="margin: 0; font-size: 2rem; color: #CD0505;" id="active-sessions">0</h3>
                <p style="margin: 5px 0 0 0; color: #666;">Sesi Aktif Hari Ini</p>
            </div>
            <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 10px;">✅</div>
                <h3 style="margin: 0; font-size: 2rem; color: #CD0505;" id="replied-today">0</h3>
                <p style="margin: 5px 0 0 0; color: #666;">Dibalas Hari Ini</p>
            </div>
        </div>

        <!-- Main Dashboard Content -->
        <div style="display: grid; grid-template-columns: 350px 1fr; gap: 20px; height: 600px;">
            <!-- Left Panel - Sessions -->
            <div style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: flex; flex-direction: column;">
                <div style="padding: 20px; border-bottom: 1px solid #eee; background: #f8f9fa; border-radius: 12px 12px 0 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h3 style="margin: 0; color: #333;">📋 Daftar Sesi Chat</h3>
                        <button id="refresh-sessions" style="background: #CD0505; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer;">🔄 Refresh</button>
                    </div>
                    
                    <!-- Filter -->
                    <select id="session-filter" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="all">Semua Sesi</option>
                        <option value="unread">Belum Dibaca</option>
                        <option value="read">Sudah Dibaca</option>
                    </select>
                </div>
                
                <div id="sessions-list" style="flex: 1; overflow-y: auto; padding: 0;">
                    <div style="padding: 40px 20px; text-align: center; color: #666;">
                        <div style="font-size: 3rem; margin-bottom: 10px;">💬</div>
                        <p>Memuat sesi chat...</p>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Chat -->
            <div style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: flex; flex-direction: column;">
                <div id="chat-header" style="padding: 20px; border-bottom: 1px solid #eee; background: #f8f9fa; border-radius: 12px 12px 0 0;">
                    <h3 style="margin: 0; color: #333;">💬 Pilih Sesi untuk Membalas</h3>
                    <p style="margin: 5px 0 0 0; color: #666; font-size: 0.9rem;">Klik sesi di panel kiri untuk melihat percakapan</p>
                </div>
                
                <div id="chat-messages" style="flex: 1; padding: 20px; overflow-y: auto; background: #fafafa;">
                    <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: #666; flex-direction: column;">
                        <div style="font-size: 4rem; margin-bottom: 20px;">🗨️</div>
                        <h4 style="margin: 0; color: #333;">Belum Ada Sesi Dipilih</h4>
                        <p style="margin: 10px 0 0 0; text-align: center;">Pilih salah satu sesi chat dari panel kiri untuk mulai membalas customer</p>
                    </div>
                </div>
                
                <div id="reply-section" style="padding: 20px; border-top: 1px solid #eee; display: none;">
                    <!-- Quick Replies -->
                    <div style="margin-bottom: 15px;">
                        <p style="margin: 0 0 10px 0; font-weight: 600; color: #333;">⚡ Quick Replies:</p>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <button class="quick-reply" data-message="Terima kasih telah menghubungi Speed Solution! Kami akan segera membantu Anda." style="background: #e8f0fe; color: #1976d2; border: 1px solid #1976d2; padding: 6px 12px; border-radius: 15px; cursor: pointer; font-size: 0.8rem;">👋 Salam</button>
                            <button class="quick-reply" data-message="Mohon tunggu sebentar, kami sedang mengecek informasi untuk Anda." style="background: #e8f0fe; color: #1976d2; border: 1px solid #1976d2; padding: 6px 12px; border-radius: 15px; cursor: pointer; font-size: 0.8rem;">⏳ Tunggu</button>
                            <button class="quick-reply" data-message="Untuk informasi lebih detail, silakan kunjungi outlet Speed Solution terdekat." style="background: #e8f0fe; color: #1976d2; border: 1px solid #1976d2; padding: 6px 12px; border-radius: 15px; cursor: pointer; font-size: 0.8rem;">🏪 Outlet</button>
                        </div>
                    </div>
                    
                    <!-- Reply Form -->
                    <div style="display: flex; gap: 10px;">
                        <input type="text" id="reply-input" placeholder="Ketik balasan Anda di sini..." style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 25px; outline: none;">
                        <button id="send-reply" style="background: #CD0505; color: white; border: none; padding: 12px 24px; border-radius: 25px; cursor: pointer; font-weight: 600;">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentSession = null;
    let sessions = [];

    // Elements
    const sessionsListEl = document.getElementById('sessions-list');
    const chatMessagesEl = document.getElementById('chat-messages');
    const chatHeaderEl = document.getElementById('chat-header');
    const replySectionEl = document.getElementById('reply-section');
    const replyInputEl = document.getElementById('reply-input');
    const sendReplyBtn = document.getElementById('send-reply');
    const refreshBtn = document.getElementById('refresh-sessions');
    const filterSelect = document.getElementById('session-filter');

    // Stats elements
    const totalSessionsEl = document.getElementById('total-sessions');
    const unreadMessagesEl = document.getElementById('unread-messages');
    const activeSessionsEl = document.getElementById('active-sessions');
    const repliedTodayEl = document.getElementById('replied-today');

    // Event Listeners
    refreshBtn.addEventListener('click', loadSessions);
    sendReplyBtn.addEventListener('click', sendReply);
    filterSelect.addEventListener('change', filterSessions);
    
    replyInputEl.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendReply();
        }
    });

    // Quick reply buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('quick-reply')) {
            replyInputEl.value = e.target.dataset.message;
            replyInputEl.focus();
        }
    });

    // Load sessions on page load
    loadSessions();

    // Auto refresh every 10 seconds
    setInterval(loadSessions, 10000);

    async function loadSessions() {
        try {
            const response = await fetch('/api/admin/chat/sessions', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });

            const data = await response.json();
            
            if (data.success) {
                sessions = data.data;
                displaySessions(sessions);
                updateStats(data.stats || {});
            } else {
                showError('Gagal memuat sesi: ' + data.message);
            }
        } catch (error) {
            console.error('Error loading sessions:', error);
            showError('Error loading sessions');
        }
    }

    function displaySessions(sessionsToShow) {
        if (sessionsToShow.length === 0) {
            sessionsListEl.innerHTML = `
                <div style="padding: 40px 20px; text-align: center; color: #666;">
                    <div style="font-size: 3rem; margin-bottom: 10px;">📭</div>
                    <p>Belum ada sesi chat</p>
                </div>
            `;
            return;
        }

        const sessionsHtml = sessionsToShow.map(session => `
            <div class="session-item" data-session-id="${session.session_id}" style="padding: 15px 20px; border-bottom: 1px solid #f0f0f0; cursor: pointer; transition: background 0.3s; ${session.unread_count > 0 ? 'background: #fff8e1; border-left: 4px solid #CD0505;' : ''}">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
                    <div style="font-weight: 600; color: #333; display: flex; align-items: center; gap: 8px;">
                        ${session.user_name || 'User'}
                        ${session.unread_count > 0 ? `<span style="background: #CD0505; color: white; font-size: 0.7rem; padding: 2px 6px; border-radius: 10px;">${session.unread_count}</span>` : ''}
                    </div>
                    <div style="font-size: 0.75rem; color: #888;">${session.last_message_time}</div>
                </div>                <div style="color: #666; font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    ${session.last_message}
                </div>
            </div>
        `).join('');

        sessionsListEl.innerHTML = sessionsHtml;

        // Add click listeners
        document.querySelectorAll('.session-item').forEach(item => {
            item.addEventListener('click', function() {
                selectSession(this.dataset.sessionId, this);
            });
        });
    }

    function filterSessions() {
        const filter = filterSelect.value;
        let filteredSessions = sessions;

        switch(filter) {
            case 'unread':
                filteredSessions = sessions.filter(s => s.unread_count > 0);
                break;
            case 'read':
                filteredSessions = sessions.filter(s => s.unread_count === 0);
                break;
            default:
                filteredSessions = sessions;
        }

        displaySessions(filteredSessions);
    }

    async function selectSession(sessionId, sessionElement) {
        // Update UI
        document.querySelectorAll('.session-item').forEach(item => {
            item.style.background = item.dataset.sessionId === sessionId ? '#e8f0fe' : '';
        });

        currentSession = sessionId;

        try {
            const response = await fetch(`/api/admin/chat/sessions/${sessionId}/messages`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });

            const data = await response.json();

            if (data.success) {
                displayMessages(data.data);
                showReplySection(sessionId);
                
                // Remove unread indicator
                sessionElement.style.background = '#e8f0fe';
                const unreadBadge = sessionElement.querySelector('span[style*="background: #CD0505"]');
                if (unreadBadge) {
                    unreadBadge.remove();
                }
            } else {
                showError('Gagal memuat pesan: ' + data.message);
            }
        } catch (error) {
            console.error('Error loading messages:', error);
            showError('Error loading messages');
        }
    }

    function displayMessages(messages) {
        if (messages.length === 0) {
            chatMessagesEl.innerHTML = `
                <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: #666; flex-direction: column;">
                    <div style="font-size: 3rem; margin-bottom: 10px;">📝</div>
                    <h4 style="margin: 0; color: #333;">Belum Ada Pesan</h4>
                    <p style="margin: 10px 0 0 0;">Sesi ini belum memiliki pesan</p>
                </div>
            `;
            return;
        }

        const messagesHtml = messages.map(message => `
            <div style="margin-bottom: 15px; display: flex; ${message.sender_type === 'admin' ? 'justify-content: flex-end;' : 'justify-content: flex-start;'}">
                <div style="max-width: 70%; ${message.sender_type === 'admin' ? 'background: #CD0505; color: white;' : 'background: #e9ecef; color: #333;'} padding: 12px 16px; border-radius: 18px; word-wrap: break-word;">
                    <div style="margin-bottom: 5px;">${message.message}</div>
                    <div style="font-size: 0.7rem; opacity: 0.8;">${message.sender_name} - ${message.created_at}</div>
                </div>
            </div>
        `).join('');

        chatMessagesEl.innerHTML = messagesHtml;
        chatMessagesEl.scrollTop = chatMessagesEl.scrollHeight;
    }

    function showReplySection(sessionId) {
        const session = sessions.find(s => s.session_id === sessionId);
        const userName = session ? session.user_name : 'User';
        
        chatHeaderEl.innerHTML = `
            <h3 style="margin: 0; color: #333;">💬 Chat dengan ${userName}</h3>
            <p style="margin: 5px 0 0 0; color: #666; font-size: 0.9rem;">Session ID: ${sessionId}</p>
        `;
        
        replySectionEl.style.display = 'block';
        replyInputEl.focus();
    }

    async function sendReply() {
        const message = replyInputEl.value.trim();
        if (!message || !currentSession) return;

        replyInputEl.disabled = true;
        sendReplyBtn.disabled = true;

        try {
            const response = await fetch('/api/admin/chat/reply', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    message: message,
                    session_id: currentSession
                })
            });

            const data = await response.json();

            if (data.success) {
                replyInputEl.value = '';
                
                // Add message to UI immediately
                const messageHtml = `
                    <div style="margin-bottom: 15px; display: flex; justify-content: flex-end;">
                        <div style="max-width: 70%; background: #CD0505; color: white; padding: 12px 16px; border-radius: 18px; word-wrap: break-word;">
                            <div style="margin-bottom: 5px;">${message}</div>
                            <div style="font-size: 0.7rem; opacity: 0.8;">{{ Auth::user()->name }} - Baru saja</div>
                        </div>
                    </div>
                `;
                
                chatMessagesEl.insertAdjacentHTML('beforeend', messageHtml);
                chatMessagesEl.scrollTop = chatMessagesEl.scrollHeight;
                
                // Refresh sessions
                loadSessions();
            } else {
                showError('Gagal mengirim pesan: ' + data.message);
            }
        } catch (error) {
            console.error('Error sending reply:', error);
            showError('Error sending message');
        } finally {
            replyInputEl.disabled = false;
            sendReplyBtn.disabled = false;
            replyInputEl.focus();
        }
    }

    function updateStats(stats) {
        totalSessionsEl.textContent = stats.total_sessions || 0;
        unreadMessagesEl.textContent = stats.unread_messages || 0;
        activeSessionsEl.textContent = stats.active_today || 0;
        repliedTodayEl.textContent = stats.replied_today || 0;
    }

    function showError(message) {
        console.error(message);
        // You can implement a toast notification here
        alert(message);
    }
});
</script>
@endsection
