<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    // Only proceed if the legacy users table exists
    if (!Schema::hasTable('users')) {
        return;
    }

    // Get all users from old table
    $users = DB::table('users')->get();

    // If there are no legacy users, skip migration/rename so fresh installs and tests remain stable
    if ($users->isEmpty()) {
        return;
    }

    foreach ($users as $user) {
        if ($user->role === 'admin') {
            DB::table('admins')->insert([
                'id' => $user->id, // Keep same ID if important
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'remember_token' => $user->remember_token,
            ]);
        } 
        elseif ($user->role === 'staff') {
            DB::table('staff')->insert([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'position' => 'Rental Agent', // Default value
                'department' => 'Operations', // Default value
                'employee_id' => 'EMP' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
                'hire_date' => now(),
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'remember_token' => $user->remember_token,
            ]);
        } 
        else { // customer
            DB::table('customers')->insert([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'phone' => $user->phone,
                'address' => $user->address,
                'license_number' => $user->license_number ?? 'NOT_SET',
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'remember_token' => $user->remember_token,
            ]);
        }
    }

    // OPTIONAL: Rename old users table to backup (skip during testing)
    if (!app()->environment('testing')) {
        Schema::rename('users', 'users_backup_' . date('Y_m_d'));
    }
} 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('separate_tables', function (Blueprint $table) {
            //
        });
    }
};
