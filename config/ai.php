<?php

return [
    'default_provider' => env('AI_DEFAULT_PROVIDER', 'coze'),
    'timeout' => env('AI_HTTP_TIMEOUT', 10),
    'debug' => env('AI_DEBUG', false),
    'logging_days' => env('AI_LOGGING_DAYS', 14),
    'history_limit' => env('AI_HISTORY_LIMIT', 20),
    'user_model' => App\Models\User::class,

    'providers' => [
        'coze' => [
            'token' => env('COZE_API_TOKEN'),
            'bot' => env('COZE_BOT_ID', 111),
            'domain' => env('COZE_DOMAIN', 'api.coze.cn'),
            'path' => env('COZE_PATH', 'open_api/v2/chat'),

        ],
        'qwen' => [
            'token' => env('QWEN_API_TOKEN'),
            'model' => env('QWEN_MODEL', 'qwen1.5-0.5b-chat'),
            'domain' => env('QWEN_DOMAIN', 'dashscope.aliyuncs.com'),
            'path' => env('QWEN_PATH', 'compatible-mode/v1/chat/completions'),

        ],
        'gemini' => [
            'token' => env('GEMINI_API_TOKEN'),
            'domain' => env('GEMINI_DOMAIN', 'generativelanguage.googleapis.com'),
            'path' => env('GEMINI_PATH', 'v1beta/models/gemini-1.5-flash:generateContent'),

        ],

    ],
];
