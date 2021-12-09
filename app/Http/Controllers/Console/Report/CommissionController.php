<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Console\UserDataTable;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\DataTables\Console\CommissionTable;
use App\DataTables\Console\Report\CommissionReportByCountryManager;
use App\Repositories\CommissionReportRepository;

class CommissionController extends Controller
{
    protected $commissionReportByCountryManager;

    public function __construct(CommissionReportByCountryManager $commissionReportByCountryManager)
    {
        $this->commissionReportByCountryManager = $commissionReportByCountryManager;
    }
    public function index(CommissionTable $dataTable)
    {
        if (request()->get('report_type') == "af_5") {
            return $this->commissionReportByCountryManager
                ->with(array(
                    'report_type' => \request()->get('report_type')  ?? 'detail'
                ))
                ->render('console.report.commission.index');
        }
        return $dataTable
            ->with(array(
                'report_type' => \request()->get('report_type')  ?? 'detail'
            ))
            ->render('console.report.commission.index');
    }
}
