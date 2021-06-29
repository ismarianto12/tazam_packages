<?php

namespace Bryanjack\Ums\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Bryanjack\Ums\Models\Agent;
use Bryanjack\Ums\Models\Department;
use Bryanjack\Ums\Models\Sla;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Ums\Facades\Http;
use Illuminate\Ums\Facades\Auth;

use Bryanjack\Dash\Controllers\Auth\LoginController as login;
use Bryanjack\Ums\App\Traits\ApiTrait;
use Bryanjack\Ums\Models\Topic;
use Illuminate\Ums\Arr;

class ApiController extends Controller
{
    use ApiTrait;

    public function user_get(Request $request)
    {

        // $response = (object) ['status' => 'success'];
        // return response()->json($request->name);
        // $request['name'] = 'yusuf.fauzan';
        $parameter = ['username' => $request->name];
        $resp = $this->list_user($parameter);
        // dd($resp);
        // $resp = Arr::first($resp);
        // return is_array($resp);
        // return response()->json($resp);

        if (@$resp->status == 'failed') {
            // $response = (object) ['status' => 'failed'];
            // $response->ums = $resp;
            return response()->json($resp);
        } else {

            $resp = Arr::first($resp);
            $resp['status'] = 'success';
            return response()->json($resp);
        }


        // return ($response);
        // dd($response->body());
        // $resp = (object) json_decode($response->body(), true);

        // if (@$resp->status == 'success') {

        //     return response()->json($resp);
        // } else {
        //     $response = (object) ['status' => 'failed'];
        //     $response->ums = $resp;
        //     return response()->json($response);
        // }
    }

    public function get(Request $request)
    {
        // $user = User::where('id', '1')->first();

        if (Auth::loginUsingId(1, TRUE)) {
            return redirect()->intended('/ums/check');
        }
        // dd(Auth::user());
        // dd(session()->all());
        // dd($user);

        // dd($request);
        $request->email = 'bryanjack99@gmail.com';
        $request->username = 'bryanjack99@gmail.com';
        $request->password = 'BryPorS1#';
        $log = new login();
        $log->login($request);
        // dd($log);
        // $pass = \Hash::make('BryPorS1#');
        // $user = User::where('email', 'bryanjack99@gmail.com')->first();
        // $credentials = ['email' => 'bryanjack99@gmail.com', 'password' => 'BryPorS1#'];
        // $login = $this->attemptLogin($request);
        // dd($login);
        // Auth::guard('web')->attempt($credentials, true);
        // auth('web')->attempt($credentials, true);
        // Auth::login($user);
        // if ($user = Auth::attempt(['email' => 'bryanjack99@gmail.com', 'password' => 'BryPorS1#'])) {
        // if ($user = Auth::loginUsingId(1)) {
        //     echo($user);
        // }
        // dd(session()->all());
        // Auth::loginUsingId(1);


        dd(
            auth()->id() ?? '?',
            Auth::id() ?? '?',
            // $request->user()->id ?? '?',
            auth()->check(),
            get_class(auth()->guard())
        );


        // dd($user);
        // dd(Auth::user());
        // dd($username);
        $password = sha1('admin@123');
        $pass = $this->key('');
        $response = Http::get($this->url . $this->get . 'adam', [
            // $response = Http::get('http://10.100.20.26:8080/umsws/public/umsapi/user/yusuf.fauzan', [
            'app_id' => 'APP001',
            'app_key' => $pass,
            // 'username' => 'yusuf.fauzan',
        ]);
        // return($response->body());
        $resp = (object) json_decode($response->body(), true);
        dd($resp);
        // dd($resp->attribute['username']);
    }
}
