<?php
$height = 6;
$width  = 50;


$fp             = fopen('input', 'r');
$grid           = array_fill(0, $height, array_fill(0, $width, 0));
$rectRegex      = '/^rect\s(\d+)x(\d+)$/';
$rotateRegex    = '/rotate\s(\w+)\s\w=(\d+)\sby\s(\d+)$/';

while (false !== ($line = fgets($fp))) {
    $line = trim($line);

    if (preg_match($rectRegex, $line, $matches)) {
        $grid = rect($grid, $matches);
    } elseif (preg_match($rotateRegex, $line, $matches)) {
        $grid = rotate($grid, $matches);
    }
}


function rect($grid, $matches)
{
    list(,$x, $y) = $matches;

    for ($i = 0; $i <= $y-1; $i++) {
        for ($j = 0; $j <= $x-1; $j++) {
            $grid[$i][$j] = 1;
        }
    }

    return $grid;
}

function rotate($grid, $matches)
{
    list(,$o, $t, $n) = $matches;

    $width      = count($grid[0]);
    $height     = count($grid);

    if ($o == 'row') {
        $data   = $grid[$t];

        $data = rotate_array($data, $n);

        $grid[$t] = $data;

    } else {
        $data = [];

        foreach ($grid as $k => $row) {
            $data[] = $row[$t];
        }

        $data = rotate_array($data, $n);

        foreach ($grid as $k => &$row) {
            $row[$t] = $data[$k];
        }
    }

    return $grid;
}

function rotate_array($array, $count)
{
    while ($count) {
        $slice  = array_slice($array, 0, count($array)-1);
        $end    = end($array);

        array_unshift($slice, $end);

        $array = $slice;
        $count--;
    }

    return $array;
}

$sum = 0;
$text = "";

foreach ($grid as $row) {
    $sum += array_sum($row);

    foreach($row as $value) {
        if ($value == 1) {
            $text .= "#";
        } else {
            $text .= "_";
        }
    }

    $text .= "\n";
}

echo "There is a total of {$sum} pixels that is lit and the display shows this message\n\n";
echo $text . "\n";

