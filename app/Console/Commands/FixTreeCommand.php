<?php

namespace App\Console\Commands;

use App\Models\Af;
use Illuminate\Console\Command;

class FixTreeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:fix:tree';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to fix tree member data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Af::fixTree();
        return 0;
    }
}
