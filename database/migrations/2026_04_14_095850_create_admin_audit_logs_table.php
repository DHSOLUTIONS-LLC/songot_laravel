<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_user_id')->constrained('users');
            $table->string('action_type'); // edit_stem, hide_stem, bulk_hide, send_email, etc.
            $table->string('target_type')->nullable(); // stem, user, etc.
            $table->unsignedBigInteger('target_id')->nullable();
            $table->json('details')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_audit_logs');
    }
};