<?php

use EenmaalAndermaal\Controller\HeaderContentController;
use EenmaalAndermaal\Controller\FeedbackController;
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
            ZoekResultaatController::class,
            VerificatieController::class,
            UserController::class,
            LoginController::class,
            LegalController::class,
            FeedbackController::class,
            HeaderContentController::class
        ],
    ],
    "production" => [
        "controllers" => [
            IndexController::class,
        ]
    ]
];