<?php
$fp             = fopen('input', 'r');
$bots           = [];
$output         = [];
$instr          = [];
$outputRegex    = '/output/';
$valueRegex     = '/^value/';
$numberRegex    = '/(\D+)/';
$instrRegex     = '/^bot\D+(\d+)\D+(bot|output)\D+(\d+)\D+(bot|output)\D+(\d+)$/';
$partOne        = '';

while (false !== ($line = fgets($fp))) {
    $line   = trim($line);
    $values = array_values(array_filter(preg_split($numberRegex, $line)));

    if (preg_match($valueRegex, $line)) {
        list($a, $b) = $values;

        if (!isset($bots[$b])) {
            $bots[$b] = [];
        }

        $vals   = $bots[$b];
        $vals[] = $a;

        sort($vals);

        $bots[$b] = $vals;
    } else {
        preg_match($instrRegex, $line, $matches);
        list(,$bot, $ltype, $lnr, $htype, $hnr) = $matches;
        $instr[$bot] = [
            'l' => "{$ltype}::{$lnr}",
            'h' => "{$htype}::{$hnr}",
        ];
    }
}

while (count($instr)) {
    foreach ($bots as $nr => &$values) {
        if (count($values) != 2) {
            continue;
        }

        if (in_array(17, $values) && in_array(61, $values)) {
            $partOne = $nr;
        }

        if (!isset($instr[$nr])) {
            continue;
        }

        $instructions = $instr[$nr];

        foreach ($instructions as $v => $data) {
            list($type, $target) = preg_split('/::/', $data);

            $val = ($v == 'h') ? $values[1] : $values[0];

            switch ($type) {
                case 'bot':
                    if (!isset($bots[$target])) {
                        $bots[$target] = [];
                    }

                    $vals   = $bots[$target];
                    $vals[] = $val;

                    sort($vals);

                    $bots[$target] = $vals;
                    break;
                case 'output':
                    $output[$target] = $val;
                    break;
            }
        }

        unset($instr[$nr]);

        $values = [];
    }
}

$sum = $output[0] * $output[1] * $output[2];

echo "The bot that compares val 61 and 17 is {$partOne} and the sum of the output multiplication is {$sum}\n";

