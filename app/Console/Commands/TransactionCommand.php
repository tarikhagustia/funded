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
    protected $signature = 'transaction:get {date?}';

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
        if ($commDate) {
            $commDate = Carbon::parse($commDate);
        }else{
            $commDate = now();
        }
        return $this->commissionCalculationService->calculateCommissionFor($commDate);
    }
}
