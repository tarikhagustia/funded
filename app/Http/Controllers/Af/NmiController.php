<?php

namespace App\Http\Controllers\Af;

use App\DataTables\Af\NmiTable;
use App\Http\Controllers\Controller;
use App\DataTables\Af\RealtimeCommissionTable;
use App\DataTables\Af\ReferralBonusTable;
use App\Services\AfCommissionService;
use Carbon\Carbon;

class NmiController extends Controller
{
    public function index(NmiTable $table)
    {
        return $table->with([

        ])->render('af.commissions.nmi');
    }
}
