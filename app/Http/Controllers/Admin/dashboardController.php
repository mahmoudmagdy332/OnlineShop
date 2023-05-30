<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function dashboardVeiw(){
       return view('admin.dashboard');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login.admin.view');
    }
}
