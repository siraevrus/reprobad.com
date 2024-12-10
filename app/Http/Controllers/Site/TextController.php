<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Text;
use Illuminate\View\View;

class TextController extends Controller
{
    public function show($alias): View
    {
        $resource = Text::active()->where('alias', $alias)->firstOrFail();
        return view('site.text.show', compact('resource'));
    }
}
