<?php

$age = 15;

if ($age < 13) {
    echo "Child";
} elseif ($age < 18) {
    echo "Teenager";
} elseif ($age < 65) {
    echo "Adult";
} else {
    echo "Senior";
}
