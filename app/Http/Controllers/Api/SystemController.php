<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\System;

class SystemController extends Controller
{
    /**
     *
     */
    public function getInfo()
    {
        return System::findOrFail(1);
    }
}
