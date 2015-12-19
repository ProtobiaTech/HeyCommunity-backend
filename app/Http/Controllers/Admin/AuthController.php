<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth, Hash;

use App\User;

class AuthController extends Controller
{
    /**
     */
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    /**
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'     =>  'required',
            'password'  =>  'required',
        ]);

        $where = [
            'email'     =>  $request->email,
        ];
        $model = User::where($where)->first();
        if ($model && Hash::check($request->password, $model->password)) {
            Auth::login($model);
            return redirect()->route('admin.home');
        } else {
            return redirect()->back();
        }
    }

    /**
     */
    public function anyLogout()
    {
        Auth::logout();
        return redirect()->route('admin.home');
    }

}

