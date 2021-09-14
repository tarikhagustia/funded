<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Console\AfDataTable;
use App\Models\Admin;
use App\Models\Af;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AfController extends Controller
{
    public function index(AfDataTable $dataTable)
    {
        return $dataTable->render('console.affiliates.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('console.users.create', compact('roles'));
    }

    function show(Af $affiliate){
        return view('console.affiliates.show',[
            'affiliate'=>$affiliate
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|min:6',
           'email' => 'required|email|unique:admins,email',
           'password' => 'required|min:6',
           'role' => 'required'
        ]);

        $admin = Admin::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $admin->assignRole($request->input('role'));

        return redirect()->route('console.users.index');
    }

    public function destroy(Admin $user)
    {
        $user->delete();
        return redirect()->route('console.users.index');
    }

    public function update(Request $request, Admin $user)
    {
        $this->validate($request, [
            'name' => 'required|min:6',
            'email' => 'required|email|unique:admins,email,'.$user->id,
            'password' => 'nullable|min:6',
            'role' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->input('password'))
            $user->password = Hash::make($request->input('password'));
        $user->save();

        $user->syncRoles($request->input('role'));

        return redirect()->route('console.users.index');
    }

    public function edit(Admin $user)
    {
        $roles = Role::all();
        return view('console.users.edit', compact('user', 'roles'));
    }

}
