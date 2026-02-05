<?php

namespace App\Services;

use App\Models\TestResultField;

class TestCalculationService
{
    /**
     * Рассчитать результаты теста на основе ответов
     * 
     * @param array $answers Массив из 24 ответов (индексы 0-23)
     * @return array Массив с результатами
     */
    public function calculate(array $answers): array
    {
        // Проверяем, что все 24 ответа присутствуют
        if (count($answers) !== 24) {
            throw new \InvalidArgumentException('Должно быть ровно 24 ответа');
        }

        $results = [];
        $scores = [];

        // Категория 1: Вопросы 1-6 (индексы 0-5) - Психоэмоциональное состояние
        $category1 = array_sum(array_slice($answers, 0, 6));
        $scores['category1'] = $category1;

        // Категория 2: Вопросы 7-14 (индексы 6-13) - Микрофлора кишечника и детоксикация
        $category2 = array_sum(array_slice($answers, 6, 8));
        $scores['category2'] = $category2;

        // Категория 3: Вопросы 15-19 (индексы 14-18) - Метаболизм и энергия
        $category3 = array_sum(array_slice($answers, 14, 5));
        $scores['category3'] = $category3;

        // Категория 4: Вопросы 20-24 (индексы 19-23) - Репродуктивное здоровье
        $category4 = array_sum(array_slice($answers, 19, 5));
        $scores['category4'] = $category4;

        // Получаем все активные поля из БД
        $fields = TestResultField::active()->ordered()->get();

        // Проверяем условия для полей 1-9
        foreach ($fields as $field) {
            $score = null;
            $shouldAdd = false;

            switch ($field->field_number) {
                case 1:
                    // Поле 1: Сумма ответов на вопросы 1-2 (индексы 0-1) ≥ 4
                    $score = $answers[0] + $answers[1];
                    $shouldAdd = $score >= 4;
                    break;

                case 2:
                    // Поле 2: Сумма ответов на вопросы 3-6 (индексы 2-5) = 6-8
                    $score = array_sum(array_slice($answers, 2, 4));
                    $shouldAdd = $score >= 6 && $score <= 8;
                    break;

                case 3:
                    // Поле 3: Сумма ответов на вопросы 3-6 (индексы 2-5) ≥ 9
                    $score = array_sum(array_slice($answers, 2, 4));
                    $shouldAdd = $score >= 9;
                    break;

                case 4:
                    // Поле 4: Сумма ответов на вопросы 7-14 (индексы 6-13) = 15-20
                    $score = array_sum(array_slice($answers, 6, 8));
                    $shouldAdd = $score >= 15 && $score <= 20;
                    break;

                case 5:
                    // Поле 5: Сумма ответов на вопросы 7-14 (индексы 6-13) ≥ 21
                    $score = array_sum(array_slice($answers, 6, 8));
                    $shouldAdd = $score >= 21;
                    break;

                case 6:
                    // Поле 6: Сумма ответов на вопросы 15-19 (индексы 14-18) = 8-11
                    $score = array_sum(array_slice($answers, 14, 5));
                    $shouldAdd = $score >= 8 && $score <= 11;
                    break;

                case 7:
                    // Поле 7: Вопросы 15-19 (индексы 14-18), сумма >= 12
                    $score = array_sum(array_slice($answers, 14, 5));
                    $shouldAdd = $score >= 12;
                    break;

                case 8:
                    // Поле 8: Вопросы 20-24 (индексы 19-23), сумма 8-12
                    $score = array_sum(array_slice($answers, 19, 5));
                    $shouldAdd = $score >= 8 && $score <= 12;
                    break;

                case 9:
                    // Поле 9: Вопросы 20-24 (индексы 19-23), сумма >= 13
                    $score = array_sum(array_slice($answers, 19, 5));
                    $shouldAdd = $score >= 13;
                    break;
            }

            if ($shouldAdd) {
                $results[] = [
                    'field_number' => $field->field_number,
                    'description' => $field->description,  // для сайта
                    'email_description' => $field->email_description ?? $field->description, // для email (fallback на description)
                    'color' => $field->color,
                    'image1' => $field->image1,
                    'link1' => $field->link1,
                    'image2' => $field->image2,
                    'link2' => $field->link2,
                    'score' => $score,
                ];
            }
        }

        return [
            'scores' => $scores,
            'results' => $results,
            'hasResults' => count($results) > 0,
        ];
    }
}
