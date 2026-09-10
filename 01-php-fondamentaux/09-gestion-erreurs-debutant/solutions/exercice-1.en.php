<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

echo $inexistante;
// With error_reporting(E_ALL): shows a Warning "Undefined variable $inexistante"
// (the script keeps running anyway, the variable is treated as null).

// By commenting out error_reporting(E_ALL) and ini_set(...), PHP uses its
// default configuration (php.ini), which may hide this warning depending
// on the environment — hence the importance of forcing E_ALL in
// development to never miss a silent bug.
