<?php

return [
    'block_titles' => [
        1 => 'Психоэмоциональное состояние',
        2 => 'Микрофлора кишечника и детоксикация',
        3 => 'Метаболизм и энергия',
        4 => 'Репродуктивное здоровье',
    ],
    'block_css' => [
        1 => 'psih',
        2 => 'energy',
        3 => 'meta',
        4 => 'gorm',
    ],
    'block_icons' => [
        1 => 'images/test-1.svg',
        2 => 'images/test-2.svg',
        3 => 'images/test-3.svg',
        4 => 'images/test-4.svg',
    ],
    /** Максимум суммы баллов по вопросам блока (как в TestCalculationService::M). */
    'block_max_sum' => [
        1 => 18,
        2 => 24,
        3 => 15,
        4 => 15,
    ],

    'coding_to_block' => [
        1 => 1,
        2 => 1,
        3 => 2,
        4 => 2,
        5 => 2,
        6 => 3,
        7 => 3,
        8 => 4,
        9 => 4,
    ],
    /** Показывать GET /test/preview с пустыми данными (для вёрстки). По умолчанию только в local. */
    'allow_result_preview' => env('ALLOW_TEST_RESULT_PREVIEW', env('APP_ENV') === 'local'),
];
