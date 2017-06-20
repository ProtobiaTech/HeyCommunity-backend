<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use GuzzleHttp\Exception\RequestException;

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
        $this->middleware('guest', ['only' => ['postSignUp', 'postLogIn', 'postLogInWithWechat']]);
    }

    /**
     *
     */
    public function getLogInByTest()
    {
        $user = User::first();

        if ($user) {
            Auth::user()->login($user);
        }

        return $user;
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
     * Log in with wechat
     *
     * @param \Illuminate\Http\Request $request
     * @return object|string User model or failure info
     */
    public function postLogInWithWechat(Request $request)
    {
        if (env('WECHATOP_APP_ENABLE')) {
            $this->validate($request, [
                'code'      =>  'required',
            ]);

            $options = [
                'debug'     => true,
                'app_id'    => env('WECHATOP_APP_APPID'),
                'secret'    => env('WECHATOP_APP_SECRET'),
            ];

            $app = new Application($options);
            $user = $app->oauth->setRequest($request)->user();

            if ($user) {
                $unionId = $user->getOriginal()['unionid'];
                $User = User::where('wx_union_id', $unionId)->first();

                if (!$User) {
                    $User = new User;
                    $User->wx_union_id  =   $unionId;
                    $User->nickname     =   $user->getNickname();
                    $User->avatar       =   $user->getAvatar();

                    $number = random_int(0, 3);
                    if ($number === 0) {
                        $User->bio          =   'My name is ' . $user->getNickname();
                    } else if ($number === 1) {
                        $User->bio          =   'I\'m ' . $user->getNickname();
                    } else if ($number === 2) {
                        $User->bio          =   $user->getNickname() . ' is me';
                    } else if ($number === 3) {
                        $User->bio          =   'I love there';
                    }

                    $User->save();
                }

                Auth::user()->login($User);
                return $User;
            } else {
                return response('wechat login fail', 500);
            }
        } else {
            return response('Do not support WeChat login', 403);
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
            'code'      =>  'required|integer',
            'password'  =>  'required',
        ]);

        if (session('signUpVerificationExpire') > time() &&
            session('signUpVerificationCode') == $request->code &&
            session('signUpVerificationPhone') == $request->phone
        ) {
            $User = new User;
            $User->nickname     =   $request->nickname;
            $User->avatar       =   'assets/images/userAvatar-default.png';
            $User->phone        =   $request->phone;
            $User->password     =   Hash::make($request->password);

            if ($User->save()) {
                session()->remove('signUpVerificationExpire');
                session()->remove('signUpVerificationCode');
                session()->remove('signUpVerificationPhone');

                Auth::user()->login($User);
                return $User;
            } else {
                return response($User, 500);
            }
        } else {
            return response('The Verification Code Invalid', 403);
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

        $uploadPath = 'uploads/avatars/';
        $fileName = date('Ymd-His_') . str_random(6) . '_' . $file->getClientOriginalName();
        $imgPath = $uploadPath . $fileName;

        $image = Image::make($file->getRealPath());
        $imageWidth = $image->width();
        $imageHeight = $image->height();
        $resize = $imageWidth < $imageHeight ? $imageWidth : $imageHeight;
        $contents = $image->crop($resize, $resize, 0, 0)->stream();

        if (\Storage::put($imgPath, $contents)) {
            $User = Auth::user()->user();
            $User->avatar = $imgPath;
            $User->save();

            return $User;
        } else {
            return abort('Avatar update failed');
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

    /**
     *
     */
    public function anyGetVerificationCode(Request $request)
    {
        $this->validate($request, [
            'phone'     =>  'required',
        ]);

        $tempId = env('JIGUANG_SMS_TEMPID');
        $code = random_int(111111, 999999);
        session(['signUpVerificationPhone' => $request->phone]);
        session(['signUpVerificationCode' => $code]);
        session(['signUpVerificationExpire' => time() + 600]);
        $phone = $request->phone;

        $user = (env('JIGUANG_APPKEY'));
        $password = (env('JIGUANG_SECRET'));

        $body = json_encode([
            'mobile'    =>      $phone,
            'temp_id'   =>      $tempId,
            'temp_para' =>      ['code' => $code],
        ]);


        $client = new \GuzzleHttp\Client();
        try {
            $client->request('POST', 'https://api.sms.jpush.cn/v1/messages', [
                'auth' => [$user, $password],
                'headers' => [
                    'Content-Type'      =>      'application/json',
                ],
                'body' => $body,
            ]);
        } catch (RequestException $e) {
            return response('get verification code failed', 500);
        }

        return ['get verification code successful'];
    }
}
