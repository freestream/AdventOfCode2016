<?php
$fp         = fopen('input', 'r');
$validOne   = 0;
$validTwo   = 0;
$group      = array_fill(0, 3, []);
$rowCount   = 0;

while (false !== ($line = fgets($fp))) {
    $line   = trim($line);
    $sides  = preg_split('/(\s+)/', $line);

    $rowCount++;

    if (isValid($sides)) {
        $validOne++;
    }

    foreach ($sides as $i => $side) {
        $group[$i][] = $side;
    }

    if ($rowCount != 3) {
        continue;
    }

    $rowCount = 0;

    foreach ($group as $sides) {
        if (isValid($sides)) {
            $validTwo++;
        }
    }

    $group = array_fill(0, 3, []);
}

function isValid(array $sides)
{
    $count = 0;
    $total = array_sum($sides);

    foreach ($sides as $i => $side) {
        if (($total - $side) > $side) {
            $count++;
        }
    }

    return ($count == count($sides));
}

echo "There is {$validOne} valid row triangles and {$validTwo} valid columns triangles\n";

