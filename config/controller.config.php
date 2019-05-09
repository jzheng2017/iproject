<?php

use EenmaalAndermaal\Controller\IndexController;
use EenmaalAndermaal\Controller\RubriekenController;

return [
    "dev" => [
        "controllers" => [
            IndexController::class,
            RubriekenController::class
        ]
    ],
    "production" => [
        "controllers" => [
            IndexController::class,
        ]
    ]
];