<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Safely drop any existing FK on rentals.user_id by querying information_schema
        $dbName = DB::getDatabaseName();
        $rows = DB::select(
            "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'rentals' AND COLUMN_NAME = 'user_id' AND REFERENCED_TABLE_NAME IS NOT NULL",
            [$dbName]
        );
        foreach ($rows as $row) {
            try {
                DB::statement("ALTER TABLE `rentals` DROP FOREIGN KEY `{$row->CONSTRAINT_NAME}`");
            } catch (\Exception $e) {
                // ignore
            }
        }

        // Add FK to customers if it doesn't already reference customers
        $exists = DB::select("SELECT 1 FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'rentals' AND COLUMN_NAME = 'user_id' AND REFERENCED_TABLE_NAME = 'customers'", [$dbName]);
        if (!count($exists)) {
            Schema::table('rentals', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('customers')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
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

        if (Schema::hasTable('users')) {
            Schema::table('rentals', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }
};
