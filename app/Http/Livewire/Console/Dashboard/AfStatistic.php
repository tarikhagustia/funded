<?php

namespace App\Http\Livewire\Console\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Af;
use App\Models\Client;

class AfStatistic extends Component
{
    public $dateStart;
    public $dateEnd;
    public $totalDeposit;
    public $totalWithdrawal;
    public $totalActiveAf;
    public $totalInactiveAf;
    public $gainers     = [];
    public $totalAf     = 1;
    public $totalAfMale;
    public $totalAfFemale;
    public $totalClient = 1;
    public $totalClientMale;
    public $totalClientFemale;


    protected $listeners = [
        'filterDateChanged2' => 'setFilterDate'
    ];

    public function mount()
    {
        // TODO : change to current start of week
        $this->dateStart = now()->startOfYear()->format('Y-m-d');
        $this->dateEnd = now()->endOfWeek()->format('Y-m-d');


    }

    public function setFilterDate($date)
    {
        $this->dateStart = $date['date_start'];
        $this->dateEnd = $date['date_end'];

        $this->initialLoading();
    }

    public function initialLoading()
    {
        $this->fetchTotal();

        $this->fetchGainer();

        $this->fetchGender();

    }

    public function fetchTotal()
    {
        $this->totalWithdrawal = DB::connection('mt4')->table('MT4_TRADES')->where('CMD', 6)->where('PROFIT', '<', 0)
                                   ->whereDate('CLOSE_TIME', '>=', $this->dateStart)
                                   ->whereDate('CLOSE_TIME', '<=', $this->dateEnd)
                                   ->sum(DB::raw('ABS(PROFIT)'));
        $this->totalDeposit = DB::connection('mt4')->table('MT4_TRADES')->where('CMD', 6)->where('PROFIT', '>', 0)
                                ->whereDate('CLOSE_TIME', '>=', $this->dateStart)
                                ->whereDate('CLOSE_TIME', '<=', $this->dateEnd)
                                ->sum('PROFIT');
        $this->totalActiveAf = DB::connection('crm')->table('agents')->where('status', 1)->count();
        $this->totalInactiveAf = DB::connection('crm')->table('agents')->where('status', 2)->count();
    }

    public function fetchGainer()
    {
        $query = DB::connection('mt4')->table('MT4_TRADES', 'mt')
                   ->join('MT4_USERS as u', 'u.LOGIN', '=', 'mt.LOGIN')
                   ->select(['mt.LOGIN', DB::raw('SUM(PROFIT) as TOTAL'), 'u.EMAIL', 'u.NAME'])
                   ->whereIn('CMD', [1, 0])
                   ->whereDate('mt.CLOSE_TIME', '>=', $this->dateStart)
                   ->whereDate('mt.CLOSE_TIME', '<=', $this->dateEnd)
                   ->groupBy('u.LOGIN')
                   ->orderByRaw('SUM(PROFIT) DESC');
        return $this->gainers = $query->take(6)->get();
    }

    public function fetchGender()
    {
        $this->totalAf = Af::query()->count();
        $this->totalAfMale = Af::query()->where('gender', 1)->count();
        $this->totalAfFemale = Af::query()->where('gender', 2)->count();

        $this->totalClient = Client::query()->count();
        $this->totalClientMale = Client::query()->where('gender', 0)->count();
        $this->totalClientFemale = Client::query()->where('gender', 1)->count();
    }

    public function render()
    {
        return view('livewire.console.dashboard.af-statistic');
    }
}
