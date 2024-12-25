<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\DefaultMail;
use App\Models\Subscribe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Subscribe::query()->create([
            'email' => $request->get('email'),
        ]);

        Mail::to(env('MAIL_TO'))->send(new DefaultMail($validator->validated()));

        return response()->json([
            'success' => true,
            'message' => 'Успешно отправлено'
        ]);
    }

    public function feedback(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string',
            'agree' => 'accepted|required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Mail::to(env('MAIL_TO'))->send(new DefaultMail($validator->validated()));

        return response()->json([
            'success' => true,
            'message' => 'Успешно отправлено'
        ]);
    }
}
