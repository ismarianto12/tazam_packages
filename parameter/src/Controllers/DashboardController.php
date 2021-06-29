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

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illum   inate\Http\Response
     */
    public function index()
    {
        
        return view('aplikasi::dashboard.index',[
            'title'=>'welcome dashboard'
        ]);
    }
}
