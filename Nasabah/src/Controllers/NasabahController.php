<?php

namespace Bryanjack\Nasabah\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bryanjack\Cms\Models\Page;
use Bryanjack\Cms\Models\Post;
use Bryanjack\Dash\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class NasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('nasabah::index');
    }
}
