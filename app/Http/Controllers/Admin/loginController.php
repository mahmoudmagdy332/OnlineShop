<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\loginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function loginAdminVeiw(){
        return view('Admin.auth.login');
    }
    public function login(loginRequest $request)
    {
        if(auth()->guard('admin')->attempt(['userName'=>$request->userName,'password'=>$request->password]))
    {
        return redirect()->route('admin.dashboard');

    }
    return back()->withErrors([
        'password' => 'user name or password is incorrect .',
    ]);
}



}
