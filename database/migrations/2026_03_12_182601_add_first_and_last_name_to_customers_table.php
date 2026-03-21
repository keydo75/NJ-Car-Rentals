<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('first_name', 100)->after('name');
            $table->string('last_name', 100)->after('first_name');
        });

        // Backfill existing data
        DB::statement("
            UPDATE customers 
            SET first_name = NULLIF(TRIM(LEFT(name, LENGTH(name) - LENGTH(SUBSTRING_INDEX(name, ' ', -1)))), ''),
                last_name = NULLIF(TRIM(SUBSTRING_INDEX(name, ' ', -1)), '')
            WHERE name IS NOT NULL AND name != ''
        ");

        DB::statement("
            UPDATE customers 
            SET name = CONCAT(COALESCE(first_name, ''), ' ', COALESCE(last_name, ''))
            WHERE first_name IS NOT NULL OR last_name IS NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};
