<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Models\AfOperational;
use App\Http\Controllers\Controller;
use App\DataTables\Console\OperatingCostsTable;

class OperatingCostsController extends Controller
{
    public function index(OperatingCostsTable $dataTable)
    {
        return $dataTable->render('console.operating_costs.index');
    }

    public function show(AfOperational $model)
    {
        return view("console.operating_costs.view",compact("model"));
    }
}
