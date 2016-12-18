<?php
$content    = trim(file_get_contents('input'));
$answers    = [];

foreach ([40, 400000] as $rowCount) {
    $prev   = str_split($content);
    $safe   = substr_count($content, '.');

    foreach (range(1, $rowCount-1) as $nr) {
        $curr = [];

        for ($i = 0; $i < count($prev); $i++) {
            $left   = isset($prev[$i-1]) ? $prev[$i-1] : false;
            $center = $prev[$i];
            $right  = isset($prev[$i+1]) ? $prev[$i+1] : false;
            $isTrap = false;

            if ($left == '^' && $center == '^' && $right != '^') {
                $isTrap = true;
            }

            if ($right == '^' && $center == '^' && $left != '^') {
                $isTrap = true;
            }

            if ($left == '^' && $center != '^' && $right != '^') {
                $isTrap = true;
            }

            if ($right == '^' && $center != '^' && $left != '^') {
                $isTrap = true;
            }

            if (!$isTrap) {
                $curr[$i] = '.';
                $safe++;
            } else {
                $curr[$i] = '^';
            }
        }

        $prev = $curr;
    }

    $answers[] = $safe;
}

list($a, $b) = $answers;

echo "In 40 rows there is {$a} safe tiles and in 400000 rows there is {$b} safe tiles\n";

