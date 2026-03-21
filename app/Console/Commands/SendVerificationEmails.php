<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Mail\EmailVerificationMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendVerificationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:send-verification {--dry-run : Show what would be sent without actually sending}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email verification links to all customers who have not verified their email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        // Get all customers without verified emails
        $customers = Customer::whereNull('email_verified_at')->get();
        
        if ($customers->isEmpty()) {
            $this->info('All customers have already verified their emails!');
            return 0;
        }
        
        $this->info("Found {$customers->count()} customers without verified emails.");
        
        if ($dryRun) {
            $this->warn('DRY RUN MODE - No emails will be sent.');
            $this->table(
                ['Name', 'Email', 'Current Token'],
                $customers->map(fn($c) => [$c->name, $c->email, $c->verification_token ?? 'NONE'])
            );
            return 0;
        }
        
        $bar = $this->output->createProgressBar($customers->count());
        $bar->start();
        
        $sent = 0;
        $failed = 0;
        
        foreach ($customers as $customer) {
            // Generate verification token if not exists
            if (!$customer->verification_token) {
                $customer->verification_token = Str::random(64);
                $customer->save();
            }
            
            $verificationUrl = route('customer.verify', ['token' => $customer->verification_token]);
            
            try {
                Mail::to($customer->email)->send(new EmailVerificationMail($verificationUrl, $customer->name));
                $sent++;
                $this->line(" ✓ Sent to {$customer->email}");
            } catch (\Exception $e) {
                $failed++;
                // Store in session for demo mode
                session(['verify_token' => $customer->verification_token, 'verify_email' => $customer->email]);
                $this->warn(" ✗ Failed for {$customer->email}: {$e->getMessage()}");
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("Summary:");
        $this->info("  - Emails sent: {$sent}");
        $this->info("  - Failed: {$failed}");
        
        if ($failed > 0) {
            $this->warn("Note: Failed emails are stored in session. Check session data for verification links.");
        }
        
        return 0;
    }
}

