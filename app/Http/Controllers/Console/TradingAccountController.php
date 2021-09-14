<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Console\TradingAccountDataTable;
use App\Models\Account;

class TradingAccountController extends Controller
{
    public function index(TradingAccountDataTable $dataTable)
    {
        return $dataTable->render('console.trading_accounts.index');
    }

    public function show(Account $account)
    {
        $tabs = [
            'trades' => 'Trades',
        ];
        
        return view("console.trading_accounts.show",[
            'account' => $account,
            'tabs' => $tabs,
        ]);
    }
}
