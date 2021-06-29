<?php

namespace Bryanjack\Ums\App\Traits;

use App\Models\User;
use Bryanjack\Support\Models\Agent;
use Bryanjack\Support\Models\Department;
use Bryanjack\Support\Models\Sla;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use Bryanjack\Dash\Controllers\Auth\LoginController as login;
use Illuminate\Support\Arr;

trait ApiTrait
{
    protected $get = 'user/';
    protected $login = 'login';
    protected $check = 'user';
    protected $logout = 'logout';
    protected $list_user = 'user/list/all';

    public function __construct()
    {
        $this->app_id = env('API_APP_ID');
        $this->api_url = env('API_URL');
    }

    public function apiLogin(Request $request)
    {
        $username = $request->email;
        $password = sha1($request->password);
        $pass = $this->key($password);

        $response = Http::post($this->api_url . $this->login, [
            'app_id' => $this->app_id,
            'username' => $username,
            'password' => $pass,
        ]);

        $resp = (object) json_decode($response->body(), true);

        // Dev mode
        // $this->apiLogout($username);

        return response()->json($resp);
    }

    public function apiUserCheck(Request $request)
    {
        $username = $request->email;
        $password = sha1($request->password);
        $pass = $this->key('');

        $response = Http::get($this->api_url . $this->check, [
            'app_id' => $this->app_id,
            // 'username' => $username,
            // 'username' => 'chaerul.anhar',
            'app_key' => $pass,
        ]);

        $resp = (object) json_decode($response->body(), true);

        // Dev mode
        $this->apiLogout($username);
        // dd($resp);
        return response()->json($resp);
        // Die on failed
        if ($resp->status != 'success') {
            dd($resp);
        }

        // Register user on application
        // dd($resp->attribute['user_id']);
        if ($resp->status == 'success') {
            // Login user
            $id = $resp->attribute['user_id'];
            $userApi = Arr::only($resp->attribute, ['name', 'username', 'status', 'email', 'password', 'updated_at']);
            $userApi['password'] = bcrypt($request->password);
            $userApi['updated_at'] = $resp->attribute['active_time'];
            $user = User::updateOrInsert(['id' => $id], $userApi);

            // Login User
            if (Auth::loginUsingId($id, TRUE)) {
                // dd(Auth::user());
                return redirect()->intended('/dash');
            }
        } else {
            // Error UMS
            $response = (object) ['status' => 'error UMS'];
            $response->ums = $resp;
            return response()->json($response);
        }
    }

    public function list_user($parameter = null)
    {
        $pass = $this->key('');
        // $parameter = ['unit' => 'dti'];

        $response = Http::get($this->api_url . $this->list_user, [
            'app_id' => $this->app_id,
            'app_key' => $pass,
            'parameter' => $parameter,
        ]);
        // return ($response);
        // dd($response->body());
        $resp = (object) json_decode($response->body(), true);
        // dd($resp->data);
        if ($resp->data) {
            // To enable selected param
            // $i = 0;
            // foreach ($resp->data as $data) {
            //     $datas[$i] = (object) Arr::only($data, ['id', 'username', 'name', 'NIK', 'email', 'phone']);
            //     $i++;
            // }
            return (object) $resp->data;
        } else {
            return (object) ['status' => 'failed', 'message' => 'user not found'];
        }
    }


    public function apiLogout($username)
    {
        // dd('wedus');
        $password = sha1('admin@123');
        $pass = $this->key('');
        $response = Http::post($this->api_url . $this->logout, [
            'username' => $username,
            'key' => $pass,
            'app_id' => 'APP001',
        ]);
        // dd($response->body());
        $resp = (object) json_decode($response->body(), true);
        return $resp->status;
    }

    public function logout1()
    {
        if (Auth::check()) {

            Auth::logout();
            return redirect()->intended('/support/check');
        }
        // dd(Auth::check());
        $password = sha1('admin@123');
        $pass = $this->key('');
        // dd($pass);
        $response = Http::post($this->url . $this->logout, [
            'username' => 'yusuf.Fauzan',
            'key' => $pass,
            'app_id' => 'APP001',
            // 'role' => 'Network Administrator',
        ]);

        // if($)
        // dd($pass);
        // return($response->body());
        // dd(json_decode($response->body()));
        $resp = (object) json_decode($response->body(), true);
        dd($resp);
        // dd($resp);
        // dd($resp->username);
    }


    public function get(Request $request)
    {
        // $user = User::where('id', '1')->first();

        if (Auth::loginUsingId(1, TRUE)) {
            return redirect()->intended('/support/check');
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
    public function dynamic_key(Request $request)
    {
        $response = new \StdClass();
        $response->status = 'false';

        if ($request->app_id !== 'APP001') {
            $response->message = 'App ID tidak sesuai';
            $response->status = 'false';
            return json_encode($response);
        }

        if (1 !== 1) {
            $response->message = 'Gagal update dynamic key';
            $response->status = 'false';
            return json_encode($response);
        }

        $response->key = $request->dynamic_key;
        $response->status = 'success';
        return json_encode($response);
    }





    public function key($password)
    {
        $dynamic_key = 't9MKSoAjsM7fpP68YwG0Xn2ffC5ACGlb';
        $app_key = substr('xSPzCNKX7uOdrMmyQhd8eIkvDJSxztDv', 0, 16);
        // $password = sha1('admin@123');
        $finalKey = '';
        for ($i = 0; $i < strlen($dynamic_key);) {
            for ($j = 0; ($j < strlen($app_key) && $i < strlen($dynamic_key)); $j++, $i++) {
                $finalKey .= $dynamic_key[$i] ^ $app_key[$j];
            }
        }

        if ($password == '') {
            return $finalKey;
        }

        $saltKey = '';

        for ($i = 0; $i < strlen($password);) {
            for ($j = 0; ($j < strlen($finalKey) && $i < strlen($password)); $j++, $i++) {
                $saltKey .= $password[$i] ^ $finalKey[$j];
            }
        }
        return $saltKey;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $agents = Agent::all();
        return view('support::agent.index', compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $viewVar['title'] = 'Pendaftaran Agent';
        $departments = Department::all();
        return view('support::agent.credit', compact('viewVar', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:agents',
        ]);
        $agent = Agent::create($request->all());
        return redirect(route('support.agent.index'))->with('message', 'Agent ' . $request->name . ' created successfully');
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
    public function edit(Agent $agent)
    {
        $viewVar['title'] = 'Edit Agent';
        $slas = Sla::all();
        $agents = Agent::all();
        return view('support::agent.credit', compact('agent', 'viewVar', 'slas', 'agents'));
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

        $this->validate($request, [
            'name' => 'required|max:255|unique:agents,name,' . $id,
        ]);
        $request->status !== null ? $request['status'] = 1 : $request['status'] = 0;
        $agent = Agent::find($id)->update($request->all());
        return redirect(route('support.agent.index'))->with('message', 'Agent ' . $request->name . ' updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agent = Agent::find($id);
        $agent->delete();
        return redirect()->back()->with('message', 'Agent ' . $agent->name . ' deleted sucessfully');
    }

    public function apiFoto($nik)
    {
        $password = sha1('admin@123');
        // $pass = $this->key('');
        $response = Http::get('http://hris.paninbanksyariah.co.id/api/web/ums/photo.php', [
            'nik' => $nik,
            // 'key' => $pass,
            // 'app_id' => 'APP001',
            // 'role' => 'Network Administrator',
        ]);
        $resp = (object) json_decode($response->body(), true);
        return response()->json($resp);
    }
}