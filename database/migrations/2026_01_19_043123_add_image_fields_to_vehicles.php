<?php
// database/migrations/xxxx_add_image_fields_to_vehicles.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageFieldsToVehicles extends Migration
{
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Only add columns if they don't already exist
            if (!Schema::hasColumn('vehicles', 'image_url')) {
                $table->string('image_url')->nullable()->after('model');
            }
            if (!Schema::hasColumn('vehicles', 'gallery_images')) {
                $table->json('gallery_images')->nullable()->after('image_url');
            }
            if (!Schema::hasColumn('vehicles', 'has_gps')) {
                $table->boolean('has_gps')->default(false)->after('gps_enabled');
            }
            if (!Schema::hasColumn('vehicles', 'fuel_type')) {
                $table->string('fuel_type')->nullable()->after('transmission');
            }
            if (!Schema::hasColumn('vehicles', 'seats')) {
                $table->integer('seats')->nullable()->after('fuel_type');
            }
        });
    }

    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['image_url', 'gallery_images', 'has_gps', 'fuel_type', 'seats']);
        });
    }
}