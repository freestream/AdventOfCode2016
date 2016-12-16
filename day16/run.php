<?php
$answers    = [];
$input      = '10111100110001111';
$lengths    = [272, 35651584];

foreach ($lengths as $length) {
    while (strlen($input) < $length) {
        $a = $input;
        $b = strrev($a);

        $b = str_replace('0', '#', $b);
        $b = str_replace('1', '€', $b);
        $b = str_replace('€', '0', $b);
        $b = str_replace('#', '1', $b);

        $input = "{$a}0{$b}";
    }

    $run    = true;
    $input  = substr($input, 0, $length);
    $test   = $input;

    while ($run == true) {
        $pairs      = str_split($test, 2);
        $checksum   = '';

        foreach ($pairs as $pair) {
            $sum = array_sum(str_split($pair));

            if ($sum == 2 || $sum == 0) {
                $checksum .= 1;
            } else {
                $checksum .= 0;
            }
        }

        $test   = $checksum;
        $run    = (strlen($checksum) % 2 == 0);
    }

    $answers[] = $checksum;
}

list($a, $b) = $answers;

echo "The first checksum is '{$a}' and the second one is '{$b}'\n";

