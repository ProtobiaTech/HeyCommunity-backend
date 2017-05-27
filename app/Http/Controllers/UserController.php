<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\User;

class UserController extends Controller
{
    /**
     * Profile page
     */
    public function getProfile($id)
    {
        $user = User::findOrFail($id);
        return view('user.profile', compact('user'));
    }
}
