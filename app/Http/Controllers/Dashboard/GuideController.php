<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GuideController extends Controller
{
    /**
     *
     */
    public function getIndex()
    {
        return view('dashboard.guide.index');
    }
}
