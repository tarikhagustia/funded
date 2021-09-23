<?php

namespace App\Http\Livewire\Console\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TradingStatistic extends Component
{
    public $dateStart;
    public $dateEnd;
    public $records    = [];
    public $orders     = [];
    public $mostOrders = [];

    protected $listeners = [
        'filterDateChanged' => 'setFilterDate'
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
        // $this->fetchSymbol();

        $this->fetchOrders();
        //
        $this->fetchMostOrders();
    }

    public function fetchSymbol()
    {

        $query = DB::connection('mt4')
                   ->table('MT4_PRICES', 's')->join('MT4_TRADES as mt', 'mt.SYMBOL', '=', 's.SYMBOL')
                   ->select(
                       [
                           's.SYMBOL as symbol',
                           's.BID as bid',
                           's.ASK as ask',
                           DB::raw('COUNT(mt.TICKET) as total_position'),
                           DB::raw('SUM(mt.VOLUME / 100) as total_lot'),
                           DB::raw('SUM(mt.PROFIT) as total_profit'),
                       ])
                   ->whereIn('mt.CMD', [1, 0])
                   ->whereYear('mt.CLOSE_TIME', 1970)
                   ->whereDate('mt.OPEN_TIME', '>=', $this->dateStart)
                   ->whereDate('mt.OPEN_TIME', '<=', $this->dateEnd)
                   ->groupBy('s.SYMBOL')
                   ->orderByRaw('COUNT(mt.TICKET) DESC')->take(5);
        // dd($query->toSql());
        $this->records = $query->get();

        // dump($this->records);
    }

    public function fetchOrders()
    {
        $query = DB::connection('mt4')
                   ->table('MT4_TRADES', 'mt')
                   ->select([
                       'TICKET', 'mt.LOGIN', 'mt.SYMBOL', 'mt.OPEN_TIME', 'mt.CLOSE_TIME', 'mt.VOLUME', DB::raw('(TIME_TO_SEC(TIMEDIFF(mt.CLOSE_TIME, mt.OPEN_TIME)) / 60) as LQ_TIME')
                   ])
            // ->join(DB::connection('crm')->getDatabaseName().".accounts as a", 'a.accountid', '=', 'mt.LOGIN')
            // ->join(DB::connection('crm')
            //          ->getDatabaseName().".account_groups as g", 'g.id', '=', 'a.account_group_id')
                   ->whereYear('mt.CLOSE_TIME', '!=', 1970)
                   ->where(DB::raw('(TIME_TO_SEC(TIMEDIFF(mt.CLOSE_TIME, mt.OPEN_TIME)) / 60)'), '<', 3)
                   ->whereIn('mt.CMD', [1, 0])
                   ->whereDate('mt.OPEN_TIME', '>=', $this->dateStart)
                   ->whereDate('mt.OPEN_TIME', '<=', $this->dateEnd)
                   ->limit(5)
                   ->orderByDesc('mt.TICKET');
        // ->orderBy('mt.TICKET', 'desc');
        $this->orders = $query->get();
    }

    public function fetchMostOrders()
    {
        $query = DB::connection('mt4')
                   ->table('MT4_TRADES', 'mt')
                   ->select([
                       'mt.LOGIN', 'u.NAME', DB::raw('COUNT(mt.TICKET) as TOTAL')
                   ])
                   ->join('MT4_USERS as u', 'u.LOGIN', '=', 'mt.LOGIN')
                   ->whereIn('mt.CMD', [1, 0])
                   ->whereDate('mt.OPEN_TIME', '>=', $this->dateStart)
                   ->whereDate('mt.OPEN_TIME', '<=', $this->dateEnd)
                   ->groupBy('u.LOGIN')
                   ->orderBy(DB::raw('COUNT(mt.TICKET)'), 'desc')
                   ->take(5);

        $this->mostOrders = $query->get();

    }

    public function render()
    {
        return view('livewire.console.dashboard.trading-statistic');
    }
}
