<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\DefaultMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        Mail::to(env('MAIL_TO'))->send(new DefaultMail($validated));
        session()->flash('message', 'Вы были успешно подписаны на рассылку');
        return back();
    }

    public function feedback(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string',
            'agree' => 'accepted|required'
        ]);

        Mail::to(env('MAIL_TO'))->send(new DefaultMail($validated));
        session()->flash('message', 'Ваше сообщение успешно отправлено');
        return back();
    }
}
