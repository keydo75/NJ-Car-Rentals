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
        // Some drivers (SQLite) don't support dropping columns; skip if so to keep tests stable.
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'sqlite') {
            return;
        }

        if (Schema::hasTable('admins') && Schema::hasColumn('admins', 'department')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('department');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('admins') && ! Schema::hasColumn('admins', 'department')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('department')->nullable();
            });
        }
    }
};
