<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.user.index', $assign);
    }
}
