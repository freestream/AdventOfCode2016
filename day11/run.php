<?php
$answers = [];

foreach (['input', 'input2'] as $filename) {
    $answers[] = getMinimumMoves(getFloor($filename));
}

list($one, $two) = $answers;

echo "The minimum number of steps is {$one} and with the extra parts it will be {$two}\n";

function getFloor($filename)
{
    $fp         = fopen($filename, 'r');
    $partRegex  = '/([\w-])[\w-]+\s(\w)\w+\.?$/';
    $floorRegex = '/^\w+\s(\w+)/';
    $floor      = [];
    $translate  = [
        'first'     => 1,
        'second'    => 2,
        'third'     => 3,
        'fourth'    => 4,
    ];

    while (false !== ($line = fgets($fp))) {
        $line   = trim($line);
        $parts  = preg_split('/,\sand\s|,|\sand\s/', $line);

        preg_match($floorRegex, $parts[0], $matches);

        $nr         = $translate[$matches[1]];
        $contains   = [];

        foreach ($parts as $part) {
            preg_match($partRegex, $part, $matches);
            array_shift($matches);
            $name = strtoupper(implode($matches));

            if ($name !== 'NR') {
                $contains[] = str_split($name);
            }
        }

        $floor[$nr] = $contains;
    }

    return $floor;
}

function getMinimumMoves($floor)
{
    $elevator   = ['floor' => 1, 'carry' => []];
    $moves      = 0;
    $moves      = 0;
    $total      = 0;

    foreach ($floor as $content) {
        $total += count($content);
    }

    while (count($floor[count($floor)]) != $total) {
        $moves++;

        $nr         = $elevator['floor'];
        $content    = $floor[$nr];

        if (isset($floor[$nr-1]) && count($floor[$nr-1])) {
            $next = $nr-1;

            foreach ($content as $i => $part) {
                if (validate(psudoFloor($floor, $nr, $next, [$part]))) {
                    $floor[$next][] = $part;
                    unset($content[$i]);

                    $elevator['floor']--;
                    break;
                }
            }
        } else {
            $next = $nr+1;

            foreach ($content as $i => $a) {
                foreach ($content as $j => $b) {
                    if ($a == $b) {
                        continue;
                    }

                    if (validate(psudoFloor($floor, $nr, $next, [$a, $b]))) {
                        $floor[$next][] = $a;
                        $floor[$next][] = $b;

                        unset($content[$i]);
                        unset($content[$j]);

                        $elevator['floor']++;
                        break 2;
                    }

                    $options[] = [$a, $b];
                }
            }
        }


        $floor[$nr] = $content;
    }

    return $moves;
}

function psudoFloor($floor, $current, $dest, $carry)
{
    $currentContent = $floor[$current];
    $destContent    = $floor[$dest];

    foreach ($carry as $part) {
        foreach ($currentContent as $i => $a) {
            if ($part == $a) {
                unset($currentContent[$i]);
                $destContent[] = $part;
                break;
            }
        }
    }

    $floor[$current]    = $currentContent;
    $floor[$dest]       = $destContent;

    return $floor;
}

function validate($floor)
{
    $validate = [];

    foreach ($floor as $nr => $current) {
        $safe           = 0;
        $microchips     = [];
        $generators     = [];

        foreach ($current as $a) {
            if ($a[1] == 'G') {
                $generators[] = $a[0];
            }
        }

        if (count($generators) == count($current)) {
            $validate[$nr] = 1;
        }

        foreach ($current as $a) {
            if ($a[1] == 'M') {
                $microchips[] = $a[0];
            }
        }

        if (count($microchips) == count($current)) {
            $validate[$nr] = 1;
        }

        $safe   = 0;
        $pairs  = [];

        $testGenerators = array_fill_keys($generators, 0);

        foreach ($microchips as $m) {
            foreach ($generators as $g => &$con) {
                if ($m == $g && $con == 0) {
                    $con = 1;
                }
            }
        }

        if (array_sum($generators) == count($generators)) {
            $validate[$nr] = 1;
        }
    }

    return (array_sum($validate) == true);
}

