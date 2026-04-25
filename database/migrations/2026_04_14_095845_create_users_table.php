<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email')->unique();
            $table->string('password_hash')->nullable();
            $table->string('google_id')->nullable()->unique();
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->enum('status', ['active', 'banned', 'suspended'])->default('active');
            $table->enum('plan_tier', ['free', 'web', 'full'])->default('free');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('cooldown_until')->nullable();
            $table->timestamp('banned_until')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};