<?php


namespace App\Services;


use App\Models\Af;
use Illuminate\Support\Facades\DB;

class AfCommissionService
{
    public function getRealtimeCommissionQuery()
    {
        // Search for downlines
        $child =Af::whereDescendantOf(auth()->id())->get();

        // Search clients belong to child
        $queryAccounts = DB::connection('crm')->table('accounts', 'a')
                           ->select(['a.accountid', 'c.nama', 'r.rate', 'ag.id as agent_id', 'ag.agentcode', 'ag.agentname', 'ac.commission as comm_charge', 'ac.ov as or', DB::raw('IFNULL(a.bop, 0) as bop'), 'g.af_5', 'g.af_6','g.af_7','g.af_8','a.bop', DB::raw('IFNULL(max_rebate, 0) as max_rebate'), 'g.account_type'])
                           ->join('fix_rates as r', 'r.id', '=', 'a.currencyid')
                           ->join('clients as c', 'c.id', '=', 'a.userid')
                           ->join('agents_code as ac', 'ac.id', '=', 'a.comm_id')
                           ->join('agents as ag', 'ag.id', '=', 'ac.ref_id')
                           ->join('account_groups as g', 'g.id', '=', 'a.account_group_id')
                           ->whereIn('ag.id', $child->pluck('id'));

        return $queryAccounts;
    }

}
