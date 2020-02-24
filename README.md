# packagist_prompt_table

### Display a table in the console from parameters.
   
#### Install : 
`composer require sauvank/packages-composer`

#### Doc :

#### Show Table from parameters :

```PHP
<?php

use ConsoleTable\Table;

$columns = [
     [
         'name' => 'title', // Title of the column
         'size' => 30 // Maximum size in char
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

```
> Output in console :
````

------------------------------------------------------
| Row  | title                          | release    |
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
