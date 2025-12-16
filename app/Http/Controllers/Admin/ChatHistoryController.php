<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ChatHistoryController extends Controller
{
    public function index(): View
    {
        $resources = ChatHistory::query()
            ->orderBy('created_at', 'desc')
            ->paginate(env('PAGINATION_LIMIT', 20));

        return view('admin.chat-history.index', compact('resources'));
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

