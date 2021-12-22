<?php

namespace App\Http\Controllers\Console\Report;

use App\DataTables\Console\Report\AffiliatePerformanceTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Console\UserDataTable;
use App\Models\Admin;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\DataTables\Console\WithdrawalTable;

class AffiliatePerformanceController extends Controller
{
    public function index(AffiliatePerformanceTable $dataTable)
    {
        return $dataTable->render('console.report.af_performance.index');
    }
}
