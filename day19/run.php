<?php
$answers    = [];
$input      = 3012210;
$dec        = decbin($input);
$partOne    = bindec(substr($dec.$dec[0], 1));

$i = 1;

while ($i * 3 < $input) {
    $i *= 3;
}

$partTwo = $input - $i;

echo "The winner in the first round was elf nr {$partOne} and in the second round nr {$partTwo} won\n";

