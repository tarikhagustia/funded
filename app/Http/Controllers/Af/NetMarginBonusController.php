<?php

namespace App\Http\Controllers\Af;

use App\DataTables\Af\NetMarginBonusTable;
use App\Http\Controllers\Controller;
use App\DataTables\Af\RealtimeCommissionTable;
use App\DataTables\Af\ReferralBonusTable;
use App\Services\AfCommissionService;
use Carbon\Carbon;

class NetMarginBonusController extends Controller
{
    public function index(NetMarginBonusTable $table)
    {
        return $table->with([

        ])->render('af.commissions.net_margin_bonus');
    }
}
