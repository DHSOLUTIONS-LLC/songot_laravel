<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('downloads', function (Blueprint $table) {
            // Add source_type column if not exists
            if (!Schema::hasColumn('downloads', 'source_type')) {
                $table->enum('source_type', ['guest', 'free_user', 'web_user', 'full_user', 'logged_in'])->nullable()->after('user_agent');
            }
            
            // Add status column if not exists
            if (!Schema::hasColumn('downloads', 'status')) {
                $table->enum('status', ['success', 'failed', 'blocked'])->default('success')->after('source_type');
            }
        });
    }

    public function down()
    {
        Schema::table('downloads', function (Blueprint $table) {
            $table->dropColumn(['source_type', 'status']);
        });
    }
};