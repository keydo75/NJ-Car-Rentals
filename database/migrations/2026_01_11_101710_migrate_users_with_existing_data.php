<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Temporarily disable unique constraint on license_number
        Schema::table('customers', function (Blueprint $table) {
            $table->dropUnique(['license_number']);
        });
        
        // Migrate each user type
        $this->migrateAdmins();
        $this->migrateStaff();
        $this->migrateCustomers();
        
        // Re-enable unique constraint
        Schema::table('customers', function (Blueprint $table) {
            $table->unique(['license_number']);
        });
        
        // Optional: Rename old table to backup
        // Schema::rename('users', 'users_backup_' . date('Y_m_d_His'));
    }
    
    private function migrateAdmins(): void
    {
        $admins = DB::table('users')->where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            DB::table('admins')->insert([
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $admin->password,
                'admin_level' => 'basic',
                'department' => 'Administration',
                'created_at' => $admin->created_at,
                'updated_at' => $admin->updated_at,
                'remember_token' => $admin->remember_token,
            ]);
            
            $this->info("Migrated admin: {$admin->name}");
        }
    }
    
    private function migrateStaff(): void
    {
        $staff = DB::table('users')->where('role', 'staff')->get();
        
        foreach ($staff as $user) {
            DB::table('staff')->insert([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'position' => 'Rental Agent',
                'department' => 'Operations',
                'employee_id' => 'EMP' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                'hire_date' => $user->created_at ?? now(),
                'salary' => null,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'remember_token' => $user->remember_token,
            ]);
            
            $this->info("Migrated staff: {$user->name}");
        }
    }
    
    private function migrateCustomers(): void
    {
        $customers = DB::table('users')->where('role', 'customer')->get();
        
        foreach ($customers as $customer) {
            $licenseNumber = $this->generateLicenseNumber($customer);
            
            DB::table('customers')->insert([
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'password' => $customer->password,
                'phone' => $customer->phone,
                'address' => $customer->address,
                'license_number' => $licenseNumber,
                'license_expiry' => now()->addYears(5),
                'loyalty_points' => 0,
                'created_at' => $customer->created_at,
                'updated_at' => $customer->updated_at,
                'remember_token' => $customer->remember_token,
            ]);
            
            $this->info("Migrated customer: {$customer->name} with license: {$licenseNumber}");
        }
    }
    
    private function generateLicenseNumber($customer): string
    {
        // If customer has a valid license number, use it with ID suffix for uniqueness
        if (!empty($customer->license_number) && $customer->license_number !== 'NOT_SET') {
            return $customer->license_number . '-' . $customer->id;
        }
        
        // Generate a new license number based on name and ID
        $nameParts = explode(' ', $customer->name);
        $initials = '';
        
        foreach ($nameParts as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }
        
        if (strlen($initials) < 2) {
            $initials = strtoupper(substr($customer->name, 0, 2));
        }
        
        return 'DL-' . $initials . '-' . str_pad($customer->id, 6, '0', STR_PAD_LEFT);
    }
    
    // Helper method to output info during migration
    private function info($message): void
    {
        echo $message . "\n";
    }

    public function down(): void
    {
        // Clear the migrated data if rolling back
        DB::table('admins')->truncate();
        DB::table('staff')->truncate();
        DB::table('customers')->truncate();
    }
};