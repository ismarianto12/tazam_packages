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
// use Bryanjack\Aplikasi\Blender\LoginActions as Lg;
use Bryanjack\Aplikasi\Traits\LoginActions as Lg;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illum   inate\Http\Response
     */
    use Lg;

    public function AuthProcessed(Request $request)
    {
        return $this->DoprocessLogin($request);
    }
}
