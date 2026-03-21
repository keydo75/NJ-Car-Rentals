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
        // Add username to admins table
        Schema::table('admins', function (Blueprint $table) {
            if (!Schema::hasColumn('admins', 'username')) {
                $table->string('username')->unique()->after('name');
            }
        });

        // Add username to staff table
        Schema::table('staff', function (Blueprint $table) {
            if (!Schema::hasColumn('staff', 'username')) {
                $table->string('username')->unique()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'username')) {
                $table->dropColumn('username');
            }
        });

        Schema::table('staff', function (Blueprint $table) {
            if (Schema::hasColumn('staff', 'username')) {
                $table->dropColumn('username');
            }
        });
    }
};
