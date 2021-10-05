<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Console\UserDataTable;
use App\Models\Admin;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\DataTables\Console\WithdrawalTable;

class WithdrawalController extends Controller
{
    public function index(WithdrawalTable $dataTable)
    {
        return $dataTable->render('console.report.withdrawal.index');
    }
}
