<?php

namespace App\Http\Controllers\Console;

use App\DataTables\Console\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Roles');
        // $this->middleware('can:create roles')->only(['create', 'store']);
        // $this->middleware('can:edit roles')->only(['edit', 'update']);
        // $this->middleware('can:delete roles')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('console.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::orderBy('name')->get();

        $permissions->transform(function ($permission) {
            $permission->group = trim(preg_replace('/show|create|edit|delete/', '', $permission->name));

            return $permission;
        });

        $permissionGroups = $permissions->groupBy('group')->sortKeys();

        return view('console.role.create', compact('permissionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $data = $request->validated();

        $role = new Role();
        $role->name = $data['name'];
        $role->save();

        $role->permissions()->sync($data['permissions']);

        return redirect()->route('console.roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $role->permissionIDs = $role->permissions->pluck('id')->toArray();

        $permissions = Permission::orderBy('name')->get();

        $permissions->transform(function ($permission) {
            $permission->group = trim(preg_replace('/show|create|edit|delete/', '', $permission->name));

            return $permission;
        });

        $permissionGroups = $permissions->groupBy('group')->sortKeys();

        return view('console.role.edit', compact('role', 'permissionGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $data = $request->only('name', 'permissions');

        $role = Role::with('permissions')->findOrFail($id);
        $role->name = $data['name'];
        $role->save();

        $role->permissions()->sync($data['permissions']);

        return redirect()->route('console.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role $role;
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('console.roles.index');
    }
}
