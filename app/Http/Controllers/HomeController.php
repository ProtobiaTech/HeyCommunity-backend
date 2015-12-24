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
            'domain'            =>      'min:3|unique:tenants',
            'sub_domain'        =>      'required|min:3|unique:tenants',
            'email'             =>      'required|email|unique:tenants',
            'phone'             =>      'required|min:10000000000|integer|unique:tenants',
            'password'          =>      'required|min:6',
        ]);

        $Tenant = new Tenant();

        $Tenant->site_name      =   $request->site_name;
        $Tenant->sub_domain     =   $request->sub_domain . '.hey-community.online';
        if ($request->domain) {
            $Tenant->domain     =   $request->domain;
        }
        $Tenant->email          =   $request->email;
        $Tenant->phone          =   $request->phone;
        $Tenant->password       =   Hash::make($request->password);

        if ($Tenant->save()) {
            Auth::tenant()->login($Tenant);
            return redirect()->back();
        } else {
            $request->flash();
            return redirect()->back();
        }
    }
}
