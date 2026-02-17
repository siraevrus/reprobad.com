<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

        // Фильтр по User ID
        $userId = $request->get('user_id');
        if ($userId) {
            $query->where('user_id', $userId);
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

        return view('admin.chat-history.index', compact('resources', 'sources', 'source', 'userId'));
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

    public function export(Request $request): Response
    {
        $query = ChatHistory::query();

        // Применяем те же фильтры, что и в index
        $source = $request->get('source');
        if ($source) {
            $query->where('source', $source);
        }

        $userId = $request->get('user_id');
        if ($userId) {
            $query->where('user_id', $userId);
        }

        // Получаем все записи, упорядоченные по user_id, затем по дате
        $records = $query->orderBy('user_id')
            ->orderBy('created_at')
            ->get();

        // Группируем по user_id
        $grouped = $records->groupBy('user_id');

        // Формируем содержимое файла
        $content = "ОТЧЕТ ОБ ОБЩЕНИИ С БОТОМ\n";
        $content .= "Дата формирования: " . now()->format('d.m.Y H:i:s') . "\n";
        $content .= "Всего записей: " . $records->count() . "\n";
        $content .= "Уникальных пользователей: " . $grouped->count() . "\n";
        
        if ($source) {
            $content .= "Источник: " . $source . "\n";
        }
        if ($userId) {
            $content .= "User ID: " . $userId . "\n";
        }
        
        $content .= str_repeat("=", 80) . "\n\n";

        foreach ($grouped as $userId => $userRecords) {
            $content .= "USER ID: {$userId}\n";
            $content .= str_repeat("-", 80) . "\n";
            $content .= "Количество сообщений: " . $userRecords->count() . "\n";
            $content .= "Источник: " . ($userRecords->first()->source ?? '-') . "\n";
            if ($userRecords->first()->chat_id) {
                $content .= "Chat ID: " . $userRecords->first()->chat_id . "\n";
            }
            $content .= "\n";

            foreach ($userRecords as $index => $record) {
                $content .= "Запись #" . ($index + 1) . "\n";
                $content .= "Дата: " . $record->created_at->format('d.m.Y H:i:s') . "\n";
                $content .= "Запрос пользователя:\n";
                $content .= $record->user_message . "\n\n";
                $content .= "Ответ бота:\n";
                $content .= $record->bot_response . "\n";
                $content .= str_repeat("-", 80) . "\n\n";
            }

            $content .= "\n";
        }

        // Формируем имя файла
        $filename = 'chat_history_export_' . now()->format('Y-m-d_His') . '.txt';

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}

