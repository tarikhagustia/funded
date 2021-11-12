<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\CommissionCalculationService;
use App\Services\AfReferralBonusService;

class ReferralBonusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'af:commission:referral:get {date?} {dateTo?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Referral Commission by date';
    /**
     * @var AfReferralBonusService
     */
    private $afReferralBonusService;


    /**
     * TransactionCommand constructor.
     * @param AfReferralBonusService $afReferralBonusService
     */
    public function __construct(AfReferralBonusService $afReferralBonusService)
    {
        $this->afReferralBonusService = $afReferralBonusService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $commDate = $this->argument('date');
        $commDateTo = $this->argument('dateTo');
        if ($commDate) {
            $commDate = Carbon::parse($commDate);
        } else {
            $commDate = now();
        }
        if (!$commDateTo) {
            $this->info('Generating for date '.$commDate->format('Y-m-d'));
            return $this->afReferralBonusService->calculateCommissionFor($commDate);
        } else {
            foreach (range(1, $commDate->diffInDays(Carbon::parse($commDateTo)) + 1) as $d) {

                $this->info('Generating for date '.$commDate->format('Y-m-d'));
                $this->afReferralBonusService->calculateCommissionFor($commDate);
                $commDate->addDays();
            }
            return 0;
        }
    }
}
