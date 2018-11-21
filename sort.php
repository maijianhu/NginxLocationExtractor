<?php
$string = '1gs36dxaa6AfsdxZasd3';

function swap(&$string, $i, $j) {
    $temp = $string[$i];
    $string[$i] = $string[$j];
    $string[$j] = $temp;
}

/**
 * 冒泡排序
 * $i值保证循环n次，$j值负责从头开始把最高值挪动到最后的位置，并重新标记最后的位置
 * @param string $string
 * @return string
 */
function bubbleSort($string) {
    $length = strlen($string);
    for ($i = 0; $i < $length; $i ++) {
        for ($j = 0; $j < $length - $i -1; $j ++) {
            if ($string[$j] > $string[$j+1]) {
                swap($string, $j, $j + 1);
            }
        }
    }
    return $string;
}
var_dump(bubbleSort($string));

/**
 * 快速排序
 * 快排是递归排序，基准值为准，分左右组，直到递归退出条件满足
 * 应首先推导退出条件，然后执行排序逻辑
 * @param string $string
 * @return string
 */
function quickSort($string) {
    $length = strlen($string);
    if ($length <= 1) {
        return $string;
    }

    $pivot = $string[0];
    $left = $right = '';
    for ($i = 1; $i < $length; $i ++) {
        $string[$i] < $pivot ? ($left .= $string[$i]) : ($right .= $string[$i]);
    }
    return quickSort($left) . $pivot . quickSort($right);
}
var_dump(quickSort($string));

/**
 * 插入排序
 * 左手拿牌，第一张，第二张，第三张...
 * 3=>35=>345=>1345=>12345=>123456
 * @param string $string
 * @return string
 */
function insertionSort($string) {
    $length = strlen($string);
    for ($i = 1; $i < $length; $i ++) {
        $j = $i;
        while ($j > 0 && $string[$j-1] > $string[$j]) {
            swap($string, $j, $j - 1);
            $j --;
        }
    }
    return $string;
}
var_dump(insertionSort($string));

/**
 * 选择排序
 * 为第一个位置选择一个最小值，为第二个位置选择一个小最值...
 * @param string $string
 * @return string
 */
function selectionSort($string) {
    $length = strlen($string);
    for ($i = 0; $i < $length; $i ++) {
        $min = $i;
        for ($j = $i + 1; $j < $length; $j ++) {
            if ($string[$j] < $string[$min]) {
                $min = $j;
            }
        }
        swap($string, $i, $min);
    }
    return $string;
}
var_dump(selectionSort($string));


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
