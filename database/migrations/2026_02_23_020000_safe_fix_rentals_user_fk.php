<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Find any existing foreign key constraint on rentals.user_id
        $dbName = DB::getDatabaseName();
        $rows = DB::select(
            "SELECT CONSTRAINT_NAME, REFERENCED_TABLE_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'rentals' AND COLUMN_NAME = 'user_id' AND REFERENCED_TABLE_NAME IS NOT NULL",
            [$dbName]
        );

        foreach ($rows as $row) {
            try {
                DB::statement("ALTER TABLE `rentals` DROP FOREIGN KEY `{$row->CONSTRAINT_NAME}`");
            } catch (\Exception $e) {
                // ignore
            }
        }

        // Now add FK to customers if not present
        // Check if a FK referencing customers already exists
        $exists = DB::select("SELECT 1 FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'rentals' AND COLUMN_NAME = 'user_id' AND REFERENCED_TABLE_NAME = 'customers'", [$dbName]);
        if (!count($exists)) {
            Schema::table('rentals', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('customers')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        // Attempt to drop FK to customers
        $dbName = DB::getDatabaseName();
        $rows = DB::select(
            "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'rentals' AND COLUMN_NAME = 'user_id' AND REFERENCED_TABLE_NAME = 'customers'",
            [$dbName]
        );
        foreach ($rows as $row) {
            try {
                DB::statement("ALTER TABLE `rentals` DROP FOREIGN KEY `{$row->CONSTRAINT_NAME}`");
            } catch (\Exception $e) {
                // ignore
            }
        }

        // Optionally recreate FK to users if users table exists
        if (Schema::hasTable('users')) {
            Schema::table('rentals', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }
};
