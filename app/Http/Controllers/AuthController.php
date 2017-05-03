<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class AuthController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['getLogout']]);
        $this->middleware('guest', ['only' => ['getLogin', 'postLogin']]);
    }

    /**
     *
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     *
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'phone'     =>      'required|string',
            'password'  =>      'required|string',
        ]);

        if (Auth::user()->attempt(['phone' => $request->phone, 'password' => $request->password])) {
            return redirect()->back();
        } else {
            return back()->withInput()->withErrors(['fail' => trans('dashboard.The phone or password is incorrect')]);
        }
    }

    /**
     *
     */
    public function getLogout()
    {
        Auth::user()->logout();
        return redirect()->back();
    }
}
