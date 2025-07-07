<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use App\Models\Article;
use App\Models\Page;
use App\Models\Product;
use App\Models\Event;
use App\Models\Advise;
use App\Models\Complex;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        $seoData = Seo::with('page')->get();
        
        return view('admin.seo.index', compact('seoData'));
    }

    public function create()
    {
        $pageTypes = [
            'Article' => 'Статьи',
            'Page' => 'Страницы',
            'Product' => 'Продукты',
            'Event' => 'События',
            'Advise' => 'Советы',
            'Complex' => 'Комплексы',
        ];

        return view('admin.seo.create', compact('pageTypes'));
    }

    public function getPages(Request $request)
    {
        $pageType = $request->get('page_type');
        
        switch ($pageType) {
            case 'Article':
                $pages = Article::select('id', 'title')->get();
                break;
            case 'Page':
                $pages = Page::select('id', 'title')->get();
                break;
            case 'Product':
                $pages = Product::select('id', 'title')->get();
                break;
            case 'Event':
                $pages = Event::select('id', 'title')->get();
                break;
            case 'Advise':
                $pages = Advise::select('id', 'title')->get();
                break;
            case 'Complex':
                $pages = Complex::select('id', 'title')->get();
                break;
            default:
                $pages = collect();
        }

        return response()->json($pages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_type' => 'required|string',
            'page_id' => 'required|integer',
            'title' => 'nullable|string|max:60',
            'description' => 'nullable|string|max:160',
            'keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:60',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|string',
        ]);

        Seo::updateOrCreate(
            ['page_type' => $request->page_type, 'page_id' => $request->page_id],
            $request->only(['title', 'description', 'keywords', 'og_title', 'og_description', 'og_image'])
        );

        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO данные успешно сохранены');
    }

    public function edit($id)
    {
        $seo = Seo::findOrFail($id);
        $pageTypes = [
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