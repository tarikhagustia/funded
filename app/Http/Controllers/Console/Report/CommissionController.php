<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Console\UserDataTable;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\DataTables\Console\CommissionTable;

class CommissionController extends Controller
{
    public function index(CommissionTable $dataTable)
    {
        return $dataTable
            ->with(array(
                'report_type' => \request()->get('report_type')  ?? 'detail'
            ))
            ->render('console.report.commission.index');
    }
}
