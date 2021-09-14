<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Console\ClientDataTable;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(ClientDataTable $dataTable)
    {
        return $dataTable->render('console.clients.index');
    }

    public function show(Client $client)
    {
        $tabs = [
            'trading_accounts' => 'Trading Accounts',
        ];
        
        return view("console.clients.show",[
            'client' => $client,
            'tabs' => $tabs,
        ]);
    }
}
