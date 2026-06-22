<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait HandlesAdminSaveErrors
{
    protected function validationAttributes(): array
    {
        return [
            'title' => 'заголовок',
            'content' => 'содержание',
            'alias' => 'алиас',
            'description' => 'короткий текст',
            'image' => 'фото',
            'image_alt' => 'alt для фото',
            'icon' => 'иконка',
            'category' => 'категория',
            'time' => 'время на чтение',
            'active' => 'активно',
            'seo_description' => 'SEO description',
            'seo_keywords' => 'meta keywords',
        ];
    }

    protected function makeSaveValidator(Request $request, array $rules): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), $rules, [], $this->validationAttributes());
    }

    protected function validationErrorResponse(\Illuminate\Contracts\Validation\Validator $validator): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Исправьте ошибки в форме',
            'errors' => $validator->errors(),
        ], 422);
    }

    protected function saveErrorResponse(QueryException $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->humanizeQueryException($e),
        ], 422);
    }

    private function humanizeQueryException(QueryException $e): string
    {
        $sqlError = (int) ($e->errorInfo[1] ?? 0);
        $message = $e->getMessage();

        if ($sqlError === 1062 || str_contains($message, 'Duplicate entry')) {
            if (preg_match("/Duplicate entry '([^']+)'/", $message, $matches)) {
                return "Такой алиас уже используется: «{$matches[1]}». Выберите другой.";
            }

            return 'Такой алиас уже используется. Выберите другой.';
        }

        if ($sqlError === 1406 || str_contains($message, 'Data too long')) {
            if (preg_match("/Data too long for column '([^']+)'/", $message, $matches)) {
                $field = $this->validationAttributes()[$matches[1]] ?? $matches[1];

                return "Поле «{$field}» слишком длинное. Сократите текст или уберите форматирование.";
            }

            return 'Одно из полей слишком длинное. Сократите текст или уберите форматирование.';
        }

        return 'Ошибка при сохранении в базу данных. Попробуйте ещё раз или сократите текст.';
    }
}
