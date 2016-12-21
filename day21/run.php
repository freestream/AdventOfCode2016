<?php
$fp     = fopen('input', 'r');
$lines  = [];

while (false !== ($line = fgets($fp))) {
    $lines[] = trim($line);
}

function solve($input)
{
    global $lines;

    foreach ($lines as $line) {
        $result = preg_split('/\s/', $line);

        switch ($result[0]) {
            case 'swap':
                swap($input, $result);
                break;
            case 'reverse':
                reverse($input, $result);
                break;
            case 'rotate':
                rotate($input, $result);
                break;
            case 'move':
                move($input, $result);
                break;
        }
    }

    return $input;
}

$first = solve('abcdefgh');
$second = unScrambled('fbgdceah');

echo "The scrambling result is {$first} and the un-scrambled version is {$second}\n";

function unScrambled($input)
{
    $results = [];

    permute('',$input,$results);

    foreach ($results as $result) {
        if (solve($result) == $input) {
            return $result;
        }
    }

    return false;
}

function permute($prefix, $letters, &$results)
{
    if (strlen($letters) == 0) {
        $results[] = $prefix;
    } else {
        for ($i = 0; $i < strlen($letters); $i++) {
            permute($prefix . $letters[$i], substr($letters, 0, $i) . substr($letters, $i + 1), $results);
        }
    }
}

function swap(&$input, $match)
{
    list(,$a,$b,,,$c) = $match;

    $split = str_split($input);

    if ($a == 'letter') {
        $b = strpos($input, $b);
        $c = strpos($input, $c);
    }

    $tmp        = $split[$b];
    $split[$b]  = $split[$c];
    $split[$c]  = $tmp;

    $input = implode($split);
}

function reverse(&$input, $match)
{
    list(,,$a,,$b) = $match;

    $b = $b-$a+1;

    $input = implode([
        substr($input, 0, $a),
        strrev(substr($input, $a, $b)),
        substr($input, $a + $b),
    ]);
}

function rotate(&$input, $match)
{
    list(,$a,$b) = $match;

    if ($a == 'based') {
        list(,,,,,,$c) = $match;
        $times = strpos($input, $c);

        if ($times >= 4) {
            $times++;
        }

        $times++;

        $b = $times;
        $a = 'right';
    }

    $split = str_split($input);

    if ($a == 'right') {
        while ($b) {
            $slice  = array_slice($split, 0, count($split)-1);
            $end    = end($split);

            array_unshift($slice, $end);

            $split = $slice;
            $b--;
        }
    } else {
        while ($b) {
            array_push($split, array_shift($split));
            $b--;
        }
    }

    $input = implode($split);
}

function move(&$input, $match)
{
    list(,,$a,,,$b) = $match;

    $input  = str_split($input);
    $tmp    = $input[$a];
    unset($input[$a]);

    $input = array_combine(
        range(100, (count($input))*100, 100),
        array_values($input)
    );

    $b = $b*100+50;

    $input[$b] = $tmp;

    ksort($input);

    $input = implode($input);
}
