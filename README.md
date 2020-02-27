# packagist console table

### Display a table in the console from parameters.
   
#### Install : 
`composer require sauvank/php-console-table`

#### Doc :

#### Show Table from parameters :

```PHP
<?php

use ConsoleTable\Table;

$columns = [
    'column title', // By default, the size column = 30 char

     [ // If you want define custom size for this column 
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

 // Optional
 $conf = [
     'margin' => 1, // int , Default : 1, set space character beetween limit column. 
     'showNumberRow' => true, // Bool, default : true,  show the row number in table.
     'defaultSizeCol' => 30, // int, default : 30, set default size column.
 ];

 $pt = new Table($columns, $lines, $conf);
 $pt->show(); // Show all row of table

```
> Output in console :
````

------------------------------------------------------
| Row  | column title                   | release    |
------------------------------------------------------
| 1    | Fight club                     | 1999-11-10 |
------------------------------------------------------
| 2    | The lion king                  | 2019-07-17 |
------------------------------------------------------

````

#### Show specific row ;

```PHP
  // Return trow error if index row not exist
  $pt->showRow(2);
```


> Output in console :
````

------------------------------------------------------
| Row  | title                          | release    |
------------------------------------------------------
| 2    | The lion king                  | 2019-07-17 |
------------------------------------------------------

````

### Use readline

#### Basic usage :

> Just get the answer user :

```PHP
use ConsoleTable\Readline;

$txtToShow = "line to show :";

$userAnswer = new Readline($txtToShow);

```



#### readline with option : 

> If the user enters a value other than that included in the "option" array, the question is asked again

```PHP
use ConsoleTable\Readline;

$txtToShow = "line to show :";
$option = ["y", "n"];

$userAnswer = new Readline($txtToShow, $option);

```

#### Option by default :
> If the user enters an empty value, the option by default is taken

```PHP
use ConsoleTable\Readline;

$txtToShow = "line to show :";
$option = ["y", "n"]; // list of optino valid
$defaultValue = 0; // key index of the $option array.

$userAnswer = new Readline($txtToShow, $option, $defaultValue);

```

#### Confirm the last choice :
> Add a prompt for confim choice.

```PHP
use ConsoleTable\Readline;

$readline= new Readline("line to show", ['1', '2']);
$confirm = $readline->confirm(); // return true or false

if($confirm){
    echo "You have confirmed your choice " . $readline->getAnswer();
}else{
    echo "You have not confirm your choice.\n";
}

```
