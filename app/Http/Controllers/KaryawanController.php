<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class KaryawanController extends Controller
{
    public function karyawan(Request $request){

        
        // query eloquent
        $queryDataKaryawan = Karyawan::query()
            ->select('tb_karyawan.*', 'd_nama_dept')
            ->join('tb_departement', 'tb_karyawan.k_kode_dept', '=', 'tb_departement.d_kode_dept')
            ->orderBy('k_nama_lengkap');

        // query builder
        // $queryDataKaryawan = DB::table('tb_karyawan')
        // ->select('tb_karyawan.*', 'tb_departement.d_nama_dept')
        // ->join('tb_departement', 'tb_karyawan.k_kode_dept', '=', 'tb_departement.d_kode_dept')
        // ->orderBy('tb_karyawan.k_nama_lengkap')
        // ->get();

        if(!empty($request->nama_nik)){
            $queryDataKaryawan->where(function($query) use ($request){
                $query
                    ->Where('k_nik', 'like', '%' .$request->nama_nik. '%')
                    ->orWhere('k_nama_lengkap', 'like', '%' .$request->nama_nik. '%');
            });
        }
        // elseif(!empty($request->kode_dept) && empty($request->nama_karyawan)){
        if(!empty($request->kode_dept)){
            $queryDataKaryawan->where('k_kode_dept', $request->kode_dept);
        }
        
        $dataKaryawan = $queryDataKaryawan->paginate(11);
     
        $departement = DB::table('tb_departement')->get();

        return view('karyawan.index', compact('dataKaryawan', 'queryDataKaryawan', 'departement'));
    }

    public function store(Request $request){

        $request->validate([
            'nik' => 'required|unique:tb_karyawan,k_nik',
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'nohp' => 'required|regex:/^[0-9]+$/|min:10|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kode_dept' => 'required|exists:tb_departement,d_kode_dept',
        ],[        
            'nik.required' => 'NIK wajib diisi!',
            'nik.unique' => 'NIK sudah terdaftar!',
            'nama_lengkap.required' => 'Nama Lengkap wajib diisi!',
            'jabatan.required' => 'Jabatan wajib diisi!',
            'nohp.required' => 'Nomor HP wajib diisi!',
            'nohp.regex' => 'Nomor HP hanya boleh berisi angka!',
            'nohp.min' => 'Nomor HP minimal 10 digit!',
            'nohp.max' => 'Nomor HP maksimal 15 digit!',
            'foto.image' => 'File harus berupa gambar!',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg!',
            'foto.max' => 'Ukuran gambar maksimal 2MB!',
            'kode_dept.required' => 'Departemen wajib dipilih!',
            'kode_dept.exists' => 'Departemen yang dipilih tidak valid!',
        ]);

        $nik = $request->nik;
        $namaLengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $noHp = $request->nohp;
        $password = Hash::make('12345');
        $kodeDept = $request->kode_dept;

        $karyawan = DB::table('tb_karyawan')->where('k_nik', $nik)->first();

        if($request->hasFile('foto')){
            $storeFormatFoto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
            $foto = $storeFormatFoto;
        }
        else{
            $foto = null;
        }

        // $storeFoto = $folderPath . $formatName;

        try{
            DB::beginTransaction();
            $data = [
                'k_nik'=> $nik,
                'k_nama_lengkap'=> $namaLengkap,
                'k_jabatan'=> $jabatan,
                'k_no_hp'=> $noHp,
                'k_foto'=> $foto,
                'k_kode_dept'=> $kodeDept,
                'password'=> $password
            ];

            $storeNewKaryawan = DB::table('tb_karyawan')->insert($data);
            if($storeNewKaryawan && $foto != null){    
                $folderPath = "uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            
            DB::commit();
    
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan!']);

        }catch (\Exception $e){
            dd($e->getMessage());

            DB::rollBack();
            return Redirect::back()->with(['error'=>'Data Gagal Disimpan']);
        }    
    }


    public function edit(Request $request){
        $nik = $request->nik;
        
        $karyawan = DB::table('tb_karyawan')->where('k_nik', $nik)->first();
        $departement = DB::table('tb_departement')->get();

        return view('karyawan.edit', compact('departement', 'karyawan'));
    }

    public function update($nik, Request $request){
        $request->validate([
            // 'nik' => 'required|unique:tb_karyawan,k_nik',
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'nohp' => 'required|regex:/^[0-9]+$/|min:10|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kode_dept' => 'required|exists:tb_departement,d_kode_dept',
        ],[        
            // 'nik.required' => 'NIK wajib diisi!',
            // 'nik.unique' => 'NIK sudah terdaftar!',
            'nama_lengkap.required' => 'Nama Lengkap wajib diisi!',
            'jabatan.required' => 'Jabatan wajib diisi!',
            'nohp.required' => 'Nomor HP wajib diisi!',
            'nohp.regex' => 'Nomor HP hanya boleh berisi angka!',
            'nohp.min' => 'Nomor HP minimal 10 digit!',
            'nohp.max' => 'Nomor HP maksimal 15 digit!',
            'foto.image' => 'File harus berupa gambar!',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg!',
            'foto.max' => 'Ukuran gambar maksimal 2MB!',
            'kode_dept.required' => 'Departemen wajib dipilih!',
            'kode_dept.exists' => 'Departemen yang dipilih tidak valid!',
        ]);

        // $nik = $request->nik;
        $namaLengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $noHp = $request->nohp;
        $kodeDept = $request->kode_dept;
        $foto = $request->foto;

        // $password = Hash::make('12345');
        $fotoLamaObject = DB::table('tb_karyawan')->select('k_foto')->where('k_nik', $nik)->first();
        $fotoLama = $fotoLamaObject->k_foto;
 
        if($request->hasFile('foto')){
            $storeFormatFoto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
            $foto = $storeFormatFoto;
        }
        else{
            $foto = $fotoLama;
        }

        try{
            DB::beginTransaction();
            $data = [
                'k_nik'=> $nik,
                'k_nama_lengkap'=> $namaLengkap,
                'k_jabatan'=> $jabatan,
                'k_no_hp'=> $noHp,
                'k_foto'=> $foto,
                'k_kode_dept'=> $kodeDept,
                // 'password'=> $password
            ];

            $updateDataKaryawan = DB::table('tb_karyawan')->where('k_nik', $nik)->update($data);
            if($updateDataKaryawan && $foto != null){    
                $folderPath = "uploads/karyawan/";
                $folderPathFotoLama = "uploads/karyawan/".$fotoLama;
                Storage::delete($folderPathFotoLama);
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            
            DB::commit();
    
            return Redirect::back()->with(['success' => 'Data Berhasil DiUpdate!']);

        }catch (\Exception $e){
            // dd($e->getMessage());

            DB::rollBack();
            return Redirect::back()->with(['error'=>'Data Gagal DiUpdate!']);
        }
    }

    public function delete($nik){
        $delete = DB::table('tb_karyawan')->where('k_nik', $nik)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'NIK : ' . $nik . ' Berhasil di Hapus']);
        }else{
            return Redirect::back()->with(['error' => 'NIK : ' . $nik . ' Gagal di Hapus']);            
        }
    }
}
