<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use App\DataTables\Console\Report\ReferralBonusTable;

class ReferralBonusController extends Controller
{
    public function index(ReferralBonusTable $dataTable)
    {
        return $dataTable->render('console.report.referral_bonus.index');
    }
}
