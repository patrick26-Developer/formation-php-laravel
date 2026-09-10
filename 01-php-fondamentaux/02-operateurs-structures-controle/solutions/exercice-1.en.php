<?php

// Predictions (to compare against the actual run):
// "0" == false        -> true  ("0" is a "falsy" string, converted to false)
// "" == null          -> true  (empty string and null are both "falsy")
// "abc" == 0          -> false (PHP 8+: a non-numeric string is no longer converted to 0)
// 1 === 1.0           -> false (int !== float, even though the numeric value is equal)
// null == false        -> true  (null is "falsy")

var_dump("0" == false);
var_dump("" == null);
var_dump("abc" == 0);
var_dump(1 === 1.0);
var_dump(null == false);
