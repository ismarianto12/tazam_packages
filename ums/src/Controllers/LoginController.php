<?php

namespace Bryanjack\Ums\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Bryanjack\Support\Models\Agent;
use Bryanjack\Support\Models\Department;
use Bryanjack\Support\Models\Sla;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use Bryanjack\Ums\Controllers\Auth\LoginController as login;
use Bryanjack\Support\Models\Topic;
use Bryanjack\Ums\App\Traits\ApiTrait;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    use ApiTrait;
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $resp = $this->apilogin($request)->getData();

        // Die on failed
        if ($resp->status != 'success') {
            $errors = $resp->message;
            return redirect()->back()
                ->withErrors($errors);
        }

        // Register user on application
        if ($resp->status == 'success') {
            // Login user
            $userApi = Arr::only((array) $resp->attribute, ['name', 'username', 'nik', 'status', 'email', 'password', 'updated_at']);
            $userApi['password'] = bcrypt($request->password);
            $userApi['updated_at'] = $resp->attribute->active_time;
            $user = User::updateOrInsert(['id' => $resp->attribute->user_id], $userApi)->first();

            // Roles
            $roles = (array) $resp->attribute->role;
            foreach ($roles as $role) {
                // Create role if not exist
                Role::firstOrCreate(['name' => $role]);
            }
            // Assign roles
            $user->syncRoles($roles);
            // dd($user->getRoleNames());


            // Permissions
            $permissions = (array) $resp->attribute->permission;
            foreach ($permissions as $permission) {
                // Create role if not exist
                Permission::firstOrCreate(['name' => $permission]);
            }
            // Assign Permissions
            $user->syncPermissions($permissions);
            // dd($user->getPermissionNames());
            // dd($user->getAllPermissions());

            // Login User
            if (Auth::loginUsingId($resp->attribute->user_id, TRUE)) {
                // dd(Auth::user());
                return redirect()->intended('/dash');
            }
        } else {
            // Error UMS, message not contain status
            $response = (object) ['status' => 'error UMS'];
            $response->ums = $resp;
            return response()->json($response);
        }
    }

    public function umsLogout(Request $request)
    {
        $username = Auth::user()->username;
        $this->apiLogout($username);
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->intended('/');
    }
}