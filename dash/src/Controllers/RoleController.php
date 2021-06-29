<?php

namespace Bryanjack\Dash\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Arr;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('dash::role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $permissions = collect($permissions)->sortBy('name');
        $permissions = Permission::orderBy('name')->get();
        // return $permissions;
        // ->sortBy('name');
        // $permissions = array_pluck($permissions, ['name']);
        return view('dash::role.credit', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'name' => 'required|max:50|unique:roles'
        ]);

        $role = new role;
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permissions);

        return redirect(route('dash.role.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();
        $contain = $role->permissions;
        // return in_array("1", $contain->toArray());
        $role_permit = Arr::pluck($contain, 'id');
        // $role_permit = array_dot($contain->toArray());

        // return $role_permit;
        // return in_array("2", $coll, false) ? "yes" : "no";
        return view('dash::role.credit', compact('role', 'permissions', 'role_permit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $role = role::find($id);
        $role->name = $request->name;
        $role->save();
        // $role->syncPermissions($request->permissions);
        $role->permissions()->sync($request->permissions);

        return redirect(route('dash.role.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back();
    }
}
