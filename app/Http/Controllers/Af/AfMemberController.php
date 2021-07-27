<?php

namespace App\Http\Controllers\Af;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Console\AfMemberTable;

class AfMemberController extends Controller
{
    public function index(AfMemberTable $dataTable)
    {
        return $dataTable->render('af.members.af_member');
    }
}
