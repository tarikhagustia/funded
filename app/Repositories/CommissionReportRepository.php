<?php

namespace App\Repositories;

use App\Models\Af;
use Illuminate\Support\Facades\DB;

class CommissionReportRepository
{

    public function getQueryByCountryManager()
    {
        $query = DB::table(DB::connection('crm')->getDatabaseName() . ".agents as a")
            ->join(DB::connection('crm')->getDatabaseName() . ".agents as a2", function ($join) {
                $join->on('a2._lft', '>=', DB::raw('a._lft + 1'));
                $join->on('a2._lft', '<=', 'a._rgt');
            })
            ->join("transactions as t", function ($join) {
                $join->on("a2.id", "=", "t.af_id");
            })
            ->selectRaw("a.id,
            a.agentname,
            a.level_on_group,
            SUM(t.lot) as lot,
            SUM(t.comm) as comm,
            SUM(t.comm_idr) as comm_idr,
            SUM(t.`or`) as `or`,
            SUM(t.bop) as bop,
            SUM(t.bop_idr) as bop_idr,
            SUM(t.net_margin_in_out) as net_margin_in_out,
            SUM(t.profit_loss) as profit_loss")
            ->where("a.level_on_group", "=", 5)
            ->groupBy("a.id");

        return $query;
    }
}
