<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NJCarRentalsSeeder extends Seeder
{
    public function run()
    {
        // Clear all relevant tables first (be robust if legacy `users` table is absent)
        // SQLite doesn't support FOREIGN_KEY_CHECKS, so we just skip for SQLite
        $driver = \DB::connection()->getDriverName();
        if ($driver !== 'sqlite') {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // Truncate new user tables if they exist
        if (\Schema::hasTable('admins')) {
            \App\Models\Admin::truncate();
        }

        if (\Schema::hasTable('staff')) {
            \App\Models\Staff::truncate();
        }

        if (\Schema::hasTable('customers')) {
            \App\Models\Customer::truncate();
        }

        // Fallback: remove legacy users if present
        if (\Schema::hasTable('users')) {
            \DB::table('users')->truncate();
        }

        // Other domain tables
        if (\Schema::hasTable('vehicles')) {
            \App\Models\Vehicle::truncate();
        }

        if (\Schema::hasTable('rentals')) {
            \DB::table('rentals')->truncate();
        }

        if (\Schema::hasTable('inquiries')) {
            \DB::table('inquiries')->truncate();
        }

        if ($driver !== 'sqlite') {
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // Create Admin User
        \App\Models\Admin::create([
            'name' => 'NJ Admin',
            'username' => 'admin',
            'email' => 'admin@njcarrentals.com',
            'password' => Hash::make('password 123'),
'admin_level' => 'super'
        ]);

        // Create Staff User
        \App\Models\Staff::create([
            'name' => 'Staff Member',
            'username' => 'staff',
            'email' => 'staff@njcarrentals.com',
            'password' => Hash::make('staff123'),
'position' => 'Rental Agent',
            'department' => 'Operations',
            'employee_id' => 'EMP001',
            'hire_date' => now()
        ]);

        // Create Customer
        \App\Models\Customer::create([
            'first_name' => 'John',
            'last_name' => 'Customer',
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
            'phone' => '09171234569',
            'address' => 'Bataan, Philippines',
        ]);

        // Base URL for images - works for both local and production
        $baseUrl = config('app.url', 'https://nj-car-rentals-production.up.railway.app');

        // Create Rental Vehicles
        Vehicle::create([
            'type' => 'rental',
            'make' => 'Toyota',
            'model' => 'Vios',
            'year' => 2023,
            'plate_number' => 'ABC123',
            'price_per_day' => 2500.00,
            'status' => 'available',
            'transmission' => 'automatic',
            'seats' => 5,
            'fuel_type' => 'gasoline',
            'features' => json_encode(['Air Conditioning', 'GPS', 'Bluetooth', 'Backup Camera']),
            'description' => 'Reliable and fuel-efficient sedan perfect for city driving.',
            'image_url' => $baseUrl . '/images/viosWhite.png',
            'image_path' => 'images/viosWhite.png',
            'gallery_images' => json_encode([$baseUrl . '/images/viosBlack.avif']),
            'has_gps' => true,
            'gps_enabled' => true
        ]);

        Vehicle::create([
            'type' => 'rental',
            'make' => 'Honda',
            'model' => 'City',
            'year' => 2022,
            'plate_number' => 'XYZ789',
            'price_per_day' => 2800.00,
            'status' => 'available',
            'transmission' => 'automatic',
            'seats' => 5,
            'fuel_type' => 'gasoline',
            'features' => json_encode(['Air Conditioning', 'GPS', 'Sunroof', 'Leather Seats']),
            'description' => 'Comfortable sedan with excellent fuel economy.',
            'image_url' => $baseUrl . '/images/vios2014.jpg',
            'image_path' => 'images/vios2014.jpg',
            'gps_enabled' => true
        ]);

        Vehicle::create([
            'type' => 'rental',
            'make' => 'Mitsubishi',
            'model' => 'Montero Sport',
            'year' => 2021,
            'plate_number' => 'DEF456',
            'price_per_day' => 3500.00,
            'status' => 'available',
            'transmission' => 'automatic',
            'seats' => 7,
            'fuel_type' => 'diesel',
            'features' => json_encode(['4x4', 'Turbo Diesel', 'Touchscreen', 'Dual AC', 'Roof Rails']),
            'description' => 'Powerful SUV perfect for family trips and outdoor adventures.',
            'image_url' => $baseUrl . '/images/new-hiace-commuter.jpg',
            'image_path' => 'images/new-hiace-commuter.jpg',
            'gallery_images' => json_encode([]),
            'has_gps' => true,
            'gps_enabled' => true
        ]);

        // Create Sale Vehicles
        Vehicle::create([
            'type' => 'sale',
            'make' => 'Toyota',
            'model' => 'Fortuner',
            'year' => 2020,
            'plate_number' => 'GHI789',
            'sale_price' => 1500000.00,
            'status' => 'available',
            'transmission' => 'automatic',
            'seats' => 7,
            'fuel_type' => 'diesel',
            'features' => json_encode(['4x4', 'Turbo Diesel', 'Leather Seats', 'Sunroof', 'Camera 360']),
            'description' => 'Well-maintained SUV with complete documents. No accidents.',
            'image_url' => $baseUrl . '/images/toyotaHiace.webp',
            'image_path' => 'images/toyotaHiace.webp',
            'gallery_images' => json_encode([]),
            'has_gps' => false,
            'gps_enabled' => false
        ]);

        Vehicle::create([
            'type' => 'sale',
            'make' => 'Honda',
            'model' => 'Civic',
            'year' => 2019,
            'plate_number' => 'JKL012',
            'sale_price' => 950000.00,
            'status' => 'available',
            'transmission' => 'automatic',
            'seats' => 5,
            'fuel_type' => 'gasoline',
            'features' => json_encode(['Turbo Engine', 'LED Lights', 'Touchscreen', 'Push Start']),
            'description' => 'Sporty sedan with low mileage. Excellent condition.',
            'image_url' => $baseUrl . '/images/honda%20civic%202019.jpg',
            'image_path' => 'images/honda civic 2019.jpg',
            'gallery_images' => json_encode([]),
            'has_gps' => false,
            'gps_enabled' => false
        ]);
    }
}

