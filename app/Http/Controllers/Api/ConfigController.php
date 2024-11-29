<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ConfigController extends Controller
{
    public function edit()
    {
        return response()->json(config());
    }
}
