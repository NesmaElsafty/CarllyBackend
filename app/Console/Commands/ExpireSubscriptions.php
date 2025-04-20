<?php 

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserPackageSubscription;
use Carbon\Carbon;

class ExpireSubscriptions extends Command
{
    protected $signature = 'subscriptions:expire-check';
    protected $description = 'Expire user subscriptions that passed their end date';

    public function handle(): void
    {
        $expired = UserPackageSubscription::where('status', 'active')
            ->where('ends_at', '<=', now())
            ->update(['status' => 'expired']);

        $this->info("Marked $expired subscriptions as expired.");
    }
}
