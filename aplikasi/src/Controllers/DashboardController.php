<?php

namespace Bryanjack\Aplikasi\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use App\Http\Controllers\Controller;
use Bryanjack\Cms\Models\Page;
use Bryanjack\Cms\Models\Post;
use Bryanjack\Dash\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use  Bryanjack\Aplikasi\Traits\LoginActions;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illum   inate\Http\Response
     */
    public function index(Request $request)
    {

        // dd(session('user_id'));
        return view('aplikasi::dashboard.index', [
            'title' => 'welcome dashboard'
        ]);
    }

    public function profil()
    {
        return view('aplikasi::dashboard.profil', [
            'title' => "Ganti Password"
        ]);
    }
    public function actionsave(Request $request)
    {

        try {
            $request->validate([
                'old_password' => $request->old_password,
                'new_password' => $request->new_password
            ]);
            if ($request->old_password != $request->new_password) {
                return response()->json([
                    ''
                ]);
            } 
            $par = [
                'old_password' => $request->old_password,
                'new_password' => $request->new_password,
            ];
            $this->LoginActions($par);
            return response()->json([
                'status' => 1,
                'msg' => 'Password berhasil di simpan'
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
