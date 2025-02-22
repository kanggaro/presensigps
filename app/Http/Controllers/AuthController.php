<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\alert;

class AuthController extends Controller
{
    // user
    public function loginAdmin(Request $request){

        if(Auth::guard('user')->attempt(['email'=> $request->email, 'password'=> $request->password])){
            return redirect('/panel/dashboardAdmin');
        }
        else{
            // dd($request->email);
            return redirect('/panel')->with(['warning' => 'NIK / Password Salah!']);
        }
    }

    // karyawan
    public function login(Request $request){

        if(Auth::guard('karyawan')->attempt(['k_nik'=> $request->nik, 'password'=> $request->password])){
            return redirect('/dashboard');
        }
        else{
            // dd($request->nik);
            return redirect('/')->with(['warning' => 'NIK / Password Salah!']);
        }
    }

    public function logout(){
        if(Auth::guard('karyawan')->check()){
            Auth::guard('karyawan')->logout();
            return redirect('/');
        }
    }

    public function logoutAdmin(){
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/panel');
        }
    }
}
