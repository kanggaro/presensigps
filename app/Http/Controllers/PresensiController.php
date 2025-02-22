<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class PresensiController extends Controller
{
    public function create(){
        $today = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->k_nik;
        $isPresent = DB::table('tb_presensi')->where('p_tgl_presensi', $today)->where('p_nik', $nik)->count();

        $loc_kantor = DB::table("tb_lokasi")->where("l_id", 1)->first();
        // dd($loc_kantor);

        return view('presensi.create', compact('isPresent', 'loc_kantor'));
    }

    public function store(Request $request){

        $nik = Auth::guard('karyawan')->user()->k_nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');

        // 0.12659220553546074, 117.46808951888042 pc
        // 0.12652362633316988, 117.47786561467571 delima
        
        $loc_kantor = DB::table("tb_lokasi")->where("l_id", 1)->first();
        $explode_loc_kantor = explode(",", $loc_kantor->l_koordinat);
        $kantorLatitude = $explode_loc_kantor[0];
        $kantorLongitude = $explode_loc_kantor[1];
        $kantorRadius = $loc_kantor->l_radius;
        // dd($kantorRadius);

        $lokasi = $request->lokasi;
        $lokasiUser = explode(",", $lokasi);
        $userLatitude = $lokasiUser[0];
        $userLongitude = $lokasiUser[1];

        $jarak = $this->distance($kantorLatitude, $kantorLongitude, $userLatitude, $userLongitude);
        $radius = number_format(round($jarak["meters"]), 0, ',', '.');
        // $radius = round($jarak["meters"]);
        // dd($radius);
        
        $isPresent = DB::table('tb_presensi')->where('p_tgl_presensi', $tgl_presensi)->where('p_nik', $nik)->count();
        if($isPresent>0){$ket = "out";}
        else $ket = "in";

        $image = $request->image;
        $folder_path = "uploads/absensi/";
        $format_name = $nik . '-' . $tgl_presensi . "-" . $ket;
        $image_parts = explode(';base64', $image);
        $image_base64 = base64_decode($image_parts[1]);
        $file_name = $format_name .'.png';  
        $file = $folder_path . $file_name;
        // dd(Storage::path($file));


        // validasi radius
        if($radius > $kantorRadius){
            echo "error|Maaf Anda Berada diluar Radius, Jarak anda $radius meter dari kantor|radius";
        }
        else{
            // validasi absen
            if($isPresent > 0)
            { // jika sudah absen
                $data_pulang = [
                    'p_jam_out' => $jam,
                    'p_foto_out' => $file_name,
                    'p_lokasi_out' => $lokasi
                ];
    
                $update = DB::table('tb_presensi')->where('p_tgl_presensi', $tgl_presensi)->where('p_nik', $nik)->update($data_pulang);
                if($update){
                    echo "success|Terimakasih, Hati-Hati Di Jalan";
                    Storage::put($file, $image_base64);
                }else{
                    echo "error|Absen Gagal, Hubungi IT|out";
                }
            } 
            else 
            { // jika belum absen
                $data = [
                    'p_nik' => $nik,
                    'p_tgl_presensi' => $tgl_presensi,
                    'p_jam_in' => $jam,
                    'p_foto_in' => $file_name,
                    'p_lokasi_in' => $lokasi
                ];
                
                $simpan = DB::table('tb_presensi')->insert($data);
                if($simpan){
                    echo "success|Selamat Bekerja|in";
                    Storage::put($file, $image_base64);
                }else{
                    echo "error|Absen Gagal, Hubungi IT|in";
                }
            }
        }
    }

    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editProfile(Request $request){
        $nik = Auth::guard('karyawan')->user()->k_nik;
        $karyawan = DB::table("tb_karyawan")->where('k_nik',$nik)->first();
        // dd($karyawan);
        return view("presensi.editProfile", compact('karyawan'));
    }

    public function updateProfile(Request $request){
        $nik = Auth::guard('karyawan')->user()->k_nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table("tb_karyawan")->where("k_nik", $nik)->first();

        if($request->hasFile('foto')){
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        }
        else{
            $foto = $karyawan->k_foto;
        }

        if(empty($request->password)){
            $data = [
                'k_nama_lengkap' => $nama_lengkap,
                'k_no_hp' => $no_hp,
                'k_foto' => $foto
            ];
        }
        else{
            $data = [
                'k_nama_lengkap' => $nama_lengkap,
                'k_no_hp' => $no_hp,
                'k_foto' => $foto,
                'password' => $password
            ];
        }

        $update = DB::table("tb_karyawan")->where("k_nik", $nik)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folder_path = "uploads/karyawan/";
                $request->file('foto')->storeAs($folder_path, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil di Update']);
        }
        else{
            return Redirect::back()->with(['error' => 'Data Gagal di Update']);
        }
    }

    public function history(Request $request){
        $monthName = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view("presensi.history", compact("monthName"));
    }

    public function getHistory(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        // alert($bulan . "dan" . $tahun);

        $nik = Auth::guard('karyawan')->user()->k_nik;

        $history = DB::table("tb_presensi")
            ->whereRaw('MONTH(p_tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(p_tgl_presensi)="' . $tahun . '"')
            ->where("p_nik", $nik)
            ->orderBy('p_tgl_presensi')
            ->get();

        return view('presensi.getHistory', compact("history"));
    }

    public function izin(Request $request){
        $nik = Auth::guard("karyawan")->user()->k_nik;
        $dataIzin = DB::table("tb_perizinan")->where("pz_nik", $nik)->get();

        return view('presensi.izin', compact("dataIzin"));
    }

    public function createIzin(){

        return view("presensi.createIzin");
    }

    public function isIzin(Request $request){
        $nik = Auth::guard('karyawan')->user()->k_nik;
        $tgl_izin = $request->tgl_izin;
        $cek_perizinan = DB::table('tb_perizinan')
            ->where('pz_nik', $nik)
            ->where('pz_tgl_izin', $tgl_izin)
            ->get();
        $is_izin = count($cek_perizinan);

        return $is_izin;
    }

    public function storeIzin(Request $request){
        $nik = Auth::guard("karyawan")->user()->k_nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;
        
        $data = [
            "pz_nik" => $nik,
            "pz_tgl_izin" => $tgl_izin,
            "pz_status" => $status,
            "pz_keterangan" => $keterangan
        ];

        $simpan = DB::table('tb_perizinan')->insert($data);
        if($simpan){
            return redirect("/presensi/izin")->with(["success" => "Data Berhasil Disimpan"]);
        }
        else{
            return redirect("/presensi/izin")->with(["error" => "Data gagal disimpan"]);
        }
    }

    public function monitoring(){
        return view('presensi.monitoring');
    }

    public function getPresensi(Request $request){
        $tanggal = $request->tanggal;
        $monitoring = DB::table('tb_presensi')
                            ->select('tb_presensi.*', 'k_nama_lengkap','d_nama_dept')
                            ->join('tb_karyawan', 'tb_presensi.p_nik', '=', 'tb_karyawan.k_nik')
                            ->join('tb_departement', 'tb_karyawan.k_kode_dept', '=', 'tb_departement.d_kode_dept')
                            ->where('p_tgl_presensi', $tanggal)
                            ->get();
        
        return view('presensi.getPresensi', compact('monitoring'));
    }

    public function showMaps(Request $request){
        $p_id = $request->p_id;
        $coordinate = DB::table('tb_presensi')
            ->join('tb_karyawan', 'tb_presensi.p_nik', '=', 'tb_karyawan.k_nik')
            ->where('p_id', $p_id)
            ->first();
        $coordinate_kantor = DB::table('tb_lokasi')->where('l_id',1)->first();
        
        return view('presensi.showMaps', compact('coordinate', 'coordinate_kantor'));
    }

    public function report(){        
        $monthName = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = Karyawan::get();

        return view('presensi.report', compact('monthName', 'karyawan'));
    }

    public function reportPrint(Request $request){
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $nama_karyawan = $request->nama_karyawan;
        
        $monthName = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        $karyawan = Karyawan::query()
                    ->join('tb_departement', 'tb_karyawan.k_kode_dept', '=', 'tb_departement.d_kode_dept')
                    ->where('k_nik', $nama_karyawan)
                    ->first();
                    // dd();
        $reportPresensi = DB::table('tb_presensi')
                    ->where('p_nik', $nama_karyawan)
                    ->whereRaw('YEAR(p_tgl_presensi)="' . $tahun . '"')
                    ->whereRaw('MONTH(p_tgl_presensi)="' . $bulan . '"')
                    ->orderBy('p_tgl_presensi')
                    ->get();

        return view('presensi.reportPrint', compact('tahun', 'bulan', 'monthName', 'karyawan', 'reportPresensi'));
    }

    public function rekap() {             
        $monthName = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        return view('presensi.rekap', compact('monthName'));
    }

    public function rekapPrint(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $monthName = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        $rekap = DB::table('tb_presensi')
            ->selectRaw('tb_presensi.p_nik, k_nama_lengkap,
                MAX(IF(DAY(p_tgl_presensi) = 1, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_1,
                MAX(IF(DAY(p_tgl_presensi) = 2, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_2,
                MAX(IF(DAY(p_tgl_presensi) = 3, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_3,
                MAX(IF(DAY(p_tgl_presensi) = 4, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_4,
                MAX(IF(DAY(p_tgl_presensi) = 5, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_5,
                MAX(IF(DAY(p_tgl_presensi) = 6, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_6,
                MAX(IF(DAY(p_tgl_presensi) = 7, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_7,
                MAX(IF(DAY(p_tgl_presensi) = 8, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_8,
                MAX(IF(DAY(p_tgl_presensi) = 9, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_9,
                MAX(IF(DAY(p_tgl_presensi) = 10, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_10,
                MAX(IF(DAY(p_tgl_presensi) = 11, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_11,
                MAX(IF(DAY(p_tgl_presensi) = 12, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_12,
                MAX(IF(DAY(p_tgl_presensi) = 13, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_13,
                MAX(IF(DAY(p_tgl_presensi) = 14, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_14,
                MAX(IF(DAY(p_tgl_presensi) = 15, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_15,
                MAX(IF(DAY(p_tgl_presensi) = 16, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_16,
                MAX(IF(DAY(p_tgl_presensi) = 17, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_17,
                MAX(IF(DAY(p_tgl_presensi) = 18, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_18,
                MAX(IF(DAY(p_tgl_presensi) = 19, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_19,
                MAX(IF(DAY(p_tgl_presensi) = 20, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_20,
                MAX(IF(DAY(p_tgl_presensi) = 21, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_21,
                MAX(IF(DAY(p_tgl_presensi) = 22, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_22,
                MAX(IF(DAY(p_tgl_presensi) = 23, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_23,
                MAX(IF(DAY(p_tgl_presensi) = 24, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_24,
                MAX(IF(DAY(p_tgl_presensi) = 25, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_25,
                MAX(IF(DAY(p_tgl_presensi) = 26, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_26,
                MAX(IF(DAY(p_tgl_presensi) = 27, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_27,
                MAX(IF(DAY(p_tgl_presensi) = 28, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_28,
                MAX(IF(DAY(p_tgl_presensi) = 29, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_29,
                MAX(IF(DAY(p_tgl_presensi) = 30, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_30,
                MAX(IF(DAY(p_tgl_presensi) = 31, CONCAT(p_jam_in, "-", IFNULL(p_jam_out,"00:00:00")),"")) as tgl_31                
                ')
            ->join('tb_karyawan','tb_presensi.p_nik', '=', 'tb_karyawan.k_nik')
            ->whereRaw('MONTH(p_tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(p_tgl_presensi)="' . $tahun . '"')
            ->groupBy('tb_presensi.p_nik', 'tb_karyawan.k_nama_lengkap')
            ->get();
        // dd($rekap);

        return view('presensi.rekapPrint', compact('monthName','bulan', 'tahun', 'rekap'));
    }

    public function perizinan(Request $request){
        $queryPerizinan = DB::table('tb_perizinan')
            ->select('*')
            ->join('tb_karyawan', 'tb_karyawan.k_nik', '=', 'tb_perizinan.pz_nik')
            ->orderBy('pz_tgl_izin', 'desc');
        if(!empty($request->from) && !empty($request->from))
            $queryPerizinan->whereBetween('pz_tgl_izin',[$request->from, $request->to]);
        if(!empty($request->nama))
            $queryPerizinan->where('k_nama_lengkap', 'like', '%' .$request->nama. '%');
        if(!empty($request->nik))
            $queryPerizinan->where('k_nik', 'like', '%' .$request->nik. '%');
        if($request->status != '')
            $queryPerizinan->where('pz_status_approved', $request->status);

        $perizinan=$queryPerizinan->paginate(3)->appends($request->all());
        // dd($perizinan);

        return view('presensi.perizinan', compact('perizinan'));
    }

    public function perizinanStatus($pz_id, $pz_status){

        $status_approved = DB::table('tb_perizinan')
            ->where('pz_id', $pz_id)
            ->update(['pz_status_approved'=> $pz_status]);

        if($status_approved)
            return Redirect::back()->with(['success' => 'Status berhasil diupdate']);
        else
            return Redirect::back()->with(['error' => 'Status gagal diupdate']);
    }
}
