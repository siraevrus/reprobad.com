<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;

class IndexController extends Controller
{
    public function index()
    {
        $resource = [
            'home' => 1,
            'title' => 'Главная'
        ];
        $products = Product::all();
        return view('site.index', compact('resource', 'products'));
    }
}
