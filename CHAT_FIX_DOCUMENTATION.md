# Dokumentasi Perbaikan Sistem Chat

## Masalah yang Ditemukan

1. **Masalah Utama**: Ketika user login dengan username yang ada di database, saat melakukan chat, nama yang ditampilkan bukan username yang telah login melainkan nama yang diinput manual melalui prompt.

2. **Masalah Session Management**: Ketika user berganti akun (A→B→A), chat history user A hilang dan session ID berubah, karena sistem menggunakan session_id sebagai acuan utama.

## Analisis Masalah

### Problem 1: Nama Chat Tidak Sesuai User Login ✅ SOLVED

### Problem 2: Session-based vs User-based Chat ✅ SOLVED  
**Root Cause**: Sistem menggunakan `session_id` sebagai acuan utama untuk chat
**Impact**: 
- History terpecah saat session berubah
- User kehilangan chat history saat login ulang
- Session ID tidak konsisten per user

**Better Solution**: Menggunakan `user_id` sebagai acuan utama

## Solusi yang Diterapkan

### 🎯 **PARADIGM SHIFT: Session-based → User-based**

#### **Before (Session-based):**
```
User A → Session-123 → Chat History
User A logout/login → Session-456 → NEW Chat History (old lost)
```

#### **After (User-based):**
```  
User A → user_id=1 → ALL Chat History (persistent)
User A logout/login → user_id=1 → SAME Chat History (restored)
```

### 1. Perbaikan Backend Architecture

#### a. ChatController: User-based Message Loading
```php
// NEW: getUserChatHistory() - Load by user_id
public function getUserChatHistory() {
    $userId = Auth::id();
    $messages = Chat::where('user_id', $userId)
        ->orderBy('created_at', 'asc')
        ->get();
    // All chat history for this user, regardless of session
}

// UPDATED: getUserMessages() - Smart loading
public function getUserMessages($sessionId) {
    if (Auth::check()) {
        // Authenticated: Load by user_id (ignore session_id)
        $messages = Chat::where('user_id', Auth::id())
    } else {
        // Guest: Load by session_id
        $messages = Chat::where('session_id', $sessionId)
    }
}
```

#### b. Simplified Session Management
```php
// getUserChatSession() - Consistent session per user
public function getUserChatSession() {
    $userId = Auth::id();
    $sessionId = 'user-' . $userId; // Always same for each user
    $hasHistory = Chat::where('user_id', $userId)->exists();
}
```

### 2. Frontend Logic Overhaul

#### a. User-based Chat Loading
```javascript
async function loadChatHistory() {
    const authUser = await checkAuthenticatedUser();
    
    if (authUser && authUser.id) {
        // Authenticated: Load ALL user chat via /api/chat/user-history
        response = await fetch('/api/chat/user-history');
    } else {
        // Guest: Load session-based chat
        response = await fetch(`/api/chat/session/${chatSessionId}/messages`);
    }
}
```

#### b. Simplified Session Logic
```javascript
// Authenticated users
if (authUser) {
    chatSessionId = `user-${currentUserId}`; // Consistent per user
    // History loaded by user_id, not session_id
}

// Guest users  
else {
    generateSessionId(); // Random session for guests
    // History loaded by session_id
}
```

## Hasil Perbaikan

### ✅ **USER-BASED CHAT SYSTEM**

#### **Konsep Baru:**
- **Authenticated Users**: Chat dikelola berdasarkan `user_id` 
- **Guest Users**: Chat dikelola berdasarkan `session_id`
- **Persistent History**: User login → Chat history selalu muncul
- **Isolated Sessions**: User A ≠ User B chat history

#### **Testing Scenarios:**

1. **✅ Persistent User Chat:**
```
User A login → Chat "Hello" → Logout → Login → "Hello" masih ada
```

2. **✅ User Isolation:**  
```
User A: "Hello A" → Logout → User B login → Chat kosong/history B
User B: "Hello B" → Logout → User A login → "Hello A" muncul lagi
```

3. **✅ Guest vs Authenticated:**
```
Guest: Chat "Hi" → Login User A → Chat kosong → Chat "Hello A"
Logout → Guest lagi → Chat kosong (guest session berbeda)
```

4. **✅ Session ID Consistency:**
```
User A: session = "user-1" (always same)
User B: session = "user-2" (always same) 
Guest: session = "guest-123456" (random)
```

### **Database Design:**
```sql
-- Authenticated user chat
user_id = 1, session_id = "user-1", message = "Hello"
user_id = 1, session_id = "user-1", message = "How are you?"

-- Guest chat  
user_id = NULL, session_id = "guest-123", message = "Hi there"
```

### **API Endpoints:**
- **`/api/chat/user-history`** → Load ALL user chat (by user_id)
- **`/api/chat/session/{id}/messages`** → Load session chat (for guests)
- **`/api/chat/send`** → Save with user_id (if authenticated)

## Files yang Dimodifikasi

### Backend
- `app/Http/Controllers/ChatController.php` - User-based loading + getUserChatHistory
- `app/Models/Chat.php` - Tambah fillable user_id dan relasi user  
- `database/migrations/2025_06_15_231455_add_user_id_to_chats_table.php` - Migration user_id
- `routes/web.php` - Tambah route /api/chat/user-history

### Frontend
- `resources/views/partials/chat.blade.php` - User-based chat loading
- `resources/js/services/AuthService.js` - User switching detection

## Testing

✅ **User A → Logout → User B → Logout → User A = Chat A history restored**  
✅ **Session ID consistent per user**  
✅ **No more lost chat history**  
✅ **Perfect user isolation**

## Testing

Untuk testing perbaikan ini:

1. Login dengan akun yang sudah terdaftar
2. Buka chat widget
3. Kirim pesan
4. Nama yang muncul harus sesuai dengan nama user yang login
5. Di admin dashboard, nama user juga harus sesuai

## Catatan Teknis

- Menggunakan `Auth::check()` untuk memverifikasi status login
- Menggunakan `Auth::user()->name` untuk mendapatkan nama user
- Fallback ke manual input jika user tidak login
- Menggunakan API endpoint untuk menghindari mixing PHP dan JavaScript di Blade template
