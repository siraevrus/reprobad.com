<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $resource = [
            'home' => 1,
            'title' => 'Главная'
        ];
        return view('site.index', compact('resource'));
    }
}
