<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $today = date("Y-m-d");
        $thisMonth = date("m")*1;
        $thisYear = date("Y");
        $nik = Auth::guard("karyawan")->user()->k_nik;

        $presensiToday = DB::table('tb_presensi')->where('p_nik', $nik)->where("p_tgl_presensi", $today)->first();

        $monthName = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $historyThisMonth = DB::table("tb_presensi")
            ->where("p_nik", $nik)
            ->whereRaw('MONTH(p_tgl_presensi)="' . $thisMonth . '"')
            ->whereRaw('YEAR(p_tgl_presensi)="' . $thisYear . '"')
            ->orderBy("p_tgl_presensi")
            ->get();

        $rekapPresence = DB::table("tb_presensi")
            ->selectRaw('COUNT(p_nik) as jmlHadir, SUM(IF(p_jam_in > "07:00" , 1, 0)) as jmlTelat')
            ->where('p_nik', $nik)
            ->whereRaw('MONTH(p_tgl_presensi)="' . $thisMonth . '"')
            ->whereRaw('YEAR(p_tgl_presensi)="' . $thisYear . '"')
            ->first();

        $rekapIzin = DB::table("tb_perizinan")
            ->selectRaw('SUM(IF(pz_status="i",1,0)) as jmlIzin, SUM(IF(pz_status="s",1,0)) as jmlSakit')
            ->where('pz_nik',$nik)
            ->whereRaw('MONTH(pz_tgl_izin)="' . $thisMonth . '"')
            ->whereRaw('YEAR(pz_tgl_izin)="' . $thisYear . '"')
            ->where('pz_status_approved', 1)
            ->first();

        $leaderboard = DB::table("tb_presensi")
            ->join("tb_karyawan", "tb_karyawan.k_nik", "=", "tb_presensi.p_nik")
            ->WHERE("p_tgl_presensi", $today)
            ->orderBy("p_jam_in")
            ->get();

        // dd($leaderboard);
        return view('dashboard.dashboard', compact("presensiToday", "historyThisMonth", "thisMonth", "thisYear", "monthName", "rekapPresence", "leaderboard", "rekapIzin"));
    }

    public function dashboardAdmin(){        
        $today = date("Y-m-d");;

        $rekapPresence = DB::table("tb_presensi")
            ->selectRaw('COUNT(p_nik) as jmlHadir, SUM(IF(p_jam_in > "07:00" , 1, 0)) as jmlTelat')
            ->where('p_tgl_presensi', $today)
            ->first();

        $rekapIzin = DB::table("tb_perizinan")
            ->selectRaw('SUM(IF(pz_status="i",1,0)) as jmlIzin, SUM(IF(pz_status="s",1,0)) as jmlSakit')
            ->where('pz_tgl_izin', $today)
            ->where('pz_status_approved', 1)
            ->first();

        return view('dashboard.dashboardAdmin', compact('rekapPresence', 'rekapIzin'));
    }

}
