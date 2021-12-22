<?php

namespace App\Console\Commands;

use App\Services\AfPerformanceService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class AfPerformanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'af:performance {date?} {dateTo?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Performance Report Affiliates and store to database';

    protected $afPerformanceService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AfPerformanceService $afPerformanceService)
    {
        parent::__construct();
        $this->afPerformanceService = $afPerformanceService;
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
            $result = $this->afPerformanceService->generatePerformanceData(Carbon::parse($commDate), Carbon::parse($commDateTo));
        } else {
            $result = $this->afPerformanceService->generatePerformanceData(now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth());
        }
        return ($result) ? 0 : 1;
    }
}
