<?php

namespace Bryanjack\Ums\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bryanjack\Ums\Models\UmsApp;
use Bryanjack\Ums\Models\UmsPermission;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Route;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = UmsApp::all();
        return view('ums::permission.index', compact('apps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$routeCollection = Route::getRoutes(); //get and returns all routes collection
		
		foreach ($routeCollection as $route) {
			if($route->getName()){
				permission::firstOrCreate(['name'=>$route->getName()]);
			}
		}

		return redirect(route('ums.permission.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// dd($request);
        $this->validate($request, [
            'name'=>'required|max:50|unique:permissions',
            'for' => 'required'
        ]);

        $permission = new permission;
        $permission->name = $request->name;
        $permission->for = $request->for;
        $permission->save();

        return redirect(route('ums::permission.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\admin\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\admin\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $permission = permission::find($permission->id);
        return view('ums::permission.credit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\admin\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => 'required',
            'for' => 'required'
        ]);

        $permission = permission::find($permission->id);
        $permission->name = $request->name;
        $permission->for = $request->for;
        // $permission = $request;
        $permission->save();

        return redirect(route('permission.index'))->with('message', 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\admin\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        permission::where('id', $permission->id)->delete();
        return redirect()->back();
    }
    
    public function app_permission(Request $request)
    {
        $permissions = UmsPermission::where('app_id', $request->app_id)->get();
        $permissions = collect($permissions)->sortByDesc('id');

        return view('ums::permission.app', compact('permissions'));
    }

    public function create_permission(Request $request)
    {
        $app_id = $request->app_id;
        return view('ums::permission.credit', compact('app_id'));
    }

    public function edit_permission(Request $request)
    {
        $app_id = $request->app_id;
        $permission = UmsPermission::where([['permission_id', '=', $request->permission_id], ['app_id', '=', $request->app_id]])->first();
        return view('ums::permission.credit', compact('app_id', 'permission'));
    }

    public function store_permission(Request $request)
    {
        $request['created_user'] = Auth::user()->username;
        $request['updated_user'] = Auth::user()->username;
        $permission = UmsPermission::create($request->all());
        // $user->syncPermissions($request->permissions);
        return redirect(route('ums.permission.app', ['_token'=>csrf_token(), 'app_id'=>$request->app_id]))->with('message', 'Permission ' . $request->title . ' created successfully');
    }

    public function update_permission(Request $request)
    {
        // dd($request->all());
        $where = array(
            "id" => $request->id,
            "app_id" => $request->app_id
        );

        
        $data = array(
            "name" => $request->name,
            "guard_name" => $request->guard_name,
            "permission_id" => $request->permission_id,
            "status" => $request->status,
            "updated_user" => Auth::user()->username
        );
        
        // dd($where);
        
        $permission = UmsPermission::where($where)->update($data);

        // $user->syncPermissions($request->permissions);
        return redirect(route('ums.permission.app', ['_token'=>csrf_token(), 'app_id'=>$request->app_id]))->with('message', 'Permission ' . $request->title . ' created successfully');
    }

    public function active_inactive_permission(Request $request)
    {
        $status = $request->status == '1' ? '0' : '1';
        $permission = UmsPermission::where([['permission_id', '=', $request->permission_id],['app_id', '=',$request->app_id]])->update(['status' => $status]);
        return redirect(route('ums.permission.app', ['_token'=>csrf_token(), 'app_id'=>$request->app_id]))->with('message', 'Role ' . $request->title . ' updated successfully');
        
    }

}
