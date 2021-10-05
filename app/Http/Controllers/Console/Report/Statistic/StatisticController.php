<?php

namespace App\Http\Controllers\Console\Report\Statistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Console\UserDataTable;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\DataTables\Console\CommissionTable;
use App\DataTables\Console\Report\SymbolTable;

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

}
