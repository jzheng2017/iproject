<?php

use EenmaalAndermaal\Controller\IndexController;
use EenmaalAndermaal\Controller\RubriekenController;
use EenmaalAndermaal\Controller\VeilingController;
use EenmaalAndermaal\Controller\VerificatieController;

return [
    "dev" => [
        "controllers" => [
            IndexController::class,
            RubriekenController::class,
            VeilingController::class,
            VerificatieController::class
        ]
    ],
    "production" => [
        "controllers" => [
            IndexController::class,
        ]
    ]
];