<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentSeoAiService;
use App\Services\ImageAltAiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function generate(Request $request, ContentSeoAiService $contentSeoAiService, ImageAltAiService $imageAltAiService): JsonResponse
    {
        $request->validate([
            'type'    => 'required|in:keywords,description,image_alt',
            'content' => 'required_unless:type,image_alt|string|max:50000',
            'title'   => 'nullable|string|max:500',
            'image'   => 'required_if:type,image_alt|nullable|string|max:15000000',
        ]);

        if ($request->input('type') === 'image_alt') {
            $result = $imageAltAiService->generate(
                $request->input('image', ''),
                $request->input('title', ''),
                $request->input('content', ''),
            );

            $status = $result['success'] ? 200 : ($result['error'] === 'Не удалось прочитать изображение' ? 400 : 500);

            return response()->json($result, $status);
        }

        $type    = $request->input('type');
        $content = strip_tags($request->input('content'));
        $title   = strip_tags($request->input('title', ''));

        $result = $type === 'keywords'
            ? $contentSeoAiService->generateKeywords($content)
            : $contentSeoAiService->generateDescription($content, $title);

        $status = ($result['success'] ?? false) ? 200 : 500;

        return response()->json($result, $status);
    }
}
