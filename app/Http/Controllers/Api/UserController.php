<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Hash, Auth;
use App\User;

class UserController extends Controller
{
    /**
     * The construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['postLogOut']]);
        $this->middleware('guest', ['only' => ['postSignUp', 'postLogIn']]);
    }

    /**
     * log out
     *
     * @return string True string
     */
    public function postLogOut()
    {
        if (Auth::check()) {
            AUth::logout();
        }
        return json_encode(true);
    }

    /**
     * Log in
     *
     * @param \Illuminate\Http\Request $request
     * @return object|string User model or failure info
     */
    public function postLogIn(Request $request)
    {
        $this->validate($request, [
            'phone'     =>  'required',
            'password'  =>  'required',
        ]);

        $User = User::where(['phone' => $request->phone])->first();
        if ($User && Hash::check($request->password, $User->password)) {
            Auth::login($User);
            return Auth::user();
        } else {
            return response('phone or password err', 403);
        }
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
            'password'  =>  'required',
        ]);

        $User = new User;
        $User->nickname     =   $request->nickname;
        $User->avatar       =   '/assets/images/userAvatar-default.png';
        $User->phone        =   $request->phone;
        $User->password     =   Hash::make($request->password);

        if ($User->save()) {
            Auth::login($User);
            return $User;
        } else {
            return response($User, 500);
        }
    }

    /**
     * Get the user info
     *
     * @return object|string User model or failure info
     */
    public function getMyInfo()
    {
        if (Auth::check()) {
            return Auth::user();
        } else {
            return response('', 404);
        }
    }

    /**
     * Get the specified user info
     *
     * @param integer $id The user id
     * @return object User model
     */
    public function getGetUser($id)
    {
        $this->validate($request, [
            'id'  =>  'required|integer',
        ]);

        return User::findOrFail($id);
    }
}
