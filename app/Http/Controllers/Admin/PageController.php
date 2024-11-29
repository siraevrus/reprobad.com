<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        return view('admin.pages.index');
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function edit(): View
    {
        return view('admin.pages.edit');
    }
}
