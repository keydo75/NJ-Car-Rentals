<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['rental', 'sale']);
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->string('plate_number')->unique();
            $table->decimal('price_per_day', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->enum('status', ['available', 'rented', 'sold', 'maintenance'])->default('available');
            $table->enum('transmission', ['automatic', 'manual']);
            $table->integer('seats');
            $table->string('fuel_type');
            $table->text('features')->nullable();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('gps_enabled')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};