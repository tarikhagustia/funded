<?php

namespace App\Services;

use App\Models\AfTarget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AfPerformanceService
{
    public function generatePerformanceData(Carbon $dateFrom, Carbon $dateTo)
    {
        $subQuery = DB::table(DB::connection('crm')->getDatabaseName() . '.agents as a')->selectRaw('a.parentid, a.level_on_group, COUNT(a.id) as active_af')
            ->where('a.status', 1)
            ->groupBy(['a.parentid', 'a.level_on_group']);
        $query = DB::table(DB::connection('crm')->getDatabaseName() . ".agents as a")
            ->join(DB::connection('crm')->getDatabaseName() . ".agents as a2", function ($join) {
                $join->on('a2._lft', '>=', DB::raw('a._lft + 1'));
                $join->on('a2._lft', '<=', 'a._rgt');
            })
            ->join("transactions as t", function ($join) {
                $join->on("a2.id", "=", "t.af_id");
            })
            ->join("af_levels as l", function ($join) {
                $join->on("a.level_on_group", "=", "l.id");
            })
            ->joinSub($subQuery, 'active_downline', function ($join) {
                $join->on('a.id', '=', 'active_downline.parentid');
                // ->where('active_downline.level_on_group', 5);
            })
            ->selectRaw("a.id,
            l.target_new_member,
            l.target_nmi,
            l.target_maintain_downline,
            a.agentname,
            a.level_on_group,
            active_downline.active_af,
            SUM(IF(t.transaction_date =  DATE(registration_date), 1, 0)) as new_member,
            SUM(t.net_margin_in_out) as net_margin_in_out,
            IF(SUM(IF(t.transaction_date =  DATE(registration_date), 1, 0)) >= l.target_new_member AND l.target_new_member > 0 OR SUM(t.net_margin_in_out) >= l.target_nmi OR l.target_maintain_downline > 0 AND active_downline.active_af >= l.target_maintain_downline, 1, 0) AS is_passed
            ")
            // ->where("a.level_on_group", "=", 5)
            // ->where('a.id', 908)
            ->whereBetween("t.transaction_date", [$dateFrom, $dateTo])
            ->groupBy("a.id");
        // $result = $query->get()->map(function($obj){
        //     $obj->is_passed = ((int) $obj->new_member >= $obj->target_new_member || $obj->net_margin_in_out >= $obj->target_nmi);
        //     return $obj;
        // });

        $result = $query->get()->map(function ($obj) use ($dateFrom, $dateTo) {
            return [
                'date_from' => $dateFrom->format('Y-m-d'),
                'date_to' => $dateTo->format('Y-m-d'),
                'af_id' => $obj->id,
                'af_name' => $obj->agentname,
                'new_member' => $obj->new_member,
                'net_margin' => $obj->net_margin_in_out,
                'maintain_downline' => $obj->new_member,
                'maintain_downline' => $obj->active_af,
                'is_passed' => $obj->is_passed,
                'created_at' => now(),
            ];
        });

        AfTarget::insert($result->toArray());
    }
}
