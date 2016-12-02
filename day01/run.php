<?php

$facing     = 1;
$position   = [
    'X' => 0,
    'Y' => 0,
];

$content        = file_get_contents('input');
$instructions   = explode(', ', $content);
$visited        = ['0,0' => 1];
$realHqPos      = [];

foreach ($instructions as $inst) {
    $inst   = trim(($inst));
    $turn   = (string) substr($inst, 0, 1);
    $steps  = (integer) substr($inst, 1);

    switch ($turn) {
        case 'R':
            $facing++;

            if ($facing > 4) {
                $facing = 1;
            }
            break;
        case 'L':
            $facing--;

            if ($facing < 1) {
                $facing = 4;
            }

            break;
    }

    switch ($facing) {
        case '3':
            $steps = 0 - $steps;
        case '1':
            $direction = 'Y';
            break;
        case '4':
            $steps = 0 - $steps;
        case '2':
            $direction = 'X';
            break;
    }

    foreach (range(1, abs($steps)) as $val) {
        $val = ($steps <= 0) ? -1 : 1;
        $position[$direction] += $val;

        if (!empty($realHqPos)) {
            continue;
        }

        $key = implode(',', $position);

        if (!isset($visited[$key])) {
            $visited[$key] = 0;
        }

        $visited[$key]++;

        if ($visited[$key] == 2) {
            $realHqPos = $position;
        }
    }
}

$firstPos       = array_map('abs', $position);
$firstSteps     = array_sum($firstPos);

$secondPos      = array_map('abs', $realHqPos);
$secondSteps    = array_sum($secondPos);

echo "It is {$firstSteps} to the HQ but it is {$secondSteps} to the real HQ\n";

