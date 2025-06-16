<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'name',
        'message',
        'sender_type',
        'admin_id',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User (admin)
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    
    /**
     * Relasi ke User (user yang mengirim pesan)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope untuk pesan yang belum dibaca admin
     */
    public function scopeUnreadByAdmin($query)
    {
        return $query->where('sender_type', 'user')->where('is_read', false);
    }

    /**
     * Scope untuk sesi chat aktif (ada pesan dalam 24 jam terakhir)
     */
    public function scopeActiveSessions($query)
    {
        return $query->where('created_at', '>=', now()->subDay())
                    ->select('session_id')
                    ->groupBy('session_id');
    }

    /**
     * Get pesan terakhir untuk sesi
     */
    public static function getLastMessageForSession($sessionId)
    {
        return static::where('session_id', $sessionId)
                    ->orderBy('created_at', 'desc')
                    ->first();
    }

    /**
     * Get formatted created_at time safely
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('H:i') : '';
    }

    /**
     * Get formatted created_at with date safely
     */
    public function getFormattedCreatedAtWithDateAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m H:i') : '';
    }
}
