# 📚 Single Fighter - Admin Dashboard

## 🔧 Setup Admin

### Kredensial Admin
- **Email:** admin@gmail.com  
- **Password:** admin123

### Akses Admin Dashboard
- URL: `/admin/chat`
- Auto-redirect setelah login admin

## 🛠️ Commands

```bash
# Database
php artisan migrate
php artisan db:seed --class=AdminUserSeeder

# Clear Cache
php artisan config:clear
php artisan route:clear
composer dump-autoload

# Development Server
php artisan serve
npm run dev
```

## 📱 Fitur Chat Admin

### API Endpoints
- `GET /api/admin/chat/sessions` - Get chat sessions
- `GET /api/admin/chat/sessions/{id}/messages` - Get messages
- `POST /api/admin/chat/reply` - Send admin reply

### Frontend Chat
- `POST /api/chat/send` - Send user message
- `GET /api/chat/session` - Generate session ID
- `GET /api/chat/session/{id}/messages` - Get user messages

## 🔒 Security

- AdminMiddleware melindungi routes admin
- Session-based authentication
- CSRF protection untuk semua forms

## 📁 File Structure

```
app/
├── Http/
│   ├── Controllers/ChatController.php
│   └── Middleware/AdminMiddleware.php
├── Models/Chat.php
database/
├── migrations/create_chats_table.php
└── seeders/AdminUserSeeder.php
routes/web.php
```

---
**Proyek ini menggunakan Laravel 11 + Vue.js untuk manajemen chat admin.**
