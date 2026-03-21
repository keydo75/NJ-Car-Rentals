<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixUserDataSeeder extends Seeder
{
    public function run(): void
    {
        // Fix Customer 3
        DB::table('customers')
            ->where('id', 3)
            ->update([
                'license_number' => 'DL123456789-3',
                'phone' => '09171234569',
                'address' => 'Olongapo City, Philippines',
            ]);
        
        // Fix Customer 4
        DB::table('customers')
            ->where('id', 4)
            ->update([
                'license_number' => 'DL-JS-000004',
                'phone' => '02938283232',
                'address' => 'Bataan, Philippines',
            ]);
        
        // Add Customer 5 if not exists
        if (!DB::table('customers')->where('id', 5)->exists()) {
            DB::table('customers')->insert([
                'id' => 5,
                'name' => 'Mayverick Pamintuan',
                'email' => 'col.2023010390@gmail.com',
                'password' => '$2y$12$a0NAABZ1EPQHt1XcKpa6UOyNLiZwtEcYMroTKMSnMRHx1ch8rSIcS',
                'phone' => '0912738239',
                'address' => null,
                'license_number' => 'DL-MP-000005',
                'license_expiry' => now()->addYears(5),
                'loyalty_points' => 0,
                'created_at' => '2026-01-06 01:12:05',
                'updated_at' => '2026-01-06 01:12:05',
                'remember_token' => null,
            ]);
        }
        
        // Also update Admin and Staff phone numbers from your image
        DB::table('admins')
            ->where('id', 1)
            ->update(['phone' => '09171234567']);
            
        DB::table('staff')
            ->where('id', 2)
            ->update(['phone' => '09171234568']);
        
        $this->command->info('✅ User data fixed successfully!');
        $this->command->info('Admin: admin@njcarrentals.com');
        $this->command->info('Staff: staff@njcarrentals.com');
        $this->command->info('Customer 1: customer@example.com');
        $this->command->info('Customer 2: jsmith08@gmail.com');
        $this->command->info('Customer 3: col.2023010390@gmail.com');
    }
}