<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        $seoData = Seo::all();
        
        return view('admin.seo.index', compact('seoData'));
    }

    public function create()
    {
        $pageTypes = [
            'Home' => 'Главная',
            'Article' => 'Статьи',
            'Page' => 'Страницы',
            'Product' => 'Продукты',
            'Event' => 'События',
            'Advise' => 'Советы',
            'Complex' => 'Комплексы',
        ];

        return view('admin.seo.create', compact('pageTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_type' => 'required|string|unique:seo,page_type',
            'title' => 'nullable|string|max:60',
            'description' => 'nullable|string|max:160',
            'keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:60',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|string',
        ]);

        Seo::create($request->only(['page_type', 'title', 'description', 'keywords', 'og_title', 'og_description', 'og_image']));

        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO данные успешно сохранены');
    }

    public function edit($id)
    {
        $seo = Seo::findOrFail($id);
        $pageTypes = [
            'Home' => 'Главная',
            'Article' => 'Статьи',
            'Page' => 'Страницы',
            'Product' => 'Продукты',
            'Event' => 'События',
            'Advise' => 'Советы',
            'Complex' => 'Комплексы',
        ];

        return view('admin.seo.edit', compact('seo', 'pageTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:60',
            'description' => 'nullable|string|max:160',
            'keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:60',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|string',
        ]);

        $seo = Seo::findOrFail($id);
        $seo->update($request->only(['title', 'description', 'keywords', 'og_title', 'og_description', 'og_image']));

        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO данные успешно обновлены');
    }

    public function destroy($id)
    {
        $seo = Seo::findOrFail($id);
        $seo->delete();

        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO данные успешно удалены');
    }
} 