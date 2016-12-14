<?php
$input      = 'abc';
$i          = 0;
$firstKeys  = 0;
$secKeys    = [];

while ($firstKeys < 64) {
    do {
        $i++;
        $hash = generateHash($i);
    } while (!isValid($hash));

    $firstKeys++;
}

$answersOne = $i;

$i = 0;

while ($secKeys < 64) {
    do {
        $i++;
        $hash = stretch(generateHash($i));
    } while (!isValid($hash, true));

    $secKeys++;
}

$answersTwo = $i;

echo "During the first run the index was {$answersOne} and on the second the index was {$answersTwo}\n";

function isValid($hash, $moreSecure = false)
{
    global $i;
    global $input;

    $orig = $hash;

    if (!preg_match('/(.)\1{2}/', $hash, $matches)) {
        return false;
    }

    $char = $matches[1][0];

    foreach (range($i+1, $i+1001) as $k) {
        $testHash = generateHash($k);

        if ($moreSecure == true) {
            $testHash = stretch($testHash);
        }

        if (preg_match("/({$char}){5}/", $testHash)) {
            return true;
        }
    }

    return false;
}

function generateHash($i)
{
    global $input;

    return md5("{$input}{$i}");
}

function stretch($hash)
{
    foreach (range(1, 2016) as $i) {
        $hash = md5($hash);
    }

    return $hash;
}
