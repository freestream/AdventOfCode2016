<?php
$fp         = fopen('input', 'r');
$validOne   = 0;
$validTwo   = 0;
$group      = array_fill(0, 3, []);
$rowCount   = 0;

while (false !== ($line = fgets($fp))) {
    $sides = preg_split('/(\s+)/', trim($line));

    $rowCount++;

    if (isValid($sides)) {
        $validOne++;
    }

    foreach ($sides as $i => $side) {
        $group[$i][] = $side;
    }

    if ($rowCount % 3) {
        continue;
    }

    foreach ($group as $sides) {
        if (isValid($sides)) {
            $validTwo++;
        }
    }

    $group = array_fill(0, 3, []);
}

function isValid(array $sides)
{
    sort($sides);

    $part   = array_sum(array_slice($sides, 0, 2));
    $last   = end($sides);

    return $part > $last;
}

echo "There is {$validOne} valid row triangles and {$validTwo} valid columns triangles\n";

