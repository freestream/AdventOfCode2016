<?php
$fp             = fopen('input', 'r');
$answers        = [];
$registersOne   = array_fill_keys(['a', 'b', 'c', 'd'], 0);
$registersTwo   = $registersOne;

$registersTwo['c'] = 1;

while (false !== ($line = fgets($fp))) {
    $instructions[] = trim($line);
}

foreach ([$registersOne, $registersTwo] as $registers) {
    $position = 0;

    while ($position < count($instructions)) {
        $line   = $instructions[$position];
        $parts  = preg_split('/\s/', $line);

        switch ($parts[0]) {
            case 'cpy':
                $registers[$parts[2]] = (is_numeric($parts[1])) ? $parts[1] : $registers[$parts[1]];
                break;
            case 'jnz':
                $val = (is_numeric($parts[1])) ? $parts[1] : $registers[$parts[1]];

                if ($val != 0) {
                    $position += (is_numeric($parts[2])) ? $parts[2] : $registers[$parts[1]];
                    $position--;
                }
                break;
            case 'inc':
                $registers[$parts[1]] += 1;
                break;
            case 'dec':
                $registers[$parts[1]] -= 1;
                break;
        }

        $position++;
    }

    $answers[] = $registers['a'];
}

list($a, $b) = $answers;

echo "{$a} is left in register 'a' and after initialize register 'c' the leftover is {$b}\n";

