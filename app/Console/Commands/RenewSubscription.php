<?php

namespace App\Console\Commands;

use App\Services\SubscriptionService;
use App\Services\TransactionService;
use Illuminate\Console\Command;

class RenewSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:renew-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Yenileme tarihi gelen abonelikleri otomatik ödemeyle yeniler.';

    public function __construct(private SubscriptionService $subscriptionService, private TransactionService $transactionService, private bool $paymentStatus = true)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredSubscriptions = $this->subscriptionService->expiredSubscriptions();

        foreach($expiredSubscriptions as $subscription){
            if ($this->paymentStatus) {
                $this->transactionService->create($subscription->subscriptionUser->user_id, ['subscription_id' => $subscription->id, 'price' => 150, 'status' => true]);
                $this->subscriptionService->renew($subscription->id);
            }
        }

        return 0;
    }
}
