<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use App\Models\ShortLinkClick;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class ShortLinkRedirectController extends Controller
{
    public function redirect(Request $request, string $code): RedirectResponse
    {
        $shortLink = ShortLink::where('short_code', $code)->first();

        if (!$shortLink) {
            abort(404);
        }

        ShortLinkClick::create([
            'short_link_id' => $shortLink->id,
            'clicked_at' => now(),
            'referer' => $request->header('referer'),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
        ]);

        $shortLink->increment('clicks_count');

        return redirect()->away($shortLink->long_url, 302);
    }
}
