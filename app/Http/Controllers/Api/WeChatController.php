<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;
use EasyWeChat\Foundation\Application;

use Auth;
use App\User;
use App\Tenant;

class WeChatController extends Controller
{
    /**
     *
     *
     */
    public function getOAuth(Request $request)
    {
        if (Auth::guest()) {
            $options = [
                'debug'     => true,
                'app_id'    => env('WECHAT_APPID'),
                'secret'    => env('WECHAT_SECRET'),
            ];

            $domain = 'http://' . $request->header()['host'][0];
            $redirect = 'http://cloud.hey-community.com/api/wechat/get-wechat-user?domain=' . $domain;

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
    public function _getOAuth(Request $request)
    {
        $referer = $request->header()['referer'][0];
        preg_match('/^http[s]?:\/\/[^\/]*\//', $referer, $tenantDomain);


        $APPID = 'wxc0913740d9e16659';
        $REDIRECT_URI = urlencode(redirect()->to('api/wechat/get-wechat-user')->getTargetUrl());
        $SCOPE = 'snsapi_userinfo';
        $STATE = urlencode($tenantDomain[0]);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$APPID}&redirect_uri={$REDIRECT_URI}&response_type=code&scope={$SCOPE}&state={$STATE}#wechat_redirect";
        return redirect()->to($url);
    }

    /**
     *
     */
    public function getGetWechatUser(Request $request)
    {
        $options = [
            'debug'     => true,
            'app_id'    => env('WECHAT_APPID'),
            'secret'    => env('WECHAT_SECRET'),
        ];

        $app = new Application($options);
        $user = $app->oauth->user();

        if ($user) {
            $User = User::where('wx_open_id', $openId)->first();
            if (!$User) {
                $Tenant = Tenant::where(['domain' => $request->domain])->orWhere(['sub_domain' => $request->domain])->first();

                if ($Tenant) {
                    $User = new User;
                    $User->wx_open_id   =   $user->getId();
                    $User->nickname     =   $user->getNickname();
                    $User->avatar       =   $user->getAvatar();

                    $number = random_int(0, 3);
                    if ($number === 0) {
                        $User->bio          =   'My name is ' . $user->getNickname;
                    } else if ($number === 1) {
                        $User->bio          =   'I\'m ' . $user->getNickname;
                    } else if ($number === 2) {
                        $User->bio          =   $user->getNickname . ' is me';
                    } else if ($number === 3) {
                        $User->bio          =   'I love there';
                    }

                    $User->save();
                }
            }

            $redirect = $request->domain . '/api/wechat/login?wx_open_id=' . $user->getId();
            return redirect($redirect);
        } else {
            abort(500, 'wechat login fail');
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
            Auth::login($User);
        }

        return redirect()->to('/?noWeChatOAuth=true');
    }

    /**
     *
     */
    public function getSendMessage()
    {
        $appId = 'wxc0913740d9e16659';
        $secret = 'bb1dee0ae8135120b187aedd5c48f9ca';

        $getAccessTokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appId}&secret={$secret}";
        $accessTokenRets = json_decode(file_get_contents($getAccessTokenUrl), true);

        if (isset($accessTokenRets['access_token'])) {
            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$accessTokenRets['access_token']}";

            $client = new Client();
            $res = $client->request('POST', $url, [
                'form_params'   =>  [
                    'touser'        =>  'o3qIdv5qCjl25ssmS2LA1u4MKuY4',
                    'template_id'   =>  '2tyXWaj3fRdWxpYtUDEbKtSpEoVWSgKe_QSclp986jI',
                    'url'           =>  'http://demo.hey-community.com',
                    'data'  =>  [
                        'first'     =>  [
                            'value'     =>      'Rod: 好漂亮的手表，是 Apple Watch 吗？',
                            'color'     =>      '#173177',
                        ],
                        'subject'     =>  [
                            'value'     =>      'Rod 对你的动态进行了评论',
                            'color'     =>      '#333',
                        ],
                        'sender'     =>  [
                            'value'     =>      'Rod',
                            'color'     =>      '#333',
                        ],
                        'remark'     =>  [
                            'value'     =>      '这是来自XXX社区的消息，点击了解详情',
                            'color'     =>      '#333',
                        ],
                    ]
                ]
            ]);

            $result= $res->getBody()->getContents();
            dd($res, $result);
        }
    }

    public function getSendWechatMessage()
    {
        $options = [
            'debug'     => true,
            'app_id'    => env('WECHAT_APPID'),
            'secret'    => env('WECHAT_SECRET'),
        ];

        $app = new Application($options);
        $notice = $app->notice;

        $userId = 'o3qIdv5qCjl25ssmS2LA1u4MKuY4';
        $templateId = '2tyXWaj3fRdWxpYtUDEbKtSpEoVWSgKe_QSclp986jI';
        $url = 'http://overtrue.me';
        $color = '#FF0000';

        $data = array(
                 "first"        =>  "Rodv2: 快 TM 加班加点写代码，早日发布 HeyCommunity !!!",
                 "subject"      =>  "Rodv2 评论了你的 Timeline",
                 "sender"       =>  "HeyCommunity V2",
                 "remark"       =>  "这是来自XXX社区的消息，点击了解详情",
                );
        $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        var_dump($result);

    }
}
