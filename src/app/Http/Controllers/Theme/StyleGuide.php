<?php

namespace App\Http\Controllers\Theme;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StyleGuide extends Controller
{
    public function index() {
        return view('theme/pages/index');
    }

    public function page($page) {
        if ($page == '404') {
            abort('404');
        }
        return view('theme/pages/' . $page);
    }

}
