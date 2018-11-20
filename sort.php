<?php
function countSort($string) {
    $length = strlen($string);
    $min = null;
    $max = null;
    for ($i = 0; $i < $length; $i ++) {
        $n = (int) $string[$i];
        if ($min === null || $min > $n) {
            $min = $n;
        }
        if ($max === null || $max < $n) {
            $max = $n;
        }
    }
    $array = array_fill(0, $max, 0);
    for ($i = 0; $i < $length; $i ++) {
        $n = (int) $string[$i];
        $index = $n - $min;
        $array[$index] ++;
    }
    $newString = '';
    foreach ($array as $number => $count) {
        if ($count) {
            $newString .= str_repeat($number + $min, $count);
        }
    }
    return $newString;
}
var_dump($stringNumber);
var_dump(countSort($stringNumber));
