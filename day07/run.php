<?php
$fp = fopen('input', 'r');
$countTls = 0;
$countSsl = 0;

while (false !== ($line = fgets($fp))) {
    $parts      = preg_split('/\[|\]/', trim($line));
    $supportTls = false;
    $supportSsl = false;
    $isInvalid  = false;

    foreach ($parts as $key => $part) {
        $isHypernet = ($key % 2 == 0) ? false : true;
        $foundPair  = isAbba($part);

        if ($isHypernet == true && $foundPair == true) {
            $isInvalid = true;
        } elseif ($foundPair == true) {
            $supportTls = true;
        }

        if ($isHypernet == false) {
            $abas = getAbas($part);

            foreach ($abas as $aba) {
                if ($supportSsl == true) {
                    continue;
                }

                $supportSsl = hasBabOfAba($parts, $aba);
            }
        }
    }

    if ($supportTls == true && $isInvalid == false) {
        $countTls++;
    } else {
    }

    if ($supportSsl == true) {
        $countSsl++;
    } else {
    }
}

function isAbba($part)
{
    for ($i = 0; $i <= strlen($part)-4; $i++) {
        $one = substr($part, $i, 2);
        $two = substr($part, $i+2, 2);

        if ($one[0] == $one[1]) {
            continue;
        }

        if ($one == strrev($two)) {
            return true;
        }
    }

    return false;
}

function getAbas($part)
{
    $abas = [];

    for ($i = 0; $i <= strlen($part)-3; $i++) {
        $slice = substr($part, $i, 3);

        list($a, $b, $c) = str_split($slice);

        if ($a == $c && $a != $b) {
            $abas[] = $slice;
        }
    }

    return $abas;
}

function hasBabOfAba($parts, $aba)
{
    list($a, $b, $c) = str_split($aba);

    $compare = "{$b}{$a}{$b}";

    foreach ($parts as $key => $part) {
        $isHypernet = ($key % 2 == 0) ? false : true;

        if (!$isHypernet) {
            continue;
        }

        for ($i = 0; $i <= strlen($part)-3; $i++) {
            $slice = substr($part, $i, 3);

            if ($compare == $slice) {
                return true;
            }
        }
    }

    return false;
}

echo "There is {$countTls} IP-addresses that support TLS and {$countSsl} that supports SSL\n";

