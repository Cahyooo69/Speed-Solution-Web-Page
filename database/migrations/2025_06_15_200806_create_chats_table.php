<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('session_id'); // ID sesi chat untuk mengelompokkan percakapan
            $table->string('name')->nullable(); // Nama pengirim (jika user memberikan)
            $table->text('message'); // Isi pesan
            $table->enum('sender_type', ['user', 'admin']); // Tipe pengirim
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); // ID admin yang membalas
            $table->boolean('is_read')->default(false); // Status dibaca
            $table->timestamps();
            
            $table->index(['session_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
