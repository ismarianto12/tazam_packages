<?php

namespace Bryanjack\Ums\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Bryanjack\Ums\Models\UmsApp;
use Bryanjack\Ums\Models\UmsBranchsAdditionals;
use Bryanjack\Ums\Models\UmsPermission;
use Bryanjack\Ums\Models\UmsRole;
use Bryanjack\Ums\Models\UmsRoleHasPermissions;
use Bryanjack\Ums\Models\UmsStatus;
use Bryanjack\Ums\Models\UmsUnit;
use Bryanjack\Ums\Models\UmsUser;
use Bryanjack\Ums\Models\UmsUserAdditionals;
use Bryanjack\Ums\Models\UmsUserHasPermissions;
use Bryanjack\Ums\Models\UmsUserHasRoles;
use Bryanjack\Ums\Models\UmsUserScheme;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->app_id = env('API_APP_ID');
        $this->api_url = env('API_URL');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = UmsUser::all();
        return view('ums::user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(session());
        $userApps = '';
            
        return view('ums::user.credit', compact('userApps'));
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
            'name' => 'required|max:50',
            'username' => 'required|max:255|unique:db_ums.users',
            'NIK' => 'required|max:255|unique:db_ums.users',
            'email' => 'required|email|max:255|unique:db_ums.users',
            'password' => 'required|min:8|confirmed',
        ]);
        $request['password'] = sha1($request->password);
        $request['created_user'] = Auth::user()->username;
        $user = UmsUser::create($request->all());
        // $user->syncRoles($request->roles);
        return redirect(route('ums.user.index'))->with('message', 'User ' . $request->title . ' created successfully');
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
    public function edit(UmsUser $user)
    {
        $unit = UmsUnit::where('branch_code', $user->unit)->get();
        $status = UmsStatus::where('par_id', $user->status)->get();
        $status_cek = 'status';
        $userApps = UmsUser::join('user_has_roles','users.id','=','user_has_roles.user_id')
            ->join('apps','user_has_roles.app_id','=','apps.id')
            ->join('users_additionals', function($join_1){
                $join_1->on('users_additionals.app_id', '=', 'user_has_roles.app_id')
                ->on('users_additionals.user_id', '=', 'users.id');
            })
            ->join('user_status_parameters','user_status_parameters.par_id','=','users_additionals.value')
            ->select('apps.id','apps.app_id', 'apps.app_name', 'user_has_roles.status as role_status', 'apps.status as app_status', 'users_additionals.value as user_status', 'user_status_parameters.par_name as status_name', 'user_status_parameters.color as status_color')
            ->where([['users.id', '=', $user->id],['users_additionals.field_name', '=', 'status']])
            ->distinct()
            ->get();
            // dd($userApps);
            
            $i = 0;
            foreach($userApps as $row):
                $userRoles = UmsUser::join('user_has_roles','users.id','=','user_has_roles.user_id')
                ->join('roles', function($join_1) {
                    $join_1->on('roles.role_id', '=', 'user_has_roles.role_id')
                    ->on('roles.app_id', '=', 'user_has_roles.app_id');
                })
                ->select('roles.role_id', 'roles.name as role_name','roles.app_id')
                ->where([
                    ['users.id', '=', $user->id],
                    // ['roles.app_id', '=', $row->app_id],
                ])
                ->get();
                // $data[$userRoles[$i]['role_id']] = $userRoles[$i]['role_id'];
                $data['role_name'][$i] = $userRoles[$i]['role_name'];
                // $app[$userRoles[$i]['app_id']] = $userRoles[$i]['app_id'];
                $i++;
            endforeach;
            // dd(array_merge($data));
            
            
        
        // $userPermissions = UmsUser::join('user_has_roles','users.id','=','user_has_roles.user_id')
        //     ->join('role_has_permissions','user_has_roles.role_id','=','role_has_permissions.role_id')
        //     ->join('permissions','role_has_permissions.permission_id','=','permissions.permission_id')
        //     ->select('permissions.permission_id', 'permissions.name as permission_name','user_has_roles.role_id','permissions.app_id')
        //     ->where('users.id', $user->id)
        //     ->get();
        // $userBranches = UmsUser::join('branchs_additionals','users.id','=','branchs_additionals.user_id')
        //     ->select('branchs_additionals.branch_code', 'branchs_additionals.app_id')
        //     ->where('users.id', $user->id)
        //     ->get();
            // dd($userApps);
        return view('ums::user.credit', compact('user', 'unit', 'status', 'userApps'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($id);
        $this->validate($request, [
            'name' => 'required|max:50',
            'username' => 'required|max:255|unique:db_ums.users,username,' . $id,
            'NIK' => 'required|max:255|unique:db_ums.users,NIK,' . $id,
            'email' => 'required|email|max:255|unique:db_ums.users,email,' . $id,
        ]);

        $user = UmsUser::find($id);
        if ($request->password == null) {
            $request['password'] = $user->password;
        } else {
            $request['password'] = sha1($request->password);
            $update_status_app = $this->update_status_user_app_reset_pass($id);
        }
        $user->update($request->all());
        $user->syncRoles($request->roles);

        return redirect(route('ums.user.index'))->with('message', 'User ' . $request->title . ' updated successfully');
    }

    public function role()
    {
        $permissions = Permission::orderBy('name')->get();
        $contain = '1';
        // return in_array("1", $contain->toArray());
        $role_permit = Arr::pluck($contain, 'id');
        // $role_permit = array_dot($contain->toArray());

        // return $role_permit;
        // return in_array("2", $coll, false) ? "yes" : "no";
        return view('ums::user.roler', compact('role', 'permissions', 'role_permit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_status(Request $request)
    {
        $get_status = UmsStatus::where('par_name', 'LIKE', '%'.$request->q.'%')->select('par_id','par_name')->get();
        foreach ($get_status as $row)
        {
            $list = array("id" => $row['par_id']);
            $name = array("text" => $row['par_name']);
            $data[] = array_merge($list, $name);
        }
        return $data;
    }

    public function get_unit(Request $request)
    {
        $get_unit = UmsUnit::where('branch_name','LIKE','%'.$request->q.'%')->select('branch_code','branch_name')->get();
        foreach ($get_unit as $row) {
            $list = array("id" => $row['branch_code']);
            $name = array("text" => $row['branch_name']);
            $data[] = array_merge($list, $name);
        };
        return $data;
    }
    
    public function get_apps(Request $request)
    {
        $user_id = $request->user_id;
        $app_id = [$request->app_id];
        $user_app = UmsUserHasRoles::where('user_id', $user_id)->whereNotIn('app_id', $app_id)->get();
        foreach($user_app as $key => $value):
            $app_array[$key] = $value->app_id;
        endforeach;
        $app = $user_app->isEmpty() ? [] : array_unique($app_array);
        $get_apps = UmsApp::where('app_name','LIKE','%'.$request->q.'%')->whereNotIn('id', $app)->select('id','app_id','app_name')->get();
        foreach ($get_apps as $row) {
            $list = array("id" => $row['id']);
            $name = array("text"=>$row['app_name']);
            $data[] = array_merge($list, $name);
        };
        return $data;
    }

    public function access_rolesapp(Request $request)
    {
        $access_roleapp = UmsRole::where([
            ['name','LIKE','%'.$request->q.'%'],
            ['app_id','=',$request->app_id],
            ])
            ->select('role_id', 'name as role_name')->get();
        foreach ($access_roleapp as $row)
        {
            $list = array("id" => $row['role_id']);
            $name = array("text" => $row['role_name']);
            $data[] = array_merge($list, $name);
        }
        return $data;
    }

    public function access_permissionsapp(Request $request)
    {
        // DD($request->role_id);
        $access_permissionapp = UmsRoleHasPermissions::join('permissions','role_has_permissions.permission_id', '=','permissions.permission_id')
        ->where([
            ['role_has_permissions.app_id', '=', $request->app_id],
            ['permissions.name', 'LIKE', '%'.$request->q.'%']
            ])
            // ->whereNotIn('role_has_permissions.permission_id', $request->permission_id)
            ->whereNotIn('role_has_permissions.role_id', $request->role_id)
        ->get();
        
        foreach ($access_permissionapp as $row)
        {
            $list = array("id" => $row['permission_id']);
            $name = array("text" => $row['name']);
            $data[] = array_merge($list, $name);
        }
        return $data;
    }

    public function get_rolesapp(Request $request)
    {
        $get_rolesapp = UmsApp::join('roles', 'apps.id', '=', 'roles.app_id')
            ->where('apps.id', '=', $request->app_id)
            ->get();

        return $get_rolesapp;
    }

    public function get_permissionsapp(Request $request)
    {
        $get_permissioinsapp = UmsRoleHasPermissions::join('Permissions','role_has_permissions.permission_id','=','Permissions.permission_id')
            ->join('apps','role_has_permissions.app_id','=','apps.id')
            ->select('apps.app_id','role_has_permissions.role_id', 'role_has_permissions.permission_id', 'permissions.name')
            ->where('apps.id', $request->app_id)
            ->whereNotIn('role_has_permissions.role_id', $request->role_id)
            ->get();

        return $get_permissioinsapp;
    }
    
    public function get_additionalsapp(Request $request)
    {
        $get_permissioinsapp = UmsApp::join('users_additionals_schema', 'apps.id', '=', 'users_additionals_schema.app_id')
            ->where('apps.id', '=', $request->app_id)
            // ->where('users_additionals_schema.status', '=', '1')
            ->get();

        return $get_permissioinsapp;
    }

    public function get_permissions(Request $request)
    {
        $get_permissions = UmsRoleHasPermissions::join('Permissions','role_has_permissions.permission_id','=','Permissions.permission_id')
            ->join('apps','role_has_permissions.app_id','=','apps.id')
            ->select('apps.app_id','role_has_permissions.role_id', 'role_has_permissions.permission_id', 'permissions.name')
            ->where('apps.id', $request->app_id)
            ->whereIn('role_has_permissions.role_id', $request->role_id)
            ->get();

            return $get_permissions;
    }
    
    public function app_create(Request $request)
    {
        $user = UmsUser::where('users.id', $request->id)->first();
        
        $app = UmsUser::join('user_has_roles','users.id','=','user_has_roles.user_id')
            ->join('apps','user_has_roles.app_id','=','apps.id')
            ->select('apps.id','apps.app_id', 'apps.app_name')
            ->where([
                ['users.id', '=', ''],
                ['apps.id', '=', '']
                ])
            ->distinct()
            ->get();
        
        $roles = '';

        $permissions = '';

        $branches = '';

        $userschema = '';

        $permissionAdd = '';

        return view('ums::user.access', compact('user', 'app', 'roles', 'permissions', 'branches', 'userschema', 'permissionAdd'));
    }

    public function app_edit(Request $request)
    {
        $user = UmsUser::where('users.id', $request->id)->first();
        
        $app = UmsUser::join('user_has_roles','users.id','=','user_has_roles.user_id')
            ->join('apps','user_has_roles.app_id','=','apps.id')
            ->select('apps.id','apps.app_id', 'apps.app_name')
            ->where([
                ['users.id', '=', $request->id],
                ['apps.id', '=', $request->app_id]
                ])
            ->distinct()
            ->get();
        
        $roles = UmsUser::join('user_has_roles','users.id','=','user_has_roles.user_id')
            ->join('roles', function($join_1) {
                $join_1->on('roles.role_id', '=', 'user_has_roles.role_id')
                ->on('roles.app_id', '=', 'user_has_roles.app_id');
            })
            ->select('roles.role_id', 'roles.name as role_name','roles.app_id')
            ->where([
                ['users.id', '=', $request->id],
                ['roles.app_id', '=', $request->app_id],
            ])
            ->get();

        $permissions = UmsUserHasRoles::join('role_has_permissions', function($join_1) {
            $join_1->on('user_has_roles.role_id','=','role_has_permissions.role_id')
            ->on('user_has_roles.app_id', '=', 'role_has_permissions.app_id');
            })
            ->join('permissions',function($join_1) {
                $join_1->on('role_has_permissions.permission_id','=','permissions.permission_id')
                ->on('role_has_permissions.app_id','=','permissions.app_id');
                })
            ->select('permissions.permission_id', 'permissions.name as permission_name','user_has_roles.role_id','permissions.app_id')
            ->where([
                ['user_has_roles.user_id', '=', $request->id],
                ['permissions.app_id', '=', $request->app_id],
            ])
            ->get();
        
        $permissionAdd = UmsUser::join('user_has_permissions','users.id','=','user_has_permissions.user_id')
        ->join('permissions', function($join_1) {
            $join_1->on('user_has_permissions.permission_id', '=', 'permissions.permission_id')
            ->on('user_has_permissions.app_id', '=', 'permissions.app_id');
            })
            ->where([
                ['users.id', '=', $request->id],
                ['permissions.app_id', '=', $request->app_id]
            ])
            ->get();

            // dd($permissionAdd);

        $branches = UmsBranchsAdditionals::join('branchs', 'branchs_additionals.branch_code', '=', 'branchs.branch_code')
            ->select('branchs_additionals.branch_code', 'branchs_additionals.app_id', 'branchs.branch_name')
            ->where([
                ['branchs_additionals.user_id', '=', $request->id],
                ['branchs_additionals.app_id', '=', $request->app_id],
            ])
            ->get();

        $userschema = UmsUserScheme::join('users_additionals', function($join_1){
                $join_1->on('users_additionals_schema.app_id','=','users_additionals.app_id')
                ->on('users_additionals_schema.field_name','=','users_additionals.field_name');
                })
            ->select('users_additionals.field_name', 'users_additionals.value', 'users_additionals_schema.attribute', 'users_additionals_schema.label_name', 'users_additionals_schema.input_type', 'users_additionals_schema.mandatory')
            ->where([
                ['users_additionals_schema.app_id', '=', $request->app_id],
                ['users_additionals.user_id', '=', $request->id],
                // ['users_additionals_schema.status', '=', '1']
                ])
            ->get();


            // dd($permissionAdd);

        return view('ums::user.access', compact('user', 'app', 'roles', 'permissions', 'branches', 'userschema', 'permissionAdd'));
    }
    
    public function access_Store(Request $request)
    {
        $tz_object = new DateTimeZone('Asia/Jakarta');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        $date = $datetime->format('Y-m-d H:i:s');
        $user_act = Auth::user()->username;
        
        $user_id = $request->user_id;
        $app_id = $request->app_id;

        $roles = $request->role_id;
        foreach($roles as $key => $value):
            $role[$key]['role_id'] = $value;
            $role[$key]['user_id'] = $user_id;
            $role[$key]['app_id'] = $app_id;
            $role[$key]['created_user'] = $user_act;
            $role[$key]['updated_user'] = $user_act;
            $role[$key]['created_at'] = $date;
            $role[$key]['updated_at'] = $date;
            $role[$key]['status'] = '1';
        endforeach;
        $userRole = UmsUserHasRoles::insert($role);

        $permissions = $request->permission_id;
        if($permissions)
        {
            foreach($permissions as $key => $value):
                $permission[$key]['permission_id'] = $value;
                $permission[$key]['user_id'] = $user_id;
                $permission[$key]['app_id'] = $app_id;
                $permission[$key]['created_user'] = $user_act;
                $permission[$key]['updated_user'] = $user_act;
                $permission[$key]['created_at'] = $date;
                $permission[$key]['updated_at'] = $date;
            endforeach;
            $userPermission = UmsUserHasPermissions::insert($permission);
        }
        
        $branches = $request->branch_id;
        foreach($branches as $key => $value):
            $branch[$key]['branch_code'] = $value;
            $branch[$key]['user_id'] = $user_id;
            $branch[$key]['app_id'] = $app_id;
            $branch[$key]['created_user'] = $user_act;
            $branch[$key]['updated_user'] = $user_act;
            $branch[$key]['created_at'] = $date;
            $branch[$key]['updated_at'] = $date;
            $branch[$key]['status'] = '1';
        endforeach;
        $userBranch = UmsBranchsAdditionals::insert($branch);
        
        $field = $request->value;
        if($field)
        {
            $i = 0;
            foreach($field as $key => $value):
                $user_add[$i]['field_name'] = $key;
                $user_add[$i]['value'] = $value == null ? $date : $value;
                $user_add[$i]['user_id'] = $user_id;
                $user_add[$i]['app_id'] = $app_id;
                $user_add[$i]['created_user'] = $user_act;
                $user_add[$i]['updated_user'] = $user_act;
                $user_add[$i]['created_at'] = $date;
                $user_add[$i]['updated_at'] = $date;
                $i++;
            endforeach;
            $userAdditionals = UmsUserAdditionals::insert($user_add);
        }
                
        return redirect(route('ums.user.edit', $user_id))->with('message', 'User ' . $request->title . ' created successfully');
    }

    public function access_update(Request $request)
    {
        $tz_object = new DateTimeZone('Asia/Jakarta');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        $date = $datetime->format('Y-m-d H:i:s');
        $user_act = Auth::user()->username;
        
        $user_id = $request->user_id;
        $app_id = $request->app_id;

        $where = array(
            "user_id" => $user_id,
            "app_id" => $app_id
        );

        $roles = $request->role_id;
        $delUserRole = UmsUserHasRoles::where($where)->delete();
        if(!empty($roles))
        {
            foreach($roles as $key => $value):
                $role[$key]['role_id'] = $value;
                $role[$key]['user_id'] = $user_id;
                $role[$key]['app_id'] = $app_id;
                $role[$key]['created_user'] = $user_act;
                $role[$key]['updated_user'] = $user_act;
                $role[$key]['created_at'] = $date;
                $role[$key]['updated_at'] = $date;
                $role[$key]['status'] = '1';
            endforeach;
            $userRole = UmsUserHasRoles::insert($role);
        }
        

        $permissions = $request->permission_id;
        $delUserPermission = UmsUserHasPermissions::where($where)->delete();
        if(!empty($permissions))
        {
            foreach($permissions as $key => $value):
                $permission[$key]['permission_id'] = $value;
                $permission[$key]['user_id'] = $user_id;
                $permission[$key]['app_id'] = $app_id;
                $permission[$key]['created_user'] = $user_act;
                $permission[$key]['updated_user'] = $user_act;
                $permission[$key]['created_at'] = $date;
                $permission[$key]['updated_at'] = $date;
            endforeach;
            $userPermission = UmsUserHasPermissions::insert($permission);
        }
        
        
        $branches = $request->branch_id;
        $delUserBranch = UmsBranchsAdditionals::where($where)->delete();
        if(!empty($branches))
        {
            foreach($branches as $key => $value):
                $branch[$key]['branch_code'] = $value;
                $branch[$key]['user_id'] = $user_id;
                $branch[$key]['app_id'] = $app_id;
                $branch[$key]['created_user'] = $user_act;
                $branch[$key]['updated_user'] = $user_act;
                $branch[$key]['created_at'] = $date;
                $branch[$key]['updated_at'] = $date;
                $branch[$key]['status'] = '1';
            endforeach;
            $userBranch = UmsBranchsAdditionals::insert($branch);
        }
        
        
        $field = $request->value;
        // dd($field);
        $delUserAdditional = UmsUserAdditionals::where($where)->delete();
        if(!empty($field))
        {
            // dd($field);
            $i = 0;
            foreach($field as $key => $value):
                $user_add[$i]['field_name'] = $key;
                $user_add[$i]['value'] = $value == null ? $date : $value;
                $user_add[$i]['user_id'] = $user_id;
                $user_add[$i]['app_id'] = $app_id;
                $user_add[$i]['created_user'] = $user_act;
                $user_add[$i]['updated_user'] = $user_act;
                $user_add[$i]['created_at'] = $date;
                $user_add[$i]['updated_at'] = $date;
                $i++;
            endforeach;
            $userAdditionals = UmsUserAdditionals::insert($user_add);
        }
        
        return redirect(route('ums.user.edit', $user_id))->with('message', 'User ' . $request->title . ' created successfully');
    }

    public function approval_user(Request $request)
    {
        $users = UmsUser::whereIn('status', array(4,7))->get();
        return view('ums::user.approve', compact('users'));
    }
    
    public function approve(Request $request)
    {
        $status = $request->status == '4' ? '6' : ($request->status == '7' ? '8' : '0');
        $user = UmsUser::where('id', $request->id)->update(['status' => $status]);
        return redirect(route('ums.user.index'))->with('message', 'User ' . $request->title . ' updated successfully');
    }

    public function reject(Request $request)
    {
        $status = $request->status == '4' ? '4' : ($request->status == '7' ? '7' : '0');
        $user = UmsUser::where('id', $request->id)->update(['status' => $status]);
        return redirect(route('ums.user.index'))->with('message', 'User ' . $request->title . ' updated successfully');
    }

    public function active_inactive_user(Request $request)
    {
        $status = $request->status == '1' ? '0' : '1';
        $user = UmsUser::where('id', $request->id)->update(['status' => $status]);
        return redirect(route('ums.user.index'))->with('message', 'User ' . $request->title . ' updated successfully');
        
    }

    public function reset_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);
        $user = UmsUser::find($request->id);
        if ($request->password == null) {
            $password = $user->password;
        } else {
            $password = sha1($request->password);
        }
        $user = UmsUser::where('id', $request->id)->update(['password' => $password], ['status' => '7']);
        return redirect(route('ums.user.index'))->with('message', 'User ' . $request->title . ' updated successfully');
    }
    
    public function active_inactive_user_app(Request $request)
    {
        $status = $request->status == '1' ? '0' : '1';
        $status_user = UmsUserAdditionals::where([
            ['user_id', '=', $request->id],
            ['app_id', '=', $request->app_id],
            ['field_name', '=', 'status']
            ])
        ->update(['value' => $status]);
        $counter_user = UmsUserAdditionals::where([
            ['user_id', '=', $request->id],
            ['app_id', '=', $request->app_id],
            ['field_name', '=', 'counter_pass']
            ])
        ->update(['value' => '0']);
        return redirect(route('ums.user.edit', $request->id))->with('message', 'User ' . $request->title . ' updated successfully');
    }

    public function update_status_user_app_reset_pass($id)
    {
        // dd($id);
        $status = '8';
        $user = UmsUserAdditionals::where([
            ['user_id', '=', $id],
            ['field_name', '=', 'status']
            ])
        ->update(['value' => $status]);
        // return redirect(route('ums.user.edit', $request->id))->with('message', 'User ' . $request->title . ' updated successfully');
    }
}
