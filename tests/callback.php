<?php

use ConsoleTable\Table;
use ConsoleTable\Readline;

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload
function test(){
    echo "terdqsdqsdqsdst\n";
}function id(){
    echo "iqsdqsdqsdsssssssssssssd\n";
}

$answer = false;
$columns = [
    [
        'name' => 'title',
        'size' => 30
    ],
    [
        'name' => 'release',
        'size' => 10
    ],
    [
        'name' => 'release',
        'size' => 10
    ]
];

$lines = [];
for ($i = 0; $i <= 9; $i++){
    $lines[] = [
        uniqid("E"),
        uniqid("R"),
        uniqid("N")
    ];
}

$pt = new Table($columns, $lines);

$readline = new Readline("line to show", ['AaA', 'bBb'],
    [
        [
            'name' => ':q',
            'action' => 'test'
        ],
        [
            'name' => ':id',
            'action' => function(){
                $readline2 = new Readline("Set new id ");
            }
        ]
    ]
);
echo $readline->getAnswer();


