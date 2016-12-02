<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class HomeController extends Controller
{
    /**
     *
     */
    public function getIndex()
    {
        return view('admin.home.index');
    }

    /**
     *
     */
    public function getLogOut() {
        Auth::admin()->logout();

        return redirect()->to('admin/index');
    }

    /**
     *
     */
    public function getLogIn()
    {
        return view('admin.home.login');
    }

    /**
     *
     */
    public function postLogIn(Request $request)
    {
        $this->validate($request, [
            'email'     =>      'required|email',
            'password'  =>      'required|string',
        ]);

        if (Auth::admin()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->to('admin');
        } else {
            return back()->withInput()->withErrors(['fail' => trans('dashboard.The email or password is incorrect')]);
        }
    }
}
