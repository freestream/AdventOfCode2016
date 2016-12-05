<?php
$input      = 'abbhdwsy';
$i          = 0;
$passOne    = '';
$passTwo    = [];

while (count($passTwo) != 8) {
    do {
        $i++;
        $hash = md5("{$input}{$i}");
    } while (!preg_match("/^[0]{5}/", $hash));

    if (strlen($passOne) != 8) {
        $passOne .= substr($hash, 5, 1);
    }

    $pos    = substr($hash, 5, 1);
    $char   = substr($hash, 6, 1);

    if (!is_numeric($pos) || $pos > 7 || isset($passTwo[$pos])) {
        continue;
    }

    $passTwo[$pos] = $char;
}

ksort($passTwo);

$passTwo = implode($passTwo);

echo "The first password is {$passOne} and the second password is {$passTwo}\n";

