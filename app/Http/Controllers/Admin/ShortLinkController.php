<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShortLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    public function index(): View
    {
        $resources = ShortLink::query()->latest()->paginate(env('PAGINATION_LIMIT', 20));

        return view('admin.short-links.index', compact('resources'));
    }

    public function create(): View
    {
        return view('admin.short-links.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'long_url' => 'required|url',
            'name' => 'nullable|string|max:255',
            'short_code' => 'nullable|string|max:20|regex:/^[a-zA-Z0-9]+$/|unique:short_links,short_code',
        ]);

        $shortCode = $request->filled('short_code')
            ? $request->short_code
            : $this->generateUniqueShortCode();

        ShortLink::create([
            'long_url' => $request->long_url,
            'short_code' => $shortCode,
            'name' => $request->name,
        ]);

        return redirect()->route('admin.short-links.index')
            ->with('message', 'Короткая ссылка создана');
    }

    public function show(ShortLink $shortLink): View
    {
        $recentClicks = $shortLink->clicks()->latest('clicked_at')->limit(100)->get();
        $clicksByDay = $shortLink->clicks()
            ->selectRaw('DATE(clicked_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        return view('admin.short-links.show', compact('shortLink', 'recentClicks', 'clicksByDay'));
    }

    public function edit(ShortLink $shortLink): View
    {
        return view('admin.short-links.edit', compact('shortLink'));
    }

    public function update(Request $request, ShortLink $shortLink): RedirectResponse
    {
        $request->validate([
            'long_url' => 'required|url',
            'name' => 'nullable|string|max:255',
            'short_code' => 'nullable|string|max:20|regex:/^[a-zA-Z0-9]+$/|unique:short_links,short_code,' . $shortLink->id,
        ]);

        $data = [
            'long_url' => $request->long_url,
            'name' => $request->name,
        ];

        if ($request->filled('short_code')) {
            $data['short_code'] = $request->short_code;
        }

        $shortLink->update($data);

        return redirect()->route('admin.short-links.index')
            ->with('message', 'Короткая ссылка обновлена');
    }

    public function destroy(ShortLink $shortLink): RedirectResponse
    {
        $shortLink->delete();

        return redirect()->route('admin.short-links.index')
            ->with('message', 'Короткая ссылка удалена');
    }

    private function generateUniqueShortCode(int $length = 6): string
    {
        do {
            $code = Str::random($length);
        } while (ShortLink::where('short_code', $code)->exists());

        return $code;
    }
}
