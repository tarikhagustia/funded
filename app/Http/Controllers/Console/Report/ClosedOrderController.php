<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Console\UserDataTable;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\DataTables\Console\CommissionTable;
use App\DataTables\Console\ClosedOrderTable;

class ClosedOrderController extends Controller
{
    public function index(ClosedOrderTable $dataTable)
    {
        return $dataTable->render('console.report.closed_order.index');
    }
}
