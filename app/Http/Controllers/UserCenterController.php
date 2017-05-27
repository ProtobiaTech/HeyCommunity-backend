<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return redirect()->to('/ucenter/notice');
    }

    /**
     * Notice page
     */
    public function getNotice()
    {
        return view('ucenter.notice');
    }

    /**
     * Timeline page
     */
    public function getTimeline()
    {
        return view('ucenter.timeline');
    }

    /**
     * Topic page
     */
    public function getTopic()
    {
        return view('ucenter.topic');
    }

}
