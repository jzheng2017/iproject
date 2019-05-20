<?php

use EenmaalAndermaal\Controller\GebruikersController;
use EenmaalAndermaal\Controller\IndexController;
use EenmaalAndermaal\Controller\LoginController;
use EenmaalAndermaal\Controller\LegalController;
use EenmaalAndermaal\Controller\RubriekenController;
use EenmaalAndermaal\Controller\VeilingController;

return [
    "dev" => [
        "controllers" => [
            IndexController::class,
            RubriekenController::class,
            VeilingController::class,
            LoginController::class,
            LegalController::class,
            GebruikersController::class
        ],
    ],
    "production" => [
        "controllers" => [
            IndexController::class,
        ]
    ]
];