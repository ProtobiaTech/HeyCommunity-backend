<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Hash, Auth;
use Dev4living\LeanCloudSMS\LeanCloudSMS;

class UserController extends Controller
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->middleware('auth.user', ['only' => ['postVerifyPassword', 'postSetNewPassword']]);
    }

    /**
     * Sign in
     */
    public function getLogOut()
    {
        if (Auth::user()->check()) {
            AUth::user()->logout();
        }
        return null;
    }

    /**
     * Log in
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
            Auth::login($User);
            return $User;
        } else {
            return response($User, 500);
        }
    }

    /**
     * Get captcha
     */
    public function anyGetCaptcha(Request $request)
    {
        $this->validate($request, [
            'phone'     =>  'required',
            //@todo fix by sign up 'phone'     =>  'required|unique:users',
        ]);

        $config['header'] = explode('|', env('LEANCLOUD_REQUEST_SMS_HEADER'));
        $data = '{"mobilePhoneNumber": "' . $request->phone . '"}';

        $ret = LeanCloudSMS::init($config)->requestSmsCode($data);
        $ret = json_decode($ret, true);
        if (isset($ret['error'])) {
            return response($ret['error'], 500);
        } else {
            return $ret;
        }
    }

    /**
     * Verify captcha
     */
    public function postVerifyCaptcha(Request $request)
    {
        $this->validate($request, [
            'phone'     =>  'required',
            //@todo fix by sign up 'phone'     =>  'required|unique:users',
            'captcha'   =>  'required',
        ]);

        $config['header'] = explode('|', env('LEANCLOUD_VERIFY_SMS_HEADER'));
        $data = [
            'mobilePhoneNumber'     =>  $request->phone,
            'verifyCode'            =>  $request->captcha,
        ];
        $ret = LeanCloudSMS::init($config)->verifySmsCode($data);
        $ret = json_decode($ret, true);
        if (isset($ret['error'])) {
            return response($ret['error'], 500);
        } else {
            return $ret;
            // @todo set verifyed
        }
    }

    /**
     *
     */
    public function postVerifyPassword(Request $request)
    {
        $this->validate($request, [
            'password'      =>  'required',
        ]);

        $User = Auth::user()->user();
        if ($User && Hash::check($request->password, $User->password)) {
            return $User;
        } else {
            return response('verify fail', 400);
        }
    }

    /**
     *
     */
    public function postResetPassword(Request $request)
    {
        $this->validate($request, [
            'phone'         =>  'required',
            'new_password'      =>  'required',
        ]);


        $User = User::where(['phone' => $request->phone])->firstOrFail();
        $User->password = Hash::make($request->new_password);

        if ($User->save()) {
            return $User;
        } else {
            return response('fail', 500);
        }
    }

    /**
     *
     */
    public function postSetNewPassword(Request $request)
    {
        $this->validate($request, [
            'old_password'      =>  'required',
            'new_password'      =>  'required',
        ]);


        $User = Auth::user()->user();
        if ($User && Hash::check($request->old_password, $User->password)) {
            $User->password = Hash::make($request->new_password);
            $User->save();

            return $User;
        } else {
            return response('verify fail', 400);
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

        $config['header'] = explode('|', env('LEANCLOUD_VERIFY_SMS_HEADER'));
        $data = [
            'mobilePhoneNumber'     =>  $request->phone,
            'verifyCode'            =>  $request->captcha,
        ];
        $ret = LeanCloudSMS::init($config)->verifySmsCode($data);
        $ret = json_decode($ret, true);
        if (isset($ret['error'])) {
            return response($ret['error'], 500);
        } else {
            return $ret;
        }
    }

    /**
     * Reponse the user info
     */
    public function getUser($id = null)
    {
        if ($id) {
            return User::findOrFail($id);
        } else {
            if (Auth::user()->check()) {
                return Auth::user()->user();
            } else {
                return response([], 404);
            }
        }
    }

    /**
     * Update avatar
     */
    public function postUpdateAvatar(Request $request)
    {
        $this->validate($request, [
            'avatar'       =>      'required',
        ]);

        $file = $request->file('avatar');
        $uploadPath = '/uploads/user/avatar/';
        $fileName   = str_random(6) . '_' . $file->getClientOriginalName();
        $file->move(public_path() . $uploadPath, $fileName);

        $User = Auth::user()->user();
        $User->avatar = $uploadPath . $fileName;
        $User->save();
        return $User;
    }
}
