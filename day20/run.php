<?php
$fp         = fopen('input', 'r');
$start      = [];
$end        = [];
$ipRange    = 4294967295;
$banned     = 0;

while (false !== ($line = fgets($fp))) {
    $line = trim($line);
    list($a, $b) = explode('-', $line);

    $start[] = $a;
    $end[] = $b;
}

array_multisort($start, SORT_ASC, $end);

for ($i = 0; $i < count($start) -1; $i++) {
    $j = 0;

    while (isset($start[$i+$j]) && $end[$i] >= $start[$i+$j] -1) {
        if ($end[$i+$j] > $end[$i]) {
            $end[$i] = $end[$i+$j];
        }

        $j++;
    }

    $ipRange -= ($end[$i] - $start[$i] +1);
    $i += $j -1;
}

$firstIp        = $end[0]+1;
$allowedIpds    = $ipRange+1;

echo "The first IP address is {$firstIp} and there is {$allowedIpds} allowed IP-addresses\n";

