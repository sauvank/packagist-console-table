<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use ConsoleTable\Table;

$columns = [
    [
        'name' => 'title',
        'size' => 30
    ],
    [
        'name' => 'release',
        'size' => 10
    ]
];

$lines = [
    [
        "Fight club",
        "1999-11-10"
    ],
    [
        "The lion king",
        "2019-07-17"
    ],
];

// Not required
$conf = [
    'margin' => 1, // int , set space character beetween limit column. Default : 1
    'showNumberRow' => true, // Bool, show the row number in table, by default : true
];

$pt = new Table($columns, $lines, $conf);
$pt->show(); // Show all row of table
