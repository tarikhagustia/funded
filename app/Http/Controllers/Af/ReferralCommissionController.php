<?php

namespace App\Http\Controllers\Af;

use App\Http\Controllers\Controller;
use App\DataTables\Af\RealtimeCommissionTable;
use App\DataTables\Af\ReferralBonusTable;
use App\Services\AfCommissionService;
use Carbon\Carbon;

class ReferralCommissionController extends Controller
{
    public function index(ReferralBonusTable $table)
    {
        return $table->with([

        ])->render('af.commissions.referral_bonus');
    }
}
