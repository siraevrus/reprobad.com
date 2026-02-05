<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        $resources = TestResult::query()
            ->orderBy('created_at', 'desc')
            ->paginate(env('PAGINATION_LIMIT', 20));

        if(request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.test-results.index', compact('resources'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View|JsonResponse
    {
        $resource = TestResult::query()->findOrFail($id);
        
        if(request()->ajax()) {
            return response()->json($resource);
        }

        return view('admin.test-results.show', compact('resource'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $resource = TestResult::query()->findOrFail($id);
        $resource->delete();
        
        return redirect()->route('admin.test-results.index')
            ->with('message', 'Результат теста удален');
    }
}
