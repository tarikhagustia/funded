<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use App\DataTables\Console\Report\ReferralBonusTable;
use App\DataTables\Console\Report\ReferralBonusAffiliateSummaryTable;
use App\DataTables\Console\Report\NetMarginBonusTable;
use Illuminate\Http\Request;

class NetMarginBonusController extends Controller
{

    public function __construct()
    {
    }

    public function index(NetMarginBonusTable $dataTable)
    {
        return $dataTable->render('console.report.net_margin.index');
    }
}
