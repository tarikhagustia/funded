<?php


namespace App\Services;


use App\Models\Af;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\AfCommission;
use Illuminate\Support\Facades\Log;

class AfCommissionService
{
    public function calculateAfCommissionFor(Carbon $carbon)
    {
        // Get all Af Accounts from af 5 to 8
        $afs = DB::connection('crm')->table('agents')
                 ->where('level_on_group', '>=', 5)->get();
        $dataSet = collect([]);
        foreach ($afs as $af) {
            $query = $this->getCommissionQuery($af);
            $result = $query->leftJoin(DB::connection('mt4')
                                         ->getDatabaseName().'.MT4_TRADES as mt', function ($join) use ($carbon) {
                $join->on('mt.LOGIN', '=', 'a.accountid')->whereIn('CMD', [0, 1])
                     ->whereDate('mt.CLOSE_TIME', '=', $carbon->format('Y-m-d'))
                     ->where(DB::raw('TIME_TO_SEC(TIMEDIFF(mt.CLOSE_TIME, mt.OPEN_TIME)) / 60'), '>=', DB::raw('g.time_limited_liquid'));
            })->groupBy('a.id');

            $newCollection = $result->get()->map(function ($row) use ($carbon, $af) {
                return [
                    'comm_date'        => $carbon->format('Y-m-d'),
                    'af_id'            => $af->id,
                    'login'            => $row->accountid,
                    'client_name'      => $row->nama,
                    'af_name'          => $row->agentname,
                    'af_level'         => $row->level_on_group,
                    'af_percentage'    => $row->{'af'.$af->level_on_group},
                    'max_rebate'       => $row->max_rebate,
                    'lot'              => $row->lot,
                    'total_commission' => $row->lot * $row->max_rebate * $row->{'af'.$af->level_on_group}
                ];
            });

            $dataSet->push($newCollection);

        }

        try {
            DB::beginTransaction();
            foreach ($dataSet as $d) {
                AfCommission::insert($d->toArray());
            }
            DB::commit();
        } catch (\Exception $exception) {
            Log::error($exception);
            DB::rollBack();
        }


    }

    public function getCommissionQuery($user = null)
    {
        // Search for downlines
        if (!$user) {
            $child = Af::descendantsAndSelf(auth()->id());
        } else {
            $child = Af::descendantsAndSelf($user->id);
        }

        // Search clients belong to child
        $queryAccounts = DB::connection('crm')->table('accounts', 'a')
                           ->select(['a.accountid', 'ag.level_on_group', 'c.nama', DB::raw('IFNULL(SUM(mt.VOLUME/100), 0) as lot'), 'r.rate', 'ag.id as agent_id', 'ag.agentcode', 'ag.agentname', 'ac.commission as comm_charge', 'ac.ov as or', DB::raw('IFNULL(a.bop, 0) as bop'), 'g.af5', 'g.af6', 'g.af7', 'g.af8', 'a.bop', DB::raw('IFNULL(cm.max_rebate, 0) as max_rebate'), 'g.type_name as account_type'])
                           ->join('fix_rates as r', 'r.id', '=', 'a.currencyid')
                           ->join('clients as c', 'c.id', '=', 'a.userid')
                           ->join('agents_code as ac', 'ac.id', '=', 'a.comm_id')
                           ->join('agents as ag', 'ag.id', '=', 'ac.ref_id')
                           ->join('account_groups as g', 'g.id', '=', 'a.account_group_id')
                           ->join('commissions as cm', 'cm.id', '=', 'g.commission_id')
                           ->whereIn('ag.id', $child->pluck('id'));

        return $queryAccounts;
    }

    public function getRealtimeCommissionQuery($user = null)
    {
        // Search for downlines
        if (!$user) {
            $child = Af::descendantsAndSelf(auth()->id());
        } else {
            $child = Af::descendantsAndSelf($user->id);
        }

        // Search clients belong to child
        $queryAccounts = DB::connection('crm')->table('accounts', 'a')
                           ->select(['a.accountid', 'ag.level_on_group', 'c.nama', 'r.rate', 'ag.id as agent_id', 'ag.agentcode', 'ag.agentname', 'ac.commission as comm_charge', 'ac.ov as or', DB::raw('IFNULL(a.bop, 0) as bop'), 'g.af5', 'g.af6', 'g.af7', 'g.af8', 'a.bop', DB::raw('IFNULL(cm.max_rebate, 0) as max_rebate'), 'g.type_name as account_type'])
                           ->join('fix_rates as r', 'r.id', '=', 'a.currencyid')
                           ->join('clients as c', 'c.id', '=', 'a.userid')
                           ->join('agents_code as ac', 'ac.id', '=', 'a.comm_id')
                           ->join('agents as ag', 'ag.id', '=', 'ac.ref_id')
                           ->join('account_groups as g', 'g.id', '=', 'a.account_group_id')
                           ->join('commissions as cm', 'cm.id', '=', 'g.commission_id')
                           ->whereIn('ag.id', $child->pluck('id'));

        return $queryAccounts;
    }

}
