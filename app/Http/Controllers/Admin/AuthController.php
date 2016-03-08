<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth, Hash;

use App\Tenant;

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

        $model = Tenant::where(['email' => $request->email])->first();
        if ($model && Hash::check($request->password, $model->password)) {
            Auth::tenant()->login($model);
            return redirect()->route('admin.home');
        } else {
            $request->flash();
            return redirect()->back()->withErrors(['fail' => 'email or password error']);
        }
    }

    /**
     */
    public function anyLogout()
    {
        Auth::tenant()->logout();
        return redirect()->route('home');
    }

}

