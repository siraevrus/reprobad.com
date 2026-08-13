<?php

return [
    'enabled' => (bool) env('INDEXNOW_ENABLED', true),
    'key' => env('INDEXNOW_KEY', 'a8f3c2e91b7d4e06a5c18f24d9e3b710'),
    'endpoint' => env('INDEXNOW_ENDPOINT', 'https://api.indexnow.org/indexnow'),
];
