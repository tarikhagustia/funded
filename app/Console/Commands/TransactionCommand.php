<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\CommissionCalculationService;

class TransactionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:get {date?} {dateTo?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Transaction By Date';
    /**
     * @var CommissionCalculationService
     */
    private $commissionCalculationService;


    /**
     * TransactionCommand constructor.
     * @param CommissionCalculationService $commissionCalculationService
     */
    public function __construct(CommissionCalculationService $commissionCalculationService)
    {
        $this->commissionCalculationService = $commissionCalculationService;
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
        }else{
            $commDate = now();
        }
        if (!$commDateTo) {
            dump($commDate);
            return $this->commissionCalculationService->calculateCommissionFor($commDate);
        }else{
            foreach (range(1, $commDate->diffInDays(Carbon::parse($commDateTo)) + 1) as $d) {

                $this->info('Generating for date '.$commDate->format('Y-m-d'));
                $this->commissionCalculationService->calculateCommissionFor($commDate);
                $commDate->addDays();
            }
            return 0;
        }
    }
}
