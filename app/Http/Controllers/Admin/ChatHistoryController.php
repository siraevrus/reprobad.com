<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = ChatHistory::query();

        // Фильтр по источнику
        $source = $request->get('source');
        if ($source) {
            $query->where('source', $source);
        }

        $resources = $query->orderBy('created_at', 'desc')
            ->paginate(env('PAGINATION_LIMIT', 20))
            ->appends($request->query());

        // Получаем список уникальных источников для фильтра
        $sources = ChatHistory::query()
            ->distinct()
            ->pluck('source')
            ->filter()
            ->sort()
            ->values();

        return view('admin.chat-history.index', compact('resources', 'sources', 'source'));
    }

    public function show($id): View
    {
        $resource = ChatHistory::query()->findOrFail($id);
        return view('admin.chat-history.show', compact('resource'));
    }

    public function destroy($id): RedirectResponse
    {
        $resource = ChatHistory::query()->findOrFail($id);
        $resource->delete();
        session()->flash('message', 'Запись истории удалена');
        return back();
    }
}

