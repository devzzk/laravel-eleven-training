<?php

return [
    'sql' => [
        'listener_enabled' => env('MN_SQL_LISTENER_ENABLED', true),
        // 可以自定义SQL logging channel, 默认使用stack
        'logging_channel' => env('SQL_LOG_CHANNEL', env('LOG_CHANNEL')),

        // 以下sql不会记录
        'excluded_sql' => [
            // 'select * from users',
        ],

        // 以下tables不会记录
        'excluded_tables' => [
            // 'users'
        ],
    ],

    'composer_packages' => [
        'spatie/laravel-backup' => [
            'dev_only' => false,
            'version' => 'latest',
            'publish_arguments' => '--provider="Spatie\Backup\BackupServiceProvider"',
        ],
        'itsgoingd/clockwork' => [
            'dev_only' => true,
            'version' => 'latest',
            'publish_arguments' => '--provider="Clockwork\Support\Laravel\ClockworkServiceProvider"',
        ],
        'knuckleswtf/scribe' => [
            'dev_only' => true,
            'version' => 'latest',
            'publish_arguments' => '--tag=scribe-config',
        ],
        'larastan/larastan' => [
            'dev_only' => true,
            'version' => 'latest',
            'publish_arguments' => '--provider="MobileNowGroup\LaravelInitializeKit\KitServiceProvider" --tag=analysis',
        ],
        'protoqol/prequel' => [
            'dev_only' => true,
            'version' => 'latest',
            'custom_install_artisan' => 'prequel:install',
        ],
        'laravel/telescope' => [
            'dev_only' => false,
            'version' => 'latest',
            'custom_install_artisan' => 'telescope:install',
            'migrate' => true,
        ],
        'mobilenowgroup/laravel-notification' => [
            'dev_only' => false,
            'version' => 'latest',
            'git_url' => 'git@github.com:MobileNowGroup/laravel-notification.git',
            'pre_command' => 'composer config --no-plugins allow-plugins.easywechat-composer/easywechat-composer true',
            'publish_arguments' => '--provider="MobileNowGroup\LaravelNotification\NotificationServiceProvider"',
        ],
        'spatie/laravel-activitylog' => [
            'dev_only' => false,
            'version' => 'latest',
            'publish_arguments' => '--provider="Spatie\Activitylog\ActivitylogServiceProvider"',
            'migrate' => true,
        ],
    ],
];
