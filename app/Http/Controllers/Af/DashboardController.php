<?php

namespace App\Http\Controllers\Af;

use App\Models\Af;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\AfCommission;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAffiliate = auth()->user()->childs->count();
        $totalActiveClient = auth()->user()->clients->count();
        $totalThisWeekCommission = auth()->user()->commissions->sum('total_commission');

        return view('af.index',compact("totalAffiliate","totalActiveClient","totalThisWeekCommission"));
    }
}
