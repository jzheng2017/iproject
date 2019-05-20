<?php

use EenmaalAndermaal\Controller\IndexController;
use EenmaalAndermaal\Controller\RubriekenController;
use EenmaalAndermaal\Controller\UserController;
use EenmaalAndermaal\Controller\VeilingController;

return [
    "dev" => [
        "controllers" => [
            IndexController::class,
            RubriekenController::class,
            VeilingController::class,
            UserController::class
        ]
    ],
    "production" => [
        "controllers" => [
            IndexController::class,
        ]
    ]
];