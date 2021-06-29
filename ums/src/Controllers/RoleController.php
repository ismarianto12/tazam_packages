<?php

namespace Bryanjack\Ums\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bryanjack\Ums\Models\UmsApp;
use Bryanjack\Ums\Models\UmsPermission;
use Bryanjack\Ums\Models\UmsRole;
use Bryanjack\Ums\Models\UmsRoleHasPermissions;
use DateTime;
use DateTimeZone;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = UmsApp::all();
        return view('ums::role.index', compact('apps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $permissions = collect($permissions)->sortBy('name');
        $permissions = UmsPermission::orderBy('name')->get();
        // return $permissions;
        // ->sortBy('name');
        // $permissions = array_pluck($permissions, ['name']);
        return view('ums::role.credit', compact('permissions'));
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

        return redirect(route('ums.role.index'));
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
        $permissions = UmsPermission::orderBy('name')->get();
        $contain = $role->permissions;
        // return in_array("1", $contain->toArray());
        $role_permit = Arr::pluck($contain, 'id');
        // $role_permit = array_dot($contain->toArray());

        // return $role_permit;
        // return in_array("2", $coll, false) ? "yes" : "no";
        return view('ums::role.credit', compact('role', 'permissions', 'role_permit'));
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

        return redirect(route('ums.role.index'));
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

    public function app_role(Request $request)
    {
        $roles = UmsRole::where('app_id', $request->app_id)->get();
        
        return view('ums::role.app', compact('roles'));
    }

    public function create_role(Request $request)
    {
        $permissions = UmsPermission::where('app_id', $request->app_id)->orderBy('name')->get();
        $app_id = $request->app_id;
        $role_permit = '';
        return view('ums::role.credit', compact('permissions', 'app_id', 'role_permit'));
    }

    public function edit_role(Request $request)
    {
        $role = UmsRole::where([['role_id', '=', $request->role_id],['app_id', '=', $request->app_id]])->get()[0];
        $permissions = UmsPermission::where('app_id', $request->app_id)->orderBy('name')->get();
        $app_id = $request->app_id;
        
        $role_permit_o = UmsRoleHasPermissions::join('permissions','role_has_permissions.permission_id','=','permissions.permission_id')
        ->select('permissions.permission_id')
        ->where([['role_has_permissions.role_id', '=', $request->role_id],['role_has_permissions.app_id', '=', $request->app_id]])
        ->orderBy('name')
        ->get();
        if($role_permit_o->isNotEmpty())
        {
            foreach($role_permit_o as $key => $value):
                $role_permit[$key] = $value->permission_id;
            endforeach;
        };

        if($role_permit_o->isEmpty())
        {
            $role_permit = '';
        };
        
        return view('ums::role.credit', compact('role', 'permissions', 'app_id', 'role_permit'));
    }
    
    public function store_role(Request $request)
    {
        $request['created_user'] = Auth::user()->username;
        $request['updated_user'] = Auth::user()->username;
        $role = UmsRole::create($request->all());

        $tz_object = new DateTimeZone('Asia/Jakarta');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        $date = $datetime->format('Y-m-d H:i:s');
        
        $permissions = $request->permissions;
        foreach($permissions as $key => $value):
            $permission[$key]['permission_id'] = $value;
            $permission[$key]['role_id'] = $request->role_id;
            $permission[$key]['app_id'] = $request->app_id;
            $permission[$key]['created_user'] = Auth::user()->username;
            $permission[$key]['updated_user'] = Auth::user()->username;
            $permission[$key]['created_at'] = $date;
            $permission[$key]['updated_at'] = $date;
        endforeach;
        $rolePermission = UmsRoleHasPermissions::insert($permission);

        return redirect(route('ums.role.app', ['_token'=>csrf_token(), 'app_id'=>$request->app_id]))->with('message', 'Role ' . $request->title . ' created successfully');
    }

    // public function update_role(Request $request)
    // {
    //     dd($request->all());
    //     $role = UmsRole::updateOrInsert($request->all());
    //     // $user->syncRoles($request->roles);
    //     return redirect(route('ums.role.app', ['_token'=>csrf_token(), 'app_id'=>$request->app_id]))->with('message', 'Role ' . $request->title . ' created successfully');
    // }

    public function update_role(Request $request)
    {
        
        // dd($request->all());
        $where_role = array(
            "id" => $request->id,
            "app_id" => $request->app_id
        );

        $tz_object = new DateTimeZone('Asia/Jakarta');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        $date = $datetime->format('Y-m-d H:i:s');

        $data = array(
            "name" => $request->name,
            "guard_name" => $request->guard_name,
            "role_id" => $request->role_id,
            "hierarcy_id" => $request->hierarcy_id,
            "status" => $request->status,
            "updated_user" => Auth::user()->username
        );
        
        $role = UmsRole::where($where_role)->update($data);
        
        $where_permission = array(
            "role_id" => $request->role_id,
            "app_id" => $request->app_id
        );

        $permissions = $request->permissions;
        $delUserRolePermissions = UmsRoleHasPermissions::where($where_permission)->delete();
        foreach($permissions as $key => $value):
            $permission[$key]['permission_id'] = $value;
            $permission[$key]['role_id'] = $request->role_id;
            $permission[$key]['app_id'] = $request->app_id;
            $permission[$key]['created_user'] = Auth::user()->username;
            $permission[$key]['updated_user'] = Auth::user()->username;
            $permission[$key]['created_at'] = $date;
            $permission[$key]['updated_at'] = $date;
        endforeach;
        // dd($permission);
        $rolePermission = UmsRoleHasPermissions::insert($permission);

        return redirect(route('ums.role.app', ['_token'=>csrf_token(), 'app_id'=>$request->app_id]))->with('message', 'Role ' . $request->title . ' created successfully');
    }

    public function active_inactive_role(Request $request)
    {
        $status = $request->status == '1' ? '0' : '1';
        $role = UmsRole::where([['role_id', '=', $request->role_id],['app_id', '=',$request->app_id]])->update(['status' => $status]);
        return redirect(route('ums.role.app', ['_token'=>csrf_token(), 'app_id'=>$request->app_id]))->with('message', 'Role ' . $request->title . ' updated successfully');
        
    }

}
