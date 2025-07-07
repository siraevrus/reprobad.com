<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $resources = Article::where('active', 1)->orderBy('created_at', 'desc')->get();
        $categories = Article::where('active', 1)->distinct()->pluck('category')->filter();
        
        $resource = null;
        $pageType = 'Article';
        
        return view('site.articles.index', compact('resources', 'categories', 'resource', 'pageType'));
    }

    public function show($alias): View
    {
        $resource = Article::where('alias', $alias)->where('active', 1)->firstOrFail();
        $other = Article::where('active', 1)->where('id', '!=', $resource->id)->take(3)->get();
        $events = Event::where('active', 1)->take(3)->get();
        
        $pageType = 'Article';
        
        return view('site.articles.show', compact('resource', 'other', 'events', 'pageType'));
    }

    public function subscribe(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return response()->json([
            'success' => true
        ]);
    }
}
