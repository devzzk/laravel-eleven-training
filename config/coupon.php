<?php

return [
    'relation' => [
        'user_model' => App\Models\User::class,
        'user_union_id_column' => 'id',
    ],

    'http' => [
        'middleware' => [
            'auth:guard',
        ],
    ],

];
