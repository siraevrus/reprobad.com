<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\AliasFromTitle;
use Illuminate\Http\Request;

trait FillsAliasFromTitle
{
    protected function fillAliasFromTitle(Request $request): void
    {
        $alias = trim((string) $request->input('alias', ''));
        if ($alias !== '') {
            return;
        }

        $generated = AliasFromTitle::make((string) $request->input('title', ''));
        if ($generated !== '') {
            $request->merge(['alias' => $generated]);
        }
    }
}
