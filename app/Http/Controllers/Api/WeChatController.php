<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;
use EasyWeChat\Foundation\Application;

use Auth;
use App\User;

class WeChatController extends Controller
{
    /**
     *
     *
     */
    public function getOAuth(Request $request)
    {
        if (Auth::user()->guest()) {
            $options = [
                'debug'     => true,
                'app_id'    => env('WECHATPA_APPID'),
                'secret'    => env('WECHATPA_SECRET'),
            ];

            $domain = $request->header()['host'][0];
            $redirect = 'http://' . $domain . '/api/wechat/get-wechat-user?domain=' . $domain;

            $app = new Application($options);
            $response = $app->oauth->scopes(['snsapi_userinfo'])
                            ->setRequest($request)
                            ->redirect($redirect);

            return $response;
        } else {
            return back();
        }

    }

    /**
     *
     */
    public function getCheckSignature(Request $request)
    {
        $signature  =   $request->signature;
        $timestamp  =   $request->timestamp;
        $nonce      =   $request->nonce;

        $token = 'protobiatechanddev4livingteam';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if($tmpStr == $signature){
            return response($request->echostr, 200);
        }else{
            return response('false', 400);
        }
    }

    /**
     *
     */
    public function getGetWechatUser(Request $request)
    {
        $options = [
            'debug'     => true,
            'app_id'    => env('WECHATPA_APPID'),
            'secret'    => env('WECHATPA_SECRET'),
        ];

        $app = new Application($options);
        $user = $app->oauth->setRequest($request)->user();

        if ($user) {
            $User = User::where('wx_open_id', $user->getId())->first();
            if (!$User) {
                $User = new User;
                $User->wx_open_id   =   $user->getId();
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

            $redirect = 'http://' . $request->domain . '/api/wechat/login?wx_open_id=' . $user->getId();
            return redirect($redirect);
        } else {
            return abort(500, 'wechat login fail');
        }
    }

    /**
     *
     */
    public function getLogin(Request $request)
    {
        $this->validate($request, [
            'wx_open_id'     =>  'required',
        ]);

        $User = User::where('wx_open_id', $request->wx_open_id)->first();
        if ($User) {
            Auth::user()->login($User);
        }

        return redirect()->to('/?noWeChatOAuth=true');
    }
}
