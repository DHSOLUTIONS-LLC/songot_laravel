<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('guest_session_id')->nullable();
            $table->foreignId('stem_id')->constrained()->onDelete('cascade');
            $table->string('ip_hash', 64);
            $table->text('user_agent')->nullable();
            $table->timestamp('downloaded_at')->useCurrent();
            $table->enum('source_type', ['guest', 'free_user', 'web_user', 'full_user']);
            $table->enum('status', ['success', 'failed', 'blocked'])->default('success');
            
            // Indexes for rate limiting queries
            $table->index(['ip_hash', 'downloaded_at']);
            $table->index(['user_id', 'downloaded_at']);
            $table->index(['guest_session_id', 'downloaded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('downloads');
    }
};