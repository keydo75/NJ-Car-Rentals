<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Vehicles: add soft deletes and indexes
        Schema::table('vehicles', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicles', 'deleted_at')) {
                $table->softDeletes();
            }

            // Add indexes if they don't already exist
            $table->index('status', 'vehicles_status_index');
            $table->index(['type', 'status'], 'vehicles_type_status_index');
            $table->index(['make', 'model'], 'vehicles_make_model_index');
        });

        // Rentals: add soft deletes and indexes
        Schema::table('rentals', function (Blueprint $table) {
            if (!Schema::hasColumn('rentals', 'deleted_at')) {
                $table->softDeletes();
            }

            $table->index('status', 'rentals_status_index');
            $table->index('start_date', 'rentals_start_date_index');
        });

        // Inquiries: add status index
        Schema::table('inquiries', function (Blueprint $table) {
            $table->index('status', 'inquiries_status_index');
        });
    }

    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropIndex('vehicles_status_index');
            $table->dropIndex('vehicles_type_status_index');
            $table->dropIndex('vehicles_make_model_index');
            if (Schema::hasColumn('vehicles', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->dropIndex('rentals_status_index');
            $table->dropIndex('rentals_start_date_index');
            if (Schema::hasColumn('rentals', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropIndex('inquiries_status_index');
        });
    }
};