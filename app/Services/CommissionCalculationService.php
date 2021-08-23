<?php


namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CommissionCalculationService
{
    public function calculateCommissionFor(Carbon $date)
    {
        $queryAccounts = DB::connection('crm')->table('accounts', 'a')
                           ->select(['a.accountid', 'c.nama', 'r.rate', 'ag.id as agent_code', 'ag.agentname', 'ac.commission as comm_charge', 'ac.commission as or', 'ac.commission as bop'])
                           ->join('fix_rates as r', 'r.id', '=', 'a.currencyid')
                           ->join('clients as c', 'c.id', '=', 'a.userid')
                           ->join('agents_code as ac', 'ac.id', '=', 'a.comm_id')
                           ->join('agents as ag', 'ag.id', '=', 'ac.ref_id')
                           ->where('a.accountid', 8000289);
        // Get MetaTrader Information
        $queryLot = DB::connection('mt4')->table('MT4_TRADES', 't')
                      ->select(['u.LOGIN', 'u.NAME', 'u.CREDIT', 'u.EQUITY', 'u.BALANCE', DB::raw('SUM(t.VOLUME / 100) as LOT')])
                      ->join('MT4_USERS as u', 'u.LOGIN', '=', 't.LOGIN')
                      ->whereIn('u.LOGIN', $queryAccounts->pluck('a.accountid'))
                      ->whereBetween('t.CLOSE_TIME', [$date->format('Y-m-d').' 00:00:00', $date->format('Y-m-d').' 23:59:59'])
                      ->groupBy('t.LOGIN')->get();

        // Get daily transaction
        $queryDaily = DB::connection('mt4')->table('MT4_DAILY', 'd')
                        ->whereDate('TIME', $date->format('Y-m-d'))
                        ->whereIn('d.LOGIN', $queryAccounts->pluck('a.accountid'))->get();


        $results = $queryAccounts->get()->map(function ($q) use ($queryLot, $queryDaily) {
            // Find the match
            $tradeData = $queryLot->where('LOGIN', (int)$q->accountid)->first();
            $dailyData = $queryDaily->where('LOGIN', (int)$q->accountid)->first();
            $q->lot = floatval($tradeData->LOT);
            $q->nama = floatval($tradeData->NAME);
            $q->current_equity = floatval($tradeData->EQUITY);
            $q->current_balance = floatval($tradeData->BALANCE);
            $q->name_mt4 = $tradeData->NAME;
            $q->comm_idr = $q->lot * $q->rate;
            $q->or_idr = $q->lot * $q->or;
            $q->bop_idr = $q->lot * $q->bop;
            $q->total_rebate = $q->comm_idr + $q->or_idr + $q->bop_idr;
            $q->prev_equity = floatval($dailyData->EQUITY);
            $q->credit = floatval($q->current_equity);
            $q->net_margin_in_out = $dailyData->MARGIN + $dailyData->DEPOSIT;
            $q->net_equity = $q->current_equity - $q->credit;
            $q->profit_loss = $q->prev_equity + $q->net_margin_in_out - $q->net_equity;
            $q->net_profit_loss = $q->profit_loss - $q->total_rebate;
            $q->agent_percentage = 0.05; // TODO : harus dinamis
            $q->agent_pl = $q->net_profit_loss * $q->agent_percentage;
            $q->holding_pl = $q->net_profit_loss - $q->agent_pl;
            return $q;
        });
        dd($results);
        return 0;
    }
}
