<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ConfigController extends Controller
{
    public function edit(): View
    {
        return view('admin.config.edit');
    }
}
