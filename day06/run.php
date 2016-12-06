<?php
$fp         = fopen('input', 'r');
$rows       = [];
$wordOne    = '';
$wordTwo    = '';
$lines      = 0;

while (false !== ($line = fgets($fp))) {
    $lettes = str_split(trim($line));

    foreach ($lettes as $pos => $letter) {
        if (!isset($rows[$pos])) {
            $lines++;
            $rows[$pos] = [];
        }

        $rows[$pos][] = $letter;
    }
}

for ($i = 0; $i <= $lines-1; $i++) {
    $summery = array_count_values($rows[$i]);
    arsort($summery);
    $summery = array_keys($summery);
    $wordOne .= $summery[0];
    $wordTwo .= $summery[count($summery)-1];
}

echo "The first error-corrected message is {$wordOne} and the second is {$wordTwo}\n";

