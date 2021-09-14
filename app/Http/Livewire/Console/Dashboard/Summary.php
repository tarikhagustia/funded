<?php

namespace App\Http\Livewire\Console\Dashboard;

use Livewire\Component;
use App\Models\Af;
use App\Models\Client;
use App\Models\AfCommission;
use Illuminate\Support\Facades\DB;

class Summary extends Component
{
    public $totalAffiliate;
    public $totalActiveClient;
    public $totalThisWeekCommission;
    public $totalNewClient;

    public function mount()
    {
        $this->totalAffiliate = Af::count();
        $this->totalActiveClient = Client::count();
        $this->totalThisWeekCommission = AfCommission::sum('total_commission');
        $this->totalNewClient = DB::connection('mt4')->table('MT4_USERS')->whereDate('REGDATE', now())->count();
    }

    public function render()
    {
        return view('livewire.console.dashboard.summary');
    }
}
