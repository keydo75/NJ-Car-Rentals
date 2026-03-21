<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Drop the license_expiry and license_number columns
            if (Schema::hasColumn('customers', 'license_expiry')) {
                $table->dropColumn('license_expiry');
            }
            if (Schema::hasColumn('customers', 'license_number')) {
                $table->dropColumn('license_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('license_number')->nullable();
            $table->date('license_expiry')->nullable();
        });
    }
};
