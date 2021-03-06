<?php

namespace App\Http\Controllers\Console\Report\Statistic;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\TransactionType;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\DataTables\Console\UserDataTable;
use App\DataTables\Console\CommissionTable;
use App\DataTables\Console\Report\SymbolTable;
use App\DataTables\Console\Report\AffiliateCommissionTable;
use App\DataTables\Console\Report\TopGainerTable;
use App\DataTables\Console\Report\TopLooserTable;
use App\DataTables\Console\Report\TopNewMemberTable;
use App\DataTables\Console\Report\TopCommissionTable;
use App\Models\Af;

class StatisticController extends Controller
{
    public function index()
    {
        return view('console.report.statistic.index');
    }

    public function symbol(SymbolTable $dataTable)
    {
        return $dataTable->render('console.report.statistic.symbol');
    }

    public function topCommission(TopCommissionTable $dataTable)
    {
        return $dataTable->render('console.report.statistic.top-commission');
    }

    public function topNewMember(TopNewMemberTable $dataTable)
    {

        return $dataTable->render('console.report.statistic.top-new-member');
    }

    public function topGainer(TopGainerTable $dataTable)
    {

        return $dataTable->render('console.report.statistic.top-gainer');
    }

    public function topLooser(TopLooserTable $dataTable)
    {

        return $dataTable->render('console.report.statistic.top-looser');
    }

    public function affiliateCommission(AffiliateCommissionTable $dataTable)
    {

        return $dataTable->render('console.report.statistic.affiliate-commission');
    }

    public function treeViewReport()
    {
        $af = Af::where('level_on_group', 8)->get();
        return view('console.report.statistic.treeview', compact('af'));
    }

    public function callMe()
    {
    }

}
