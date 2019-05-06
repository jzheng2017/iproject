<?php

use EenmaalAndermaal\Controller\IndexController;

return [
    "dev" => [
        "controllers" => [
            IndexController::class
        ]
    ],
    "production" => [
        "controllers" => [
            IndexController::class,
        ]
    ]
];