<?php

function sortByKeyRecursive(array $array): array
{
    ksort($array, SORT_STRING);
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = sortByKeyRecursive($value);
        }
    }
    return $array;
}

function implodeRecursive(string $separator, array $array): string
{
    $result = '';
    foreach ($array as $item) {
        $result .= (is_array($item) ? implodeRecursive($separator, $item) : (string)$item) . $separator;
    }

    return substr($result, 0, -1);
}

$dataSet = [
    "ik_co_id" => "5ee0c9ccc3f73b75f5236a99",
    "ik_pm_no" => "ID_4233",
    "ik_am" => "10.06",
    "ik_cur" => "UAH",
    "ik_desc" => "test",
    "ik_payway_fields" => [
        'field' => '2nd',
        'zields' => '3rd',
        'af' => '1st'
    ]
];

$checkoutKey = "IAzk63hCGbgZHuix"; //Checkout Secret Key
$sortedDataByKeys = sortByKeyRecursive($dataSet); //Sort an array by key recursively
$sortedDataByKeys[] = $checkoutKey; //Add checkout Secret Key to the end of data array

$signString = implodeRecursive(':', $sortedDataByKeys); // Implode array recursively - result: 10.06:5ee0c9ccc3f73b75f5236a99:UAH:test:1st:2nd:3rd:ID_4233:IAzk63hCGbgZHuix
$sign = base64_encode(hash('sha256', $signString, true)); // Result Hash: SHxLf/PR2Wzl7u4GaYnE+3ZLzuiLW3yCm5T7sBpGRzU=
