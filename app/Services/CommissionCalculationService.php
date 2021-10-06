<?php


namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class CommissionCalculationService
{
    public function calculateCommissionFor(Carbon $date)
    {
        $queryAccounts = DB::connection('crm')->table('accounts', 'a')
                           ->select(['a.accountid', 'agr.type_name as account_type', 'cm.max_rebate', 'c.nama', 'r.rate', 'ag.id as agent_id', 'ag.agentcode', 'ag.agentname', 'ac.commission as comm_charge', 'ac.ov as or', DB::raw('IFNULL(a.bop, 0) as bop')])
                           ->join('account_groups as agr', 'agr.id', '=', 'a.account_group_id')
                           ->join('commissions as cm', 'cm.id', '=', 'agr.commission_id')
                           ->join('fix_rates as r', 'r.id', '=', 'a.currencyid')
                           ->join('clients as c', 'c.id', '=', 'a.userid')
                           ->join('agents_code as ac', 'ac.id', '=', 'a.comm_id')
                           ->join('agents as ag', 'ag.id', '=', 'ac.ref_id')->get();


        // Get MetaTrader Information
        $queryLot = DB::connection('mt4')->table('MT4_TRADES', 't')
                      ->select(['u.REGDATE', 'u.LOGIN', 'u.GROUP', 'u.NAME', 'u.CREDIT', 'u.EQUITY', 'u.BALANCE', DB::raw('SUM(t.VOLUME / 100) as LOT')])
                      ->join('MT4_USERS as u', 'u.LOGIN', '=', 't.LOGIN')
                      ->whereIn('u.LOGIN', $queryAccounts->pluck('accountid'))
                      ->whereBetween('t.CLOSE_TIME', [$date->format('Y-m-d').' 00:00:00', $date->format('Y-m-d').' 23:59:59'])
                      ->groupBy('t.LOGIN')->get()->keyBy('LOGIN');


        // Get daily transaction
        $queryDaily = DB::connection('mt4')->table('MT4_DAILY', 'd')
                        ->whereDate('TIME', $date->format('Y-m-d'))
                        ->whereIn('d.LOGIN', $queryAccounts->pluck('accountid'))->get()->keyBy('LOGIN');

        $prev = clone $date;
        if ($prev->dayOfWeek == Carbon::MONDAY) {
            $prev->subDays(3);
        }else{
            $prev->subDay();
        }

        $queryDailyPrev = DB::connection('mt4')->table('MT4_DAILY', 'd')
                            ->whereDate('TIME', $prev->format('Y-m-d'))
                            ->whereIn('d.LOGIN', $queryAccounts->pluck('accountid'))->get()->keyBy('LOGIN');


        $results = $queryAccounts->map(function ($row) use ($queryLot, $queryDaily, $date, $queryDailyPrev) {
            $tradeData = isset($queryLot[(int)$row->accountid]) ? $queryLot[(int)$row->accountid] : null;
            $dailyData = isset($queryDaily[(int)$row->accountid]) ? $queryDaily[(int)$row->accountid] : null;
            $prevData = isset($queryDailyPrev[(int)$row->accountid]) ? $queryDailyPrev[(int)$row->accountid] : null;
            if (!$tradeData || !$dailyData || !$prevData) return [];
            $q = new \stdClass();
            $q->transaction_date = $date->format('Y-m-d');
            $q->af_code = $row->agent_id;
            $q->login = $row->accountid;
            $q->meta_group = $tradeData->GROUP;
            $q->client_name = $tradeData->NAME;
            $q->rate = $row->rate;
            $q->af_code_numeric = $row->agent_id;
            $q->af_name = $row->agentname;
            $q->af_id = $row->agent_id;
            $q->lot = floatval($tradeData->LOT);
            $q->comm = $row->comm_charge;
            $q->or = $row->or;
            $q->or_idr = $q->lot * $q->or * $q->rate;
            $q->bop = $row->bop;
            $q->bop_idr = $q->lot * $q->bop * $q->rate;
            $q->comm_idr = $q->lot * $q->comm * $q->rate;
            $q->total_rebate = $q->comm_idr + $q->or_idr + $q->bop_idr;
            $q->prev_equity = floatval($prevData->EQUITY);
            $q->net_margin_in_out = $dailyData->DEPOSIT;
            $q->current_equity = floatval($dailyData->EQUITY);
            $q->credit = floatval($dailyData->CREDIT);
            $q->net_equity = $q->current_equity - $q->credit;
            $q->agent_percentage = 0.05; // TODO : harus dinamis
            $q->profit_loss = $q->prev_equity + $q->net_margin_in_out - $q->net_equity;
            $q->net_profit_loss = $q->profit_loss - $q->total_rebate;
            $q->agent_pl = $q->net_profit_loss * $q->agent_percentage;
            $q->holding_pl = $q->net_profit_loss - $q->agent_pl;
            $q->remark_adjustment = 0;
            $q->nominal_adjustment = 0;
            $q->lot_adjustment = 0;
            $q->registration_date = $tradeData->REGDATE;
            $q->ac_type = $row->account_type;
            $q->max_rebate = $row->max_rebate;
            return (array)$q;
        })->filter(function ($row) {
            return count($row) == 0 ? false : true;
        });

        $data = $results->chunk(100)->toArray();

        foreach ($data as $d) {
            Transaction::insert($d);
        }
        return 0;
    }
}
