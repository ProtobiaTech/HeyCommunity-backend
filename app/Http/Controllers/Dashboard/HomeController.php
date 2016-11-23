<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     *
     */
    public function getIndex()
    {
        return view('dashboard.home.index');
    }
}
