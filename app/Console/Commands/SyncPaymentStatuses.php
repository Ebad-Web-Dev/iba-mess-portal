<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SyncPaymentStatuses extends Command
{
    protected $signature = 'sync:payment-statuses';
    protected $description = 'Synchronize payment statuses from secondary to primary database';

    public function handle()
    {
        $this->info('Starting payment status synchronization...');
        
        try {
            // Option 1: If you have any timestamp column in online_payment_logs
            // Replace 'created_at' with whatever timestamp column exists
            $lastSync = Cache::get('last_payment_sync', now()->subDay());
            
            // Get all current paid records (without time filtering)
            $paymentStatuses = DB::connection('mysql2')
                ->table('online_payment_logs')
                ->where('current_status', 'Paid')
                ->pluck('current_status', 'uid')
                ->toArray();
            
            if (empty($paymentStatuses)) {
                $this->info('No paid subscriptions found in payment logs.');
                return;
            }
            
            $paidUids = array_keys($paymentStatuses);
            $this->info('Found ' . count($paidUids) . ' paid subscriptions to check.');
            
            // Update primary database
            $updatedCount = Subscription::whereIn('uid', $paidUids)
                ->where('voucher_status', '!=', 'Paid')
                ->update([
                    'voucher_status' => 'Paid',
                    'payment_updated_at' => now()
                ]);
            
            // Update last sync time
            Cache::put('last_payment_sync', now(), now()->addDay());
            
            $this->info("Successfully updated {$updatedCount} subscriptions.");
            
            // Log the sync operation
            Log::info("Payment status sync completed. Updated {$updatedCount} records.", [
                'uids' => $paidUids,
                'sync_time' => now()
            ]);
            
        } catch (\Exception $e) {
            $this->error("Error during sync: " . $e->getMessage());
            Log::error("Payment status sync failed: " . $e->getMessage(), [
                'exception' => $e
            ]);
        }
    }
}