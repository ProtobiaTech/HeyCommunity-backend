<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
     *
     */
    public function getAboutUs()
    {
        return view('home.about-us');
    }


    /**
     *
     */
    public function getOpenResource()
    {
        return view('home.open-resource');
    }
}
