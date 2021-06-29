<?php

namespace Bryanjack\Aplikasi\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lib\AntonioGabutz;
use DataTales;
use Bryanjack\Aplikasi\Models\Tmmodul;

class ModulsubController extends Controller
{


    protected $request;
    protected $route;
    protected $view;
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = 'aplikasi::modulapp.';
        $this->route   = 'modulapp.';
    }


    public function index()
    {
        return view(
            'aplikasi::submodulapp.index',
            ['title' => 'Modul aplikasi']
        );
    }

    public function api()
    {
        $data = Tmmodul::where('id_parent', '!=', 0)
            ->get();
        return \DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action', 'id'])
            ->toJson();
    }
    public function create()
    {
        $fonts = AntonioGabutz::fontawesome();
        $parent = Tmmodul::where('id_parent', '=', 0)->get();
        return view('aplikasi::submodulapp.form_add', [
            'title' => 'Tambah Menu',
            'parent' => $parent,
            'font' => $fonts,
        ]);
    }

    public function store()
    {

        try {
            $fdata = new Tmmodul;

            $fdata->id_parent = $this->request->id_parent;
            $fdata->nama_menu = $this->request->nama_menu;
            $fdata->icon = $this->request->icon;
            $fdata->link = $this->request->link;
            $fdata->aktif = $this->request->aktif;
            $fdata->urutan = $this->request->urutan;
            $fdata->level = $this->request->level;
            $fdata->users_id = $this->request->users_id;
            $fdata->created_at = $this->request->created_at;
            $fdata->updated_at = $this->request->updated_at;

            $fdata->save();
            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Throwable $th) {
            return $th;
            // return response()->json([
            //     'status' => 2,
            //     'msg' => $th,
            // ]);
        }
    }

    public function edit($id)
    {
        $f = Tmmodul::findOrFail($id);
        return view('aplikasi::submodulapp.form_add', [
            'title' => 'Tambah Menu',
            'id' => $f->id,
            'id_parent' => $f->id_parent,
            'nama_menu' => $f->nama_menu,
            'icon' => $f->icon,
            'link' => $f->link,
            'aktif' => $f->aktif,
            'urutan' => $f->urutan,
            'position' => $f->position,
            'level' => $f->level,
            'users_id' => $f->users_id,
            'created_at' => $f->created_at,
            'updated_at' => $f->updated_at,
        ]);
    }
    public function update($id)
    {
        try {
            $fdata = Tmmodul::find($id);
            $fdata->id = $this->request->id;
            $fdata->id_parent = $this->request->id_parent;
            $fdata->nama_menu = $this->request->nama_menu;
            $fdata->icon = $this->request->icon;
            $fdata->link = $this->request->link;
            $fdata->aktif = $this->request->aktif;
            $fdata->urutan = $this->request->urutan;
            $fdata->position = $this->request->position;
            $fdata->level = $this->request->level;
            $fdata->users_id = $this->request->users_id;
            $fdata->created_at = $this->request->created_at;
            $fdata->updated_at = $this->request->updated_at;

            $fdata->save();
            return response()->json([
                'status' => 2,
                'msg' => 'data berhasil disimpan',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 2,
                'msg' => $th,
            ]);
        }
    }
    public function destroy(Request $request)
    {

        try {
            if (is_array($this->request->id))
                Tmmodul::whereIn('id', $this->request->id)->delete();
            else
                Tmmodul::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (Tmmodul $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}
