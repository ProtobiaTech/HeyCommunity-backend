<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Keyword;

class KeywordController extends Controller
{
    /**
     *
     */
    public function getIndex()
    {
        $keywords = Keyword::orderBy('id', 'desc')->paginate();
        return view('dashboard.keyword.index', compact('keywords'));
    }
}