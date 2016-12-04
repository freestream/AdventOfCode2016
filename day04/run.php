<?php
$fp     = fopen('input', 'r');
$sum    = 0;

while (false !== ($line = fgets($fp))) {
    $parts  = preg_split('/-/', trim($line));
    $last   = end($parts);

    array_pop($parts);
    preg_match('/(\d+)\[(\w+)\]/', trim($last), $split);
    array_shift($split);

    $parts      = array_merge($parts, $split);
    $encrypted  = array_splice($parts, 0, count($parts)-2);
    $occurred   = [];
    $decrupted  = [];

    list($room, $checksum) = array_splice($parts, -2);

    foreach ($encrypted as $piece) {
        $decrupted[] = decrypt($piece, $room);

        $piece      = str_split($piece);
        $counts     = array_count_values($piece);


        foreach ($counts as $letter => $count) {
            if (!isset($occurred[$letter])) {
                $occurred[$letter] = 0;
            }

            $occurred[$letter] += $count;
        }
    }

    $name = implode('-', $decrupted);

    if ($name == 'northpole-object-storage') {
        $northpoleRoomId = $room;
    }

    array_multisort($occurred, SORT_DESC, array_keys($occurred), SORT_ASC, array_values($occurred));

    $occurred   = array_keys(array_slice($occurred, 0, 5));
    $test       = str_split($checksum);

    if ($occurred == $test) {
        $sum += $room;
    }
}

function decrypt($text, $shift) {
    $text = str_split($text);

    foreach ($text as &$letter) {
        $value = ord($letter);

        for ($i = 0; $i < $shift; $i++) {
            if ($value == 122) {
              $value = 97;
            } else {
              $value++;
            }
        }

        $letter = chr($value);
    }

    return implode($text);
}

echo "The sum of all the real room sector IDs is {$sum} and all the North Pole objects is stored in room {$northpoleRoomId}\n";

