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
        Schema::create('vault_genre_meta', function (Blueprint $table) {
            $table->id();
            $table->string('genre_id')->unique(); // matches 'id' from API e.g. "hip-hop"
            $table->text('description')->nullable();
            $table->json('tags')->nullable();       // stored as JSON array
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vault_genre_meta');
    }
};
