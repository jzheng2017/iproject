<?php
return [
    "dev" => [
        /* Database configuration */
        "API" => [
            "url" => "http://localhost/IProject/API"
        ],
        /* Website configuration */
        "website" => [
            "url" => "http://localhost/IProject/website/",
            "mail" => [
                "sender" => "no-reply@eenmaalandermaal.nl"
            ]
        ]
    ],
    "production" => [
        "API" => [
            "url" => "http://iproject21.icasites.nl/api/"
        ],
        /* Website configuration */
        "website" => [
            "url" => "http://iproject21.icasites.nl/",
            "mail" => [
                "sender" => "no-reply@eenmaalandermaal.nl"
            ]
        ]
    ]
];