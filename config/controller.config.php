<?php

use EenmaalAndermaal\Controller\IndexController;
use EenmaalAndermaal\Controller\LoginController;
use EenmaalAndermaal\Controller\RubriekenController;
use EenmaalAndermaal\Controller\VeilingController;

return [
    "dev" => [
        "controllers" => [
            IndexController::class,
            RubriekenController::class,
            VeilingController::class,
            LoginController::class
        ]
    ],
    "production" => [
        "controllers" => [
            IndexController::class,
        ]
    ]
];