<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Debugbar;
use Auth;
use App\User;
use App\Tenant;

class WeChatController extends Controller
{
    /**
     *
     */
    public function getCheckSignature(Request $request)
    {
        Debugbar::disable();
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
        Debugbar::enable();
    }

    /**
     *
     */
    public function getOAuth(Request $request)
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
        $appId = 'wxc0913740d9e16659';
        $secret = 'bb1dee0ae8135120b187aedd5c48f9ca';
        $code  = $request->code;
        $getAccessTokenUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appId}&secret={$secret}&code={$code}&grant_type=authorization_code";

        $accessTokenRets = json_decode(file_get_contents($getAccessTokenUrl), true);

        if (isset($accessTokenRets['access_token'])) {
            $accessToken = $accessTokenRets['access_token'];
            $openId = $accessTokenRets['openid'];
            $getUserInfoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token={$accessToken}&openid={$openId}&lang=zh_CN";
            $userInfo = json_decode(file_get_contents($getUserInfoUrl), true);

            $User = User::where('wx_open_id', $openId)->first();
            if (!$User) {
                preg_match('/^http[s]?:\/\/([^\/]*)\//', urldecode($request->state), $tenantDomain);
                $domain = $tenantDomain[1];
                $Tenant = Tenant::where(['domain' => $domain])->orWhere(['sub_domain' => $domain])->first();

                $User = new User;
                $User->wx_open_id   =   $openId;
                $User->tenant_id    =   $Tenant->id;
                $User->nickname     =   $userInfo['nickname'];
                $User->avatar       =   $userInfo['headimgurl'];
                $User->save();
            }

            $loginUrl = urldecode($request->state) . 'api/wechat/login?token=' . $openId;
            return redirect()->to($loginUrl);
        } else {
            return $accessTokenRets;
        }
    }

    /**
     *
     */
    public function getLogin(Request $request)
    {
        $this->validate($request, [
            'token'     =>  'required',
        ]);

        $User = User::where('wx_open_id', $request->token)->first();
        Auth::login($User);

        return redirect()->to('/?noWeChatOAuth=true');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
