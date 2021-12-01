<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NetMarginBonusService
{
    private $dateFrom;
    private $dateTo;
    public function generate(Carbon $dateFrom, Carbon $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        // AF8 -> A.1
        $this->generateAf8A();
    }

    public function generateAf8A()
    {
        $commissionData = collect();
        $hasGetCommission = [];

        $subQuery = DB::table('transactions', 't')
            ->selectRaw('t.af_id, COUNT(login) as new_member, SUM(initial.initial_margin) as initial_margin')
            ->join(DB::raw("(SELECT
                a.accountid,
                sum(t.amount) as initial_margin
            FROM
                bfx_crm.transactions t
            INNER JOIN bfx_crm.accounts a ON
                a.id = t.accid
            WHERE
                t.transaction_type = 1 AND t.amount >= 150
            group by
                a.accountid) as initial"), function ($join) {
                $join->on('t.login', '=', 'initial.accountid');
            })
            ->whereBetween('registration_date', [$this->dateFrom, $this->dateTo])->groupBy(['t.af_id', 't.login']);

        $agents = DB::table('transactions', 't')
            ->selectRaw('t.af_id, t.af_name, SUM(net_margin_in_out) as total_net_margin, SUM(lot) as total_lot, initial.new_member, initial.initial_margin')
            ->joinSub($subQuery, 'initial', function ($join) {
                $join->on('t.af_id', '=', 'initial.af_id');
            })
            ->having(DB::raw('SUM(net_margin_in_out)'), '>=', 10000)
            ->having(DB::raw('SUM(lot)'), '>=', 10)
            ->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo])->groupBy('af_id');

        foreach ($agents->get() as $row) {
            $hasGetCommission[] = $row->af_id;
            $commissionData->push([
                'comm_from_date' => $this->dateFrom->format('Y-m-d H:i:s'),
                'comm_to_date' => $this->dateTo->format('Y-m-d H:i:s'),
                'af_id' => $row->af_id,
                'af_name' => $row->af_name,
                'total_net_margin' => $row->total_net_margin,
                'total_lot' => $row->total_lot,
                'total_member' => $row->new_member,
                'total_commission' => 200,
                'status' => 'Unpaid'
            ]);
        }

        // Calculate for TYPE A.2
    }
}
