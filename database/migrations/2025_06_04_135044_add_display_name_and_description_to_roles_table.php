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
        Schema::table('roles', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('roles', 'display_name')) {
                $table->string('display_name')->nullable()->after('role_name');
            }
            
            if (!Schema::hasColumn('roles', 'description')) {
                $table->text('description')->nullable()->after('display_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            if (Schema::hasColumn('roles', 'display_name')) {
                $table->dropColumn('display_name');
            }
            
            if (Schema::hasColumn('roles', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};