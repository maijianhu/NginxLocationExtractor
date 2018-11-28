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
 * 空间复杂度为O(1)的快排算法
 * 每次从高位和低位递进扫描，得到依据轴心值左右排序的结果
 * 下次从轴心位置分开继续快速排序
 * @see https://baike.baidu.com/item/%E5%BF%AB%E9%80%9F%E6%8E%92%E5%BA%8F%E7%AE%97%E6%B3%95
 * @param $string
 * @param $low
 * @param $high
 * @return string
 */
function quickSortX(&$string, $low = null, $high = null) {
    if ($low === null) $low = 0;
    if ($high === null) $high = strlen($string) - 1;

    if ($low >= $high) {
        return null;
    }

    $i = $low;
    $j = $high;

    $pivot = $low;
    while ($i < $j) {
        while ($i < $j && $string[$j] >= $string[$pivot]) {
            $j --;
        }
        if ($j !== $pivot) {
            swap($string, $j, $pivot);
            $pivot = $j;
        }

        while ($i < $j && $string[$i] <= $string[$pivot]) {
            $i ++;
        }
        if ($i !== $pivot) {
            swap($string, $i, $pivot);
            $pivot = $i;
        }
    }

    quickSortX($string, $low, $pivot - 1);
    quickSortX($string, $pivot + 1, $high);
    return $string;
}
$stringCopy = $string;
var_dump(quickSortX($stringCopy));

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

$stringNumber = '55421569878536215489';
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

    $array = array_fill(0, $max + 1, 0);
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
