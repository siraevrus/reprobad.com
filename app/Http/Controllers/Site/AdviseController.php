<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Advise;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AdviseController extends Controller
{
    public function index(): View
    {
        $resources = Advise::where('active', 1)->orderBy('sort', 'asc')->get();
        $categories = Advise::where('active', 1)->distinct()->pluck('category')->filter();
        
        $resource = null;
        $pageType = 'Advise';
        
        return view('site.advises.index', compact('resources', 'categories', 'resource', 'pageType'));
    }

    public function show($alias): View
    {
        $resource = Advise::where('alias', $alias)->where('active', 1)->firstOrFail();
        $events = Event::where('active', 1)->take(3)->get();
        
        $pageType = 'Advise';
        
        return view('site.advises.show', compact('resource', 'events', 'pageType'));
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

        return response()->json(['success' => true]);
    }
}
