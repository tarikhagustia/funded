<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\AfCommissionService;

class AfCommissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'af:commission:get {date?} {dateTo?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var AfCommissionService
     */
    private $afCommissionService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AfCommissionService $afCommissionService)
    {
        parent::__construct();
        $this->afCommissionService = $afCommissionService;
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
            return $this->afCommissionService->calculateAfCommissionFor($commDate);

        }else{
            foreach (range(1, $commDate->diffInDays(Carbon::parse($commDateTo)) + 1) as $d) {
                $this->info('Generating for date '.$d);
                $this->afCommissionService->calculateAfCommissionFor(Carbon::create($commDate->year, $commDate->month, $d));
            }
            return 0;
        }
    }
}
