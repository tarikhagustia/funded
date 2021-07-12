<?php

namespace App\Http\Controllers\Console\Setting;

use App\Http\Controllers\Controller;
use App\DataTables\Console\AccountTypeTable;
use Illuminate\Http\Request;
use App\Models\AccountType;

class AccountTypeController extends Controller
{
    public function index(AccountTypeTable $dataTable)
    {
        return $dataTable->render('console.account_type.index');
    }

    public function create()
    {
        return view('console.account_type.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'account_type' => 'required',
           'meta_group_name' => 'required|unique:account_types',
           'securities' => 'required',
           'rate' => 'required|numeric|min:1'
        ]);

        AccountType::create($request->only(['account_type', 'meta_group_name', 'securities', 'rate']));

        return redirect()->route('console.account-types.index')->with(['message_success' => __('Success Creating Record')]);
    }

    public function edit(AccountType $accountType)
    {
        return view('console.account_type.edit', compact('accountType'));
    }

    public function update(Request $request, AccountType $accountType)
    {
        $this->validate($request, [
            'account_type' => 'required',
            'meta_group_name' => 'required|unique:account_types,meta_group_name,'.$accountType->id,
            'securities' => 'required',
            'rate' => 'required|numeric|min:1'
        ]);
        $accountType->update($request->only(['account_type', 'meta_group_name', 'securities', 'rate']));

        return redirect()->route('console.account-types.index')->with(['message_success' => __('Success Updating Record')]);
    }

    public function destroy(AccountType $accountType)
    {
        $accountType->delete();
        return redirect()->route('console.account-types.index')->with(['message_success' => __('Success Deleting Record')]);
    }
}
