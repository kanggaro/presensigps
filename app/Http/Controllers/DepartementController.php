<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departement = DB::table('tb_departement')->orderBy('d_kode_dept');

        if(!empty($request->nama_kode)){
            $departement->where(function($query) use ($request){
                $query
                ->where('d_nama_dept', 'like', '%' .$request->nama_kode. '%')
                ->orWhere('d_kode_dept', 'like', '%' .$request->nama_kode. '%');
            });
        }        
        $departement = $departement->get();
        return view('departement.index', compact('departement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;

        $data = [
            'd_kode_dept' => $kode_dept,
            'd_nama_dept' => $nama_dept
        ];


        try{
            $storeNewDept = DB::table('tb_departement')->insert($data);

            return Redirect::back()->with(['success' => 'Departement Berhasil di Tambahkan']);
        }catch(\exception $e){
            return Redirect::back()->with(['error' => 'Departement Gagal di Tambahkan']);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Departement $departement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $departement = DB::table('tb_departement')->where('d_kode_dept', $kode_dept)->first();
        return view('departement.edit', compact('departement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($kode_dept, Request $request)
    {
        $nama_dept = $request->nama_dept;
        
        $data = [
            'd_nama_dept' => $nama_dept
        ];

        try{
            DB::beginTransaction();
            $updateDepartement = DB::table('tb_departement')->Where('d_kode_dept', $kode_dept)->update($data);

            DB::commit();
            return Redirect::back()->with(['success' => 'Departement Berhasil di Perbarui']);
        }
        catch(\exception $e){
            DB::rollBack();
            return Redirect::back()->with(['error' => 'Departement Gagal di Perbarui']);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($kode_dept)
    {
        $delete = Departement::query()->where('d_kode_dept', $kode_dept)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Departement Berhasil dihapus']);
        }
        else{
            return Redirect::back()->with(['success'=>'Departement Gagal dihapus']);
        }
    }
}
