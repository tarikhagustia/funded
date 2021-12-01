<?php

namespace App\Console\Commands;

use App\Services\NetMarginBonusService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NetMarginBonusCommand extends Command
{
    protected $netMarginBonusService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bonus:net-margin {date?} {dateTo?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bonus to calculate net margin based on date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NetMarginBonusService $netMarginBonusService)
    {
        parent::__construct();
        $this->netMarginBonusService = $netMarginBonusService;
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
        return $this->netMarginBonusService->generate(Carbon::parse($commDate), Carbon::parse($commDateTo));
    }
}
