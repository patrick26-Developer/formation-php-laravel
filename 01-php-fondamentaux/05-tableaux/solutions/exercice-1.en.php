<?php

$courses = ["bread", "butter", "eggs", "flour", "sugar"];

$courses[] = "milk";
echo "Number of items: " . count($courses) . "\n";

var_dump(in_array("milk", $courses)); // true

$premier = array_shift($courses); // removes AND returns the first element
echo "Removed item: $premier\n";
print_r($courses);
