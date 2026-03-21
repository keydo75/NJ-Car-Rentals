<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Staff;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SimpleSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        Admin::create([
            'name' => 'NJ Admin',
            'username' => 'admin',
            'email' => 'admin@njcarrentals.com',
            'password' => Hash::make('password 123'),
            'admin_level' => 'super',
            'department' => 'Operations'
        ]);

        // Create Staff User
        Staff::create([
            'name' => 'Staff Member',
            'username' => 'staff',
            'email' => 'staff@njcarrentals.com',
            'password' => Hash::make('password123'),
            'position' => 'Rental Agent',
            'department' => 'Operations',
            'employee_id' => 'EMP001',
            'hire_date' => now()
        ]);

        // Create Customer User
        Customer::create([
            'first_name' => 'John',
            'last_name' => 'Customer',
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
            'phone' => '09171234569',
            'address' => 'Bataan, Philippines',
            'license_number' => 'DL123456789',
            'loyalty_points' => 0
        ]);

        // Create Sample Vehicles for Rent
        Vehicle::create([
            'type' => 'rental',
            'make' => 'Toyota',
            'model' => 'Vios',
            'year' => 2023,
            'plate_number' => 'VX-123-ABC',
            'price_per_day' => 1500,
            'status' => 'available',
            'transmission' => 'automatic',
            'seats' => 5,
            'fuel_type' => 'gasoline',
            'features' => json_encode(['Air Conditioning', 'Power Steering', 'Backup Camera']),
            'description' => 'Brand new Toyota Vios for daily rental',
            'gps_enabled' => true,
            'image_path' => null
        ]);

        Vehicle::create([
            'type' => 'rental',
            'make' => 'Honda',
            'model' => 'City',
            'year' => 2023,
            'plate_number' => 'HX-456-DEF',
            'price_per_day' => 1200,
            'status' => 'available',
            'transmission' => 'manual',
            'seats' => 5,
            'fuel_type' => 'gasoline',
            'features' => json_encode(['Air Conditioning', 'Power Steering']),
            'description' => 'Reliable Honda City for daily rental',
            'gps_enabled' => true,
            'image_path' => null
        ]);

        Vehicle::create([
            'type' => 'sale',
            'make' => 'Mitsubishi',
            'model' => 'Xpander',
            'year' => 2022,
            'plate_number' => 'MX-789-GHI',
            'sale_price' => 850000,
            'status' => 'available',
            'transmission' => 'automatic',
            'seats' => 7,
            'fuel_type' => 'gasoline',
            'features' => json_encode(['Air Conditioning', 'Power Steering', '7 Seater']),
            'description' => 'Spacious Mitsubishi Xpander for sale',
            'gps_enabled' => false,
            'image_path' => null
        ]);
    }
}
