<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stems', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('artist', 100);
            $table->enum('stem_type', ['Acapella', 'Drums', 'Bass', 'Melody', 'Instrumental']);
            $table->integer('bpm');
            $table->string('musical_key', 10);
            $table->string('genre', 50);
            $table->string('storage_path');
            $table->string('preview_path')->nullable();
            $table->integer('duration')->nullable(); // in seconds
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_free')->default(true);
            $table->boolean('is_locked')->default(false);
            $table->string('uploaded_from_job_id')->nullable();
            $table->timestamps();
            
            // Indexes for fast searching
            $table->index('stem_type');
            $table->index('genre');
            $table->index('bpm');
            $table->index('musical_key');
            $table->index('is_visible');
            $table->index('is_locked');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stems');
    }
};