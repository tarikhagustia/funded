<?php

namespace App\Http\Controllers\Af;

use App\Http\Controllers\Controller;
use App\DataTables\Af\RealtimeCommissionTable;
use App\Services\AfCommissionService;
use Carbon\Carbon;

class RealtimeCommissionController extends Controller
{
    public function index(RealtimeCommissionTable $table, AfCommissionService $afCommissionService)
    {
        $afCommissionService->getRealtimeCommissionQuery();

        return $table->with([

        ])->render('af.commissions.realtime');
    }
}
