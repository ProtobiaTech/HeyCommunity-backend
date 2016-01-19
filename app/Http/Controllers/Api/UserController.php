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
            return response(null, 403);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
