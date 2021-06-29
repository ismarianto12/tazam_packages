<?php

namespace Bryanjack\Aplikasi\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Lib\AntonioGabutz;
use Closure;

trait LoginActions
{

    public function index()
    {
        if (Session::get('auths')) {
            return redirect()->intended('dashboard');
        }
        return view('aplikasi::login');
    }
    public function DoprocessLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return back();
        }

        $username = $request->username;
        $password = sha1($request->password);

        $app_id =  AntonioGabutz::app_config('app_id');
        $dynamic_key = AntonioGabutz::app_config('dynamic_key');
        $app_key =   substr(AntonioGabutz::app_config('app_key'), 0, 16);

        $finalKey = '';

        for ($i = 0; $i < strlen($dynamic_key);) {
            for ($j = 0; ($j < strlen($app_key) && $i < strlen($dynamic_key)); $j++, $i++) {
                $finalKey .= $dynamic_key[$i] ^ $app_key[$j];
            }
        }

        $saltKey = '';

        for ($i = 0; $i < strlen($password);) {
            for ($j = 0; ($j < strlen($finalKey) && $i < strlen($password)); $j++, $i++) {
                $saltKey .= $password[$i] ^ $finalKey[$j];
            }
        }

        $data = array(
            'username' => $username,
            'password' => $saltKey,
            'app_id' => $app_id,
        );
        // $url = "http://umsws8.test/ums/v1/login";
        $url = "http://lus.pdsb.id/ums/v1/login";
        // $url = "http://gateway.pdsb.id/ums/v1/login";
        // $url = "http://10.100.20.26/umsws8/public/umsapi/login";
        $req = Http::post($url, $data);
        $datas = $req->json();
        // dd($datas); 
        // dd([
        //     'API_ID' => $app_id,
        //     'APP_KEY' => $app_key,
        //     'dynamic_key' => $dynamic_key,
        //     'data' => $datas,
        //     'request' => $request->all(),
        //     'credential' => $data,
        // ]);   
        if ($datas) {
            if ($datas['status'] == 'success') {
                session([
                    "auths" => true,
                    "user_id" => $datas['attribute']['user_id'],
                    "username" => $datas['attribute']['username'],
                    "name" => $datas['attribute']['name'],
                    "email" => $datas['attribute']['email'],
                    "phone" => $datas['attribute']['phone'],
                    "unit" => $datas['attribute']['unit'],
                    "jabatan" => $datas['attribute']['jabatan'],
                    "nik" => $datas['attribute']['nik'],
                    "status" => $datas['attribute']['status'],
                    "counter_pass" => $datas['attribute']['counter_pass'],
                    "temp_data_time" => $datas['attribute']['temp_data_time'],
                    "active_time" => $datas['attribute']['active_time'],
                    "role" => $datas['attribute']['role'],
                    "permission" => $datas['attribute']['permission']
                ]);
                // if ($datas['attribute']['status'] == '5') {
                //     return redirect()->route('fa.change.pass');
                // } else {
                return redirect()->route('dashboard');
                // }
            } else if ($datas['status'] == 'failed') {
                return back()->with(['statusalert' => '1', 'text_a' => $datas['message'], 'icon_a' => 'error']);
                // return 'gagal';
            } else {
                //    / return back()->with(['statusalert' => '1', 'text_a' => 'username is wrong', 'icon_a' => 'error']);
                return Redirect::back()->withErrors(['msg' => 'username dan password salah', 'msg' => 'password tidak sesuai']);
            }
        } else {
            return Redirect::back()->withErrors(['msg' => 'username dan password salah', 'msg' => 'password tidak sesuai']);
        }
    }


    function change_pass(Request $request, $par)
    {

        // dd(Session::get('username'));
        $username = Session::get('username');
        $oldpas = str_replace("'", "`", $request->oldpass);
        $newpas = str_replace("'", "`", $request->newpass);
        $confirm_password = str_replace("'", "`", $request->cpass);

        $uppercase = preg_match('@[A-Z]@', $newpas);
        $lowercase = preg_match('@[a-z]@', $newpas);
        $number    = preg_match('@[0-9]@', $newpas);
        $specialChars = preg_match('@[^\w]@', $newpas);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($newpas) < 8) {
            return back()->with(['statusalert' => '1', 'text_a' => 'Password should be more than 8 character with combination uppercase and lowercase', 'icon_a' => 'error']);
        }

        $old_password = sha1($oldpas);
        $new_password = sha1($newpas);
        $confirm_password = sha1($confirm_password);

        // $q_data      = $this->db->query("select * from par_api_app where app_id='APP002'")->row_array();

        $app_id =  AntonioGabutz::app_config('app_id');
        $dynamic_key = AntonioGabutz::app_config('dynamic_key');
        $app_key =   substr(AntonioGabutz::app_config('app_key'), 0, 16);

        //echo "appid : ".$app_id." - dynamic_key : ".$dynamic_key." - app_key : ".$app_key."<br>";

        $finalKey    = '';

        for ($i = 0; $i < strlen($dynamic_key);) {
            for ($j = 0; ($j < strlen($app_key) && $i < strlen($dynamic_key)); $j++, $i++) {
                $finalKey .= $dynamic_key[$i] ^ $app_key[$j];
            }
        }

        $old_saltKey = '';

        for ($i = 0; $i < strlen($old_password);) {
            for ($j = 0; ($j < strlen($finalKey) && $i < strlen($old_password)); $j++, $i++) {
                $old_saltKey .= $old_password[$i] ^ $finalKey[$j];
            }
        }
        // return $saltKey;

        $new_saltKey = '';

        for ($i = 0; $i < strlen($new_password);) {
            for ($j = 0; ($j < strlen($finalKey) && $i < strlen($new_password)); $j++, $i++) {
                $new_saltKey .= $new_password[$i] ^ $finalKey[$j];
            }
        }
        // return $saltKey;

        $confirm_saltKey = '';

        for ($i = 0; $i < strlen($confirm_password);) {
            for ($j = 0; ($j < strlen($finalKey) && $i < strlen($confirm_password)); $j++, $i++) {
                $confirm_saltKey .= $confirm_password[$i] ^ $finalKey[$j];
            }
        }
        // return $saltKey;


        // echo "<br>old : ".$old_password." -- ".$old_saltKey."<br>";
        // echo "new : ".$new_password." -- ".$new_saltKey;
        // echo "<br><br>confirm : ".$confirm_password." -- ".$confirm_saltKey."<br>";

        $data = array(
            'username' => $username,
            'old_password' => $old_saltKey,
            'new_password' => $new_saltKey,
            'confirm_password' => $confirm_saltKey,
            'app_id' => $app_id,
        );

        // var_dump($data);
        // exit;

        $url = "http://lus.pdsb.id/ums/v1/change_password";
        // $url = "http://10.100.20.26:8080/umsws/public/umsapi/change_password";

        $req = Http::post($url, $data);
        // $req = [
        //     'status' => 'success',
        //     'message' => 'sukses ganti',
        //     'counter_pass' => 3
        // ];
        $datas = $req->json();
        // dd($datas);
        $status         = $datas['status'];
        $counter_pass   = $datas['counter_pass'];
        $message        = trim($datas['message']);

        // var_dump($datanya);
        // exit;


        $color = $status != 'success' ? 'danger' : 'success';



        // $alert = $this->session->set_flashdata('message', '<div class="alert alert-' . $color . '" role="alert">' . $message . '</div>');

        if ($counter_pass == '3') {
            // Session::flush();
            return redirect()->route('fa.logout', ['username' => $username])->with(['statusalert' => '1', 'text_a' => $message, 'icon_a' => $color]);
        }

        return redirect()->route('fa.dashboard')->with(['statusalert' => '1', 'title_a' => $message, 'icon_a' => $color]);
    }

    function logout(Request $request)
    {
        $app_id =  AntonioGabutz::app_config('app_id');
        $dynamic_key = AntonioGabutz::app_config('dynamic_key');
        $app_key =   substr(AntonioGabutz::app_config('app_key'), 0, 16);
        $finalKey = '';
        for ($i = 0; $i < strlen($dynamic_key);) {
            for ($j = 0; ($j < strlen($app_key) && $i < strlen($dynamic_key)); $j++, $i++) {
                $finalKey .= $dynamic_key[$i] ^ $app_key[$j];
            }
        }
        // $saltKey = '';

        // for ($i = 0; $i < strlen($password);) {
        //     for ($j = 0; ($j < strlen($finalKey) && $i < strlen($password)); $j++, $i++) {
        //         $saltKey .= $password[$i] ^ $finalKey[$j];
        //     }
        // } 
        $data = array(
            'username' => $request->username,
            'key' => $finalKey,
            'app_id' => $app_id,
        );
        $url = "http://lus.pdsb.id/ums/v1/logout";
        // $url = "http://gateway.pdsb.id/ums/v1/logout";
        // $url = "http://10.100.20.26/umsws8/public/umsapi/logout";

        $resp = Http::post($url, $data);

        if ($resp['status'] == 'success') {
            Session::flush();
            return redirect()->route('/');
        } else {
            return redirect()->route('dashboard');
        }
        // return $resp->body();
    }
}
