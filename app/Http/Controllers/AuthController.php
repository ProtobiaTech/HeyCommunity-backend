<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Auth;
use Hash;

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
    public function getSignup()
    {
        return view('auth.signup');
    }

    /**
     *
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'phone'     =>      'required|integer',
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

    /**
     * Sign up
     *
     * @param \Illuminate\Http\Request $request
     * @return object|string User model or failure info
     */
    public function postSignUp(Request $request)
    {
        $this->validate($request, [
            'nickname'  =>  'required|unique:users',
            'phone'     =>  'required|unique:users',
            'code'      =>  'required|integer',
            'password'  =>  'required',
        ]);

        if (session('signUpVerificationExpire') > time() &&
            session('signUpVerificationCode') == $request->code &&
            session('signUpVerificationPhone') == $request->phone
        ) {
            $user = new User;
            $user->nickname     =   $request->nickname;
            $user->phone        =   $request->phone;
            $user->password     =   Hash::make($request->password);

            if ($user->save()) {
                session()->remove('signUpVerificationExpire');
                session()->remove('signUpVerificationCode');
                session()->remove('signUpVerificationPhone');

                Auth::user()->login($user);

                return redirect('timeline');
            } else {
                return back();
            }
        } else {
            return response('The Verification Code Invalid', 403);
        }
    }
}
