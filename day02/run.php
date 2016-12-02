<?php
$fp         = fopen('input', 'r');
$posOne     = [1, 1];
$posTwo     = [2, 0];
$codeOne    = [];
$codeTwo    = [];
$keypadOne  = [
    range(1, 3),
    range(4, 6),
    range(7, 9),
];

$keypadTwo  = [
    [null, null, 1, null, null],
    [null, 2, 3, 4, null],
    [5, 6, 7, 8, 9],
    [null, 'A', 'B', 'C', null],
    [null, null, 'D', null, null],
];

while (false !== ($line = fgets($fp))) {
    $line = str_split(trim($line));

    foreach ($line as $inst) {
        list($yo, $xo) = $posOne;
        list($yt, $xt) = $posTwo;

        switch ($inst) {
            case 'U':
                $yo--;
                $yt--;
                break;
            case 'D':
                $yo++;
                $yt++;
                break;
            case 'L':
                $xo--;
                $xt--;
                break;
            case 'R':
                $xo++;
                $xt++;
                break;
        }

        if (isset($keypadOne[$yo][$xo])) {
            $posOne = [$yo, $xo];
        }

        if (isset($keypadTwo[$yt][$xt]) && $keypadTwo[$yt][$xt]) {
            $posTwo = [$yt, $xt];
        }
    }

    list($yo, $xo) = $posOne;
    list($yt, $xt) = $posTwo;

    $codeOne[] = $keypadOne[$yo][$xo];
    $codeTwo[] = $keypadTwo[$yt][$xt];
}

$codeOne = implode($codeOne);
$codeTwo = implode($codeTwo);

echo "The code should have been {$codeOne} but given the actual keypad layout, the code would be {$codeTwo}\n";

