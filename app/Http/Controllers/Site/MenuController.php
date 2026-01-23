<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::active()->sorted()->get();
        
        // Если есть меню, перенаправляем на первый день
        if ($menus->count() > 0) {
            return redirect()->route('site.menus.show', $menus->first()->alias);
        }
        
        $pageType = 'Menu';
        return view('site.menus.index', compact('menus', 'pageType'));
    }

    public function show($alias): View
    {
        $menu = Menu::active()->where('alias', $alias)->firstOrFail();
        $allMenus = Menu::active()->sorted()->get();
        $pageType = 'Menu';
        
        return view('site.menus.show', compact('menu', 'allMenus', 'pageType'));
    }
}
