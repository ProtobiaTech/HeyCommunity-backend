<?php

namespace App\Http\Controllers\Dashboard;

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
        return view('dashboard.home.index');
    }

    /**
     *
     */
    public function getLogOut() {
        Auth::tenant()->logout();

        return redirect()->to('dashboard/index');
    }

    /**
     *
     */
    public function getLogIn()
    {
        return view('dashboard.home.login');
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

        if (Auth::tenant()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->to('dashboard');
        } else {
            return back()->withInput()->withErrors(['fail' => trans('dashboard.The email or password is incorrect')]);
        }
    }
}
