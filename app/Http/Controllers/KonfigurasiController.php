<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function konfigurasiLokasi(){
        $loc_kantor = DB::table('tb_lokasi')->where('l_id',1)->first();

        return view("konfigurasi.lokasi", compact('loc_kantor'));
    }

    public function updateLokasi(Request $request){
        
        $request->validate([
            'koordinat' => ['nullable','regex:/^\S+$/']
        ],[
            'koordinat.regex' => 'Gunakan "," tanpa spasi untuk pemisah lat dan lng'
        ]);

        $koordinat = $request->koordinat;
        $radius = $request->radius;
        // dd($radius);

        $loc_kantor = DB::table('tb_lokasi')->where('l_id',1)->first();
        $old_koordinat = $loc_kantor->l_koordinat;
        $old_radius = $loc_kantor->l_radius;
        if($koordinat == null) $koordinat = $old_koordinat;
        if($radius == null) $radius = $old_radius;

        $data = [
            "l_koordinat" => $koordinat,
            "l_radius" => $radius
        ];

        $updateLokasi = DB::table('tb_lokasi')->where('l_id', 1)->update($data);
        if($updateLokasi){
            return Redirect::back()->with(['success'=>'Konfigurasi lokasi berhasil diupdate']);
        }
        else{
            return Redirect::back()->with(['error'=>'Konfigurasi lokasi gagal diupdate']);
        }

        return view("konfigurasi.lokasi");
    }
}
