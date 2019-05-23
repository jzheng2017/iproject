<?php

use EenmaalAndermaal\Controller\GebruikersController;
use EenmaalAndermaal\Controller\IndexController;
use EenmaalAndermaal\Controller\LoginController;
use EenmaalAndermaal\Controller\LegalController;
use EenmaalAndermaal\Controller\RubriekenController;
use EenmaalAndermaal\Controller\UserController;
use EenmaalAndermaal\Controller\VeilingController;
use EenmaalAndermaal\Controller\ZoekResultaatController;
use EenmaalAndermaal\Controller\VerificatieController;

return [
    "dev" => [
        "controllers" => [
            IndexController::class,
            RubriekenController::class,
            VeilingController::class,
            ZoekResultaatController::class
            VerificatieController::class
            UserController::class,
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