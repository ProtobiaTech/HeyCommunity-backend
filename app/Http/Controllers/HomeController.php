<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tenant;
use Auth, Hash;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     */
    public function storeTenant(Request $request)
    {
        $this->validate($request, [
            'site_name'         =>      'required|min:3|unique:tenants',
            'domain'            =>      'required|min:3|unique:tenants',
            'email'             =>      'required|email|unique:tenants',
            'phone'             =>      'required|integer|unique:tenants',
            'password'          =>      'required|min:6',
        ]);

        $tenantModel = new Tenant($request->all());
        $tenantModel->password = Hash::make($request->password);
        if ($tenantModel->save()) {
            Auth::tenant()->login($tenantModel);
            return redirect()->back();
        } else {
            $request->flash();
            return redirect()->back();
        }
    }
}
