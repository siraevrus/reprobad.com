<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function index(): View|JsonResponse
    {
        $resources = Feedback::query()->orderBy('created_at', 'DESC')->paginate(env('PAGINATION_LIMIT', 20));

        if(request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.feedbacks.index', compact('resources'));
    }

    public function show(Request $request, $id): View|JsonResponse
    {
        $resource = Feedback::query()->findOrFail($id);
        
        if(request()->ajax()) {
            $request->headers->set('Accept', 'application/json');
            return response()->json($resource);
        }
        
        return view('admin.feedbacks.show', compact('resource'));
    }

    public function destroy($id): RedirectResponse
    {
        $resource = Feedback::query()->findOrFail($id);
        $resource->delete();
        return back();
    }
}

