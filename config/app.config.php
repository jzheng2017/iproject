<?php
return [
    "dev" => [
        /* Database configuration */
        "database" => [
            "host"      => "mssql.iproject.icasites.nl",
            "database"  => "iproject21",
            "username"  => "iproject21",
            "password"  => "WBjegW3FFf"
        ],
        /* Website configuration */
        "website" => [
            "url" => [
                "http://localhost/IProject/API/"
            ]
        ]
    ],
    "production" => [
        "database" => [
            "host"      => "mssql.iproject.icasites.nl",
            "database"  => "iproject21",
            "username"  => "iproject21",
            "password"  => "WBjegW3FFf"
        ],
        /* Website configuration */
        "website" => [
            "url" => [
                "http://iproject21.icasites.nl/api/"
            ]
        ]
    ]
];