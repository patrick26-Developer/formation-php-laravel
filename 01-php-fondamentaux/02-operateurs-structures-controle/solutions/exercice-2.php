<?php

$age = 15;

if ($age < 13) {
    echo "Enfant";
} elseif ($age < 18) {
    echo "Adolescent";
} elseif ($age < 65) {
    echo "Adulte";
} else {
    echo "Senior";
}
