<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\User;

class SettingController extends Controller
{
    /**
     *
     */
    public function getIndex()
    {
        return redirect('/dashboard/setting/tenant-info');
    }

    /**
     *
     */
    public function getTenantInfo()
    {
        $assign['tenant'] = Auth::user();
        return view('dashboard.setting.tenant-info', $assign);
    }

    /**
     *
     */
    public function getEditTenantInfo()
    {
        $assign['tenant'] = Auth::user();
        return view('dashboard.setting.edit-tenant-info', $assign);
    }

    /**
     *
     */
    public function postUpdateTenantInfo(Request $request)
    {
        $this->validate($request, [
            'site_name'         =>      'required|min:2',
        ]);

        $Tenant = Auth::user();
        $Tenant->site_name = $request->site_name;

        if ($Tenant->save()) {
            return redirect('/dashboard/setting/tenant-info');
        } else {
            return back()->withInput();
        }
    }

    /**
     *
     */
    public function getWechatPa()
    {
        $assign['tenant'] = Auth::user();
        return view('dashboard.setting.wechat-pa', $assign);
    }

    /**
     *
     */
    public function getEditWechatPa()
    {
        $assign['tenant'] = Auth::user();
        return view('dashboard.setting.edit-wechat-pa', $assign);
    }

    /**
     *
     */
    public function postUpdateWechatPa(Request $request)
    {
        $this->validate($request, [
            'enable_wechat_pa'  =>  'required',
            'wx_app_id'         =>  'required_if:enable_wechat_pa,1|min:15',
            'wx_app_secret'     =>  'required_if:enable_wechat_pa,1|min:20',
            'wx_temp_notice_id' =>  'required_if:enable_wechat_pa,1|min:35',
            'wx_verify_file'    =>  'max:1'
        ]);

        $Tenant = Auth::user();
        $Tenant->enable_wechat_pa = $request->enable_wechat_pa;
        $Tenant->info->wx_app_id = $request->wx_app_id;
        $Tenant->info->wx_app_secret = $request->wx_app_secret;
        $Tenant->info->wx_temp_notice_id = $request->wx_temp_notice_id;

        // save verify file
        if ($request->hasFile('wx_verify_file')) {
            $path = env('WECHAT_PA_VERIFY_FILE_PATH', '/var/www/');
            $file= $request->file('wx_verify_file');
            $file->move($path, $file->getClientOriginalName());
        }

        $Tenant->save();
        $Tenant->info->save();
        return redirect('/dashboard/setting/wechat-pa');
    }

    /**
     *
     */
    public function getWechatNotice()
    {
        $assign['tenant'] = Auth::user();
        return view('dashboard.setting.wechat-notice', $assign);
    }

    /**
     *
     */
    public function getEditWechatNotice()
    {
        $assign['tenant'] = Auth::user();
        return view('dashboard.setting.edit-wechat-pa', $assign);
    }

    /**
     *
     */
    public function getAdministrator()
    {
        $assign['administrators'] = User::where(['is_admin' => 1])->get();
        return view('dashboard.setting.administrator', $assign);
    }

    /**
     *
     */
    public function getAddAdministrator()
    {
        return view('dashboard.setting.add-administrator');
    }

    /**
     *
     */
    public function getSearchAdministrator(Request $request)
    {
        $this->validate($request, [
            'search_key'        =>      'min:1',
        ]);

        $assign = [];
        if ($request->has('search_key')) {
            $request->flash();
            $nicknameStr = '%' . $request->search_key . '%';
            $assign['users'] = User::where(['id' => $request->search_key])->orWhere(['phone' => $request->search_key])->orWhere('nickname', 'like', $nicknameStr)->get();
        }
        return view('dashboard.setting.search-administrator', $assign);
    }

    /**
     *
     */
    public function postAddAdministratorHandler(Request $request)
    {
        $this->validate($request, [
            'id'                =>      'required|min:1',
        ]);

        $User = User::findOrFail($request->id);
        $User->is_admin = true;
        $User->save();
        return redirect()->to('/dashboard/setting/administrator');
    }

    /**
     *
     */
    public function postDestroyAdministratorHandler(Request $request)
    {
        $this->validate($request, [
            'id'                =>      'required|min:1',
        ]);

        $User = User::findOrFail($request->id);
        $User->is_admin = false;
        $User->save();
        return redirect()->to('/dashboard/setting/administrator');
    }
}
