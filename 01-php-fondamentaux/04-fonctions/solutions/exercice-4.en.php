<?php

declare(strict_types=1);

function diviser(int $a, int $b): float {
    return $a / $b;
}

echo diviser(10, 2) . "\n"; // 5: works, two valid integers

// diviser("10", 2);
// With declare(strict_types=1), this call throws:
// TypeError: diviser(): Argument #1 ($a) must be of type int, string given
//
// Without strict_types (the default mode), PHP would have silently
// converted "10" to the integer 10 and the call would have worked.
// strict_types forces you to be explicit: either cast before the call
// ((int) "10"), or assume the caller already supplies the right type.
