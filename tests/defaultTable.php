<?php

use ConsoleTable\Table;
use ConsoleTable\Readline;

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

$columns = [
    'column',
    [
      'name' => 'column 2',
      'size' => 30
    ],
    'i ma the big string',
];

$lines = [
    [
        "I am the big string",
        "not me",
        "not me",
    ],
    [
        "max 30",
        "12345678901234567890123456789012",
        "1250",
    ],
    [
        "header",
        "is",
        "the best",
    ],
];

$conf = [
//    'defaultSizeCol' => 10
];

$pt = new Table($columns, $lines, $conf);

//$readline= new Readline("line to show", ['y', 'n']);
//$readline = new Readline("line to show :", range(1, count($lines)));

$pt->show(); // Show all row
//$pt->showRow($readline->getAnswer()); // Show one specific row
