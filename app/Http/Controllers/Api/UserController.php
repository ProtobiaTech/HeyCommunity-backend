<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Hash, Auth;

class UserController extends Controller
{
    /**
     * Sign in
     */
    public function getSignOut()
    {
        if (Auth::user()->check()) {
            AUth::user()->logout();
        }
        return null;
    }

    /**
     * Sign in
     */
    public function postSignIn(Request $request)
    {
        $this->validate($request, [
            'phone'     =>  'required',
            'password'  =>  'required',
        ]);

        $User = User::where(['phone' => $request->phone])->first();
        if ($User && Hash::check($request->password, $User->password)) {
            Auth::user()->login($User);
            return $User;
        } else {
            return response('phone or password err', 403);
        }
    }

    /**
     * Sign up
     */
    public function postSignUp(Request $request)
    {
        $this->validate($request, [
            'nickname'  =>  'required|unique:users',
            'phone'     =>  'required|unique:users',
            'password'  =>  'required',
        ]);

        $User = new User;
        $User->nickname     =   $request->nickname;
        $User->avatar       =   '/assets/images/userAvatar-default.png';
        $User->phone        =   $request->phone;
        $User->password     =   Hash::make($request->password);

        if ($User->save()) {
            Auth::user()->login($User);
            return $User;
        } else {
            return response($User, 500);
        }
    }

    /**
     * SignUp verify captcha
     */
    public function postSignUpVerifyCaptcha(Request $request)
    {
        $this->validate($request, [
            'phone'     =>  'required|unique:users',
            'captcha'   =>  'required',
        ]);

        // validate captcha
    }

    /**
     * Reponse the user info
     */
    public function getUserInfo()
    {
        if (Auth::user()->check()) {
            return Auth::user()->user();
        } else {
            return null;
        }
    }
}
