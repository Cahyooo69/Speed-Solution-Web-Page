<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Menampilkan halaman admin chat
     */
    public function adminIndex()
    {
        return view('admin.chat.dashboard');
    }

    /**
     * API: Kirim pesan dari user
     */
    public function sendMessage(Request $request)
    {
        // Log all incoming data for debugging
        Log::info('Chat sendMessage called', [
            'all_data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'required|string',
            'name' => 'nullable|string|max:100'
        ]);

        try {
            // Gunakan nama user yang login jika tersedia, jika tidak gunakan name dari request
            $userName = Auth::check() ? Auth::user()->name : $request->name;
            $userId = Auth::check() ? Auth::id() : null;
            
            // For authenticated users, force consistent session ID
            $sessionId = Auth::check() ? 'user-' . $userId : $request->session_id;
            
            Log::info('Creating chat with data', [
                'session_id' => $sessionId,
                'user_id' => $userId,
                'name' => $userName,
                'message' => $request->message,
                'sender_type' => 'user'
            ]);
            
            $chat = Chat::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'name' => $userName,
                'message' => $request->message,
                'sender_type' => 'user',
                'is_read' => false
            ]);

            Log::info('Chat created successfully', [
                'chat_id' => $chat->id,
                'created_at_exists' => !is_null($chat->created_at),
                'created_at_value' => $chat->created_at
            ]);

            // Refresh model to ensure timestamps are loaded
            $chat->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim',
                'data' => [
                    'id' => $chat->id,
                    'message' => $chat->message,
                    'sender_type' => $chat->sender_type,
                    'created_at' => $chat->created_at ? $chat->created_at->format('H:i') : now()->format('H:i')
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating chat', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pesan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Kirim balasan dari admin
     */
    public function sendReply(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'required|string'
        ]);

        try {
            // Find the user_id from existing messages in this session
            $userMessage = Chat::where('session_id', $request->session_id)
                ->where('sender_type', 'user')
                ->whereNotNull('user_id')
                ->first();
            
            $targetUserId = $userMessage ? $userMessage->user_id : null;
            
            $chat = Chat::create([
                'session_id' => $request->session_id,
                'user_id' => $targetUserId, // Associate with the user who started the conversation
                'message' => $request->message,
                'sender_type' => 'admin',
                'admin_id' => Auth::id(),
                'is_read' => true
            ]);

            // Mark semua pesan user di sesi ini sebagai sudah dibaca
            Chat::where('session_id', $request->session_id)
                ->where('sender_type', 'user')
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Balasan berhasil dikirim',
                'data' => [
                    'id' => $chat->id,
                    'message' => $chat->message,
                    'sender_type' => $chat->sender_type,
                    'admin_name' => Auth::user()->name,
                    'created_at' => $chat->created_at ? $chat->created_at->format('H:i') : now()->format('H:i')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim balasan'
            ], 500);
        }
    }

    /**
     * API: Get semua sesi chat untuk admin
     */
    public function getAdminSessions()
    {
        try {
            // Get sesi chat yang memiliki pesan dalam 7 hari terakhir
            $sessionsData = Chat::select('session_id')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('session_id')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($session) {
                    $lastMessage = Chat::getLastMessageForSession($session->session_id);
                    if (!$lastMessage) {
                        return null; // Skip jika tidak ada pesan
                    }
                    
                    $unreadCount = Chat::where('session_id', $session->session_id)
                        ->unreadByAdmin()
                        ->count();
                    
                    $userName = Chat::where('session_id', $session->session_id)
                        ->whereNotNull('name')
                        ->first();

                    return [
                        'session_id' => $session->session_id,
                        'user_name' => $userName && $userName->name ? $userName->name : 'User',
                        'last_message' => $lastMessage->message ?? '',
                        'last_message_time' => $lastMessage->created_at ? $lastMessage->created_at->format('d/m H:i') : '',
                        'unread_count' => $unreadCount,
                        'sender_type' => $lastMessage->sender_type ?? 'user'
                    ];
                })
                ->filter(); // Remove null values

            // Calculate stats
            $totalSessions = $sessionsData->count();
            $unreadMessages = Chat::unreadByAdmin()->count();
            $activeToday = Chat::select('session_id')
                ->where('created_at', '>=', now()->startOfDay())
                ->distinct()
                ->count();
            $repliedToday = Chat::where('sender_type', 'admin')
                ->where('created_at', '>=', now()->startOfDay())
                ->count();

            return response()->json([
                'success' => true,
                'data' => $sessionsData,
                'stats' => [
                    'total_sessions' => $totalSessions,
                    'unread_messages' => $unreadMessages,
                    'active_today' => $activeToday,
                    'replied_today' => $repliedToday
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data sesi chat'
            ], 500);
        }
    }

    /**
     * API: Get pesan dalam sesi tertentu
     */
    public function getSessionMessages($sessionId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            $messages = Chat::where('session_id', $sessionId)
                ->with('admin:id,name')
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($chat) {
                    return [
                        'id' => $chat->id,
                        'message' => $chat->message,
                        'sender_type' => $chat->sender_type,
                        'sender_name' => $chat->sender_type === 'admin' 
                            ? ($chat->admin ? $chat->admin->name : 'Admin')
                            : ($chat->name ?? 'User'),
                        'created_at' => $chat->created_at ? $chat->created_at->format('H:i') : '',
                        'is_read' => $chat->is_read
                    ];
                });

            // Mark pesan user sebagai sudah dibaca
            Chat::where('session_id', $sessionId)
                ->where('sender_type', 'user')
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'data' => $messages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil pesan'
            ], 500);
        }
    }

    /**
     * API: Get pesan untuk user (frontend chat)
     */
    public function getUserMessages($sessionId)
    {
        try {
            // For authenticated users, get messages by user_id instead of session_id
            if (Auth::check()) {
                $userId = Auth::id();
                $messages = Chat::where('user_id', $userId)
                    ->orderBy('created_at', 'asc')
                    ->get()
                    ->map(function ($chat) {
                        return [
                            'id' => $chat->id,
                            'message' => $chat->message,
                            'sender_type' => $chat->sender_type,
                            'created_at' => $chat->created_at ? $chat->created_at->format('H:i') : ''
                        ];
                    });
            } else {
                // For guest users, get all messages in the session
                $messages = Chat::where('session_id', $sessionId)
                    ->orderBy('created_at', 'asc')
                    ->get()
                    ->map(function ($chat) {
                        return [
                            'id' => $chat->id,
                            'message' => $chat->message,
                            'sender_type' => $chat->sender_type,
                            'created_at' => $chat->created_at ? $chat->created_at->format('H:i') : ''
                        ];
                    });
            }

            return response()->json([
                'success' => true,
                'data' => $messages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil pesan'
            ], 500);
        }
    }

    /**
     * Generate session ID untuk user baru
     */
    public function generateSessionId()
    {
        return response()->json([
            'success' => true,
            'session_id' => Str::uuid()
        ]);
    }

    /**
     * API: Get existing chat session for authenticated user
     */
    public function getUserChatSession()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        try {
            $userId = Auth::id();
            
            // Use consistent session ID based on user ID
            $sessionId = 'user-' . $userId;
            
            // Check if user has any chat history
            $hasHistory = Chat::where('user_id', $userId)->exists();
            
            return response()->json([
                'success' => true,
                'session_id' => $sessionId,
                'has_history' => $hasHistory
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil session chat'
            ], 500);
        }
    }

    /**
     * API: Get chat messages for authenticated user (by user_id)
     */
    public function getUserChatHistory()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        try {
            $userId = Auth::id();
            
            $messages = Chat::where('user_id', $userId)
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($chat) {
                    return [
                        'id' => $chat->id,
                        'message' => $chat->message,
                        'sender_type' => $chat->sender_type,
                        'created_at' => $chat->created_at ? $chat->created_at->format('H:i') : ''
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $messages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil chat history'
            ], 500);
        }
    }
}
