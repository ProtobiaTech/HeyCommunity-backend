<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Image, File;
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
        $this->middleware('auth', ['only' => ['postUpdate', 'postUpdateAvatar']]);
        $this->middleware('guest', ['only' => ['postSignUp', 'postLogIn']]);
    }

    /**
     * log out
     *
     * @return string True string
     */
    public function postLogOut()
    {
        if (Auth::user()->check()) {
            AUth::logout();
        }
        return [true];
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
            Auth::user()->login($User);
            return Auth::user()->user();
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
            Auth::user()->login($User);
            return $User;
        } else {
            return response($User, 500);
        }
    }

    /**
     * Update
     *
     * @param \Illuminate\Http\Request $request
     * @return object User model or failure info
     */
    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'nickname'  =>      'string|min:3|unique:users',
            'gender'    =>      'integer|max:2',
            'bio'       =>      'string',
        ]);

        $User = Auth::user()->user();
        if ($request->has('nickname')) {
            $User->nickname = $request->nickname;
        }
        if ($request->has('gender')) {
            $User->gender = $request->gender;
        }
        if ($request->has('bio')) {
            $User->bio = $request->bio;
        }
        $User->save();

        return $User;
    }

    /**
     * Update Avatar
     *
     * @param \Illuminate\Http\Request $request
     * @return object User model or failure info
     */
    public function postUpdateAvatar(Request $request)
    {
        $this->validate($request, [
            'uploads'   =>      'required',
        ]);


        $files = $request->file('uploads');
        $file = $files[0];

        $uploadPath = '/uploads/avatars/';
        $path = public_path() . $uploadPath;
        if (!File::exists($path)) {
            File::makeDirectory($path);
        }

        $fileName = date('Ymd-His_') . str_random(6) . '_' . $file->getClientOriginalName();
        $filePath = public_path() . $uploadPath . $fileName;
        $image = Image::make($file->getRealPath());
        $imageWidth = $image->width();
        $imageHeight = $image->height();
        $resize = $imageWidth < $imageHeight ? $imageWidth : $imageHeight;

        $ret = $image->crop($resize, $resize, 0, 0)->save($filePath);
        if ($ret) {
            $User = Auth::user()->user();
            $User->avatar = $uploadPath . $fileName;
            $User->save();

            return $User;
        } else {
            abort('Avatar update failed');
        }
    }

    /**
     * Get the user info
     *
     * @return object|string User model or failure info
     */
    public function getMyInfo()
    {
        if (Auth::user()->check()) {
            return Auth::user()->user();
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
