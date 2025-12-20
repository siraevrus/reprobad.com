<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfigController extends Controller
{
    public function edit(): View
    {
        $config = [];

        foreach(Config::all() as $item) {
            $config[$item->key] = $item->value;
        }

        $config = json_decode(json_encode($config));

        return view('admin.config.edit', compact('config'));
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'address' => 'string|required',
            'phone' => 'string|required',
            'phone2' => 'string|nullable',
            'email' => 'string|nullable',
            'email2' => 'string|nullable',
            'telegram' => 'string|nullable',
            'rutube' => 'string|nullable',
            'ok' => 'string|nullable',
            'vk' => 'string|nullable',
            'dzen' => 'string|nullable',
            'system_prompt' => 'string|nullable',
            'bot_welcome_message' => 'string|nullable',
            'ai_model' => 'string|nullable',
            'rag_version' => 'string|nullable',
        ]);

        foreach($validated as $key => $value) {
            if(!$value) continue;
            if($config = Config::query()->where('key', $key)->first()) {
                $config->value = $value;
                $config->save();
            }
            else {
                Config::query()->create([
                    'key' => $key,
                    'value' => $value
                ]);
            }
        }

        return back();
    }
}
