<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    /**
     *
     */
    public function getIndex()
    {
        $assign['users'] = User::orderBy('id', 'desc')->paginate();
        return view('dashboard.user.index', $assign);
    }
}
