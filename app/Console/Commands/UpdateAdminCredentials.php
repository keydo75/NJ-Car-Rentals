<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class UpdateAdminCredentials extends Command
{
    protected $signature = 'admin:update-credentials {email} {username} {password}';
    protected $description = 'Update admin username and password';

    public function handle()
    {
        $email = $this->argument('email');
        $username = $this->argument('username');
        $password = $this->argument('password');

        $admin = Admin::where('email', $email)->first();
        if (!$admin) {
            $this->error("Admin with email {$email} not found");
            return 1;
        }

        $admin->username = $username;
        $admin->password = Hash::make($password);
        $admin->save();

        $this->info("✓ Updated admin: username={$username}, email={$email}");
        $this->line("Verification: " . ($admin->fresh()->username === $username ? 'SUCCESS' : 'FAILED'));

        return 0;
    }
}
