<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('body');
            $table->json('recipient_scope'); // Store selected user IDs or filters
            $table->foreignId('created_by')->constrained('users');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->integer('sent_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_jobs');
    }
};