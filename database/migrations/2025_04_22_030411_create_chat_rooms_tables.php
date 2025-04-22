<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('invite_code')->unique();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });

        Schema::create('chat_room_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->timestamps();
        });

        Schema::create('chat_room_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['owner', 'admin', 'member'])->default('member');
            $table->timestamps();

            $table->unique(['chat_room_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_room_users');
        Schema::dropIfExists('chat_room_messages');
        Schema::dropIfExists('chat_rooms');
    }
};
