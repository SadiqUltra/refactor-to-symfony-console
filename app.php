<?php


// reduce api call time into ONE
$rates = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true)['rates'];

foreach (explode("\n", file_get_contents($argv[1])) as $row) {

    if (empty($row)) break;

    // removed ugly json decode

    // json Exception
    try{
        $jsonRow = json_decode($row);
    }catch(Exception $e){
        echo 'Caught exception: ',  $e->getMessage(), PHP_EOL;
        continue;
    }

    $binResults = file_get_contents('https://lookup.binlist.net/' . $jsonRow->bin);

    if (!$binResults)
        die('error!');
    $r = json_decode($binResults);
    $isEu = isEu($r->country->alpha2);


    if(isset($rates[$jsonRow->currency])){
        $rate = $rates[$jsonRow->currency];
    }else{
        $rate = null;
    }

    if ($jsonRow->currency == 'EUR' or $rate == 0) {
        $amntFixed = $jsonRow->amount;
    }
    if ($jsonRow->currency != 'EUR' or $rate > 0) {
        // possibility of divided by zero
        $amntFixed = $jsonRow->amount / $rate;
    }

    // reduced unnecessary comparison
    //    ceil commissions by cents
    $result = round(
        $amntFixed * ($isEu ? 0.01 : 0.02),
        2 // For example, 0.46180... should become 0.47, means two digit
    );

    echo $result;

    // PHP_EOL is more safe than "\n"
    print PHP_EOL;
}

// returning  boolean
function isEu($c) {
    switch($c) {
        case 'AT':
        case 'BE':
        case 'BG':
        case 'CY':
        case 'CZ':
        case 'DE':
        case 'DK':
        case 'EE':
        case 'ES':
        case 'FI':
        case 'FR':
        case 'GR':
        case 'HR':
        case 'HU':
        case 'IE':
        case 'IT':
        case 'LT':
        case 'LU':
        case 'LV':
        case 'MT':
        case 'NL':
        case 'PO':
        case 'PT':
        case 'RO':
        case 'SE':
        case 'SI':
        case 'SK':
            return true;
        default:
            return false;
    }
}