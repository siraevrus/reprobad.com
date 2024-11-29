<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('admin.articles.index');
    }

    public function create(): View
    {
        return view('admin.articles.create');
    }

    public function edit(): View
    {
        return view('admin.articles.edit');
    }
}
