<?php
$list = [];
$n = 0;
for ($i = 0; $i < 100; $i ++) {
    $n += mt_rand(1, 2);
    $list[] = $n;
}

/**
 * 二分查找
 * 简单二分查找，没有重复数值
 * @param $list
 * @param $value
 * @return int
 */
function binarySearch($list, $value) {
    $low = 0;
    $high = count($list) - 1;
    while ($low <= $high) {
        $middle = $low + (($high - $low) >> 1);
        $middleValue = $list[$middle];
        if ($middleValue < $value) {
            $low = $middle + 1;
        } elseif ($middleValue > $value) {
            $high = $middle - 1;
        } else {
            return $middle;
        }
    }
    return false;
}

end($list);
$value = mt_rand(0, current($list));
echo "search value {$value}\n";
$index = binarySearch($list, $value);
if ($index !== false) {
    printf('find out index %d' . "\n", $index);
    print_r($list);
} else {
    echo "no matched value in list\n";
}


echo 'binary search first:';
$listA = [1, 2, 3, 4, 5, 6, 8, 8, 8, 20];
// 查找第一个匹配的数字
function binarySearchFirst($list, $value) {
    $low = 0;
    $high = count($list) - 1;
    while ($low <= $high) {
        $middle = $low + (($high - $low) >> 1);
        $middleValue = $list[$middle];
        if ($middleValue > $value) {
            $high = $middleValue - 1;
        } elseif ($middleValue < $value) {
            $low = $middleValue + 1;
        } else {
            if ($middle > 0 && $list[$middle - 1] == $value) {
                $high = $middle - 1;
            }
            else {
                return $middle;
            }
        }
    }
    return false;
}
$index = binarySearchFirst($listA, 8);
var_dump($index);

echo 'binary search last:';
// 查找最后一个匹配的数字
function binarySearchLast($list, $value) {
    $low = 0;
    $high = count($list) - 1;
    while ($low <= $high) {
        $middle = $low + (($high - $low) >> 1);
        $middleValue = $list[$middle];
        if ($middleValue > $value) {
            $high = $middle - 1;
        } elseif ($middleValue < $value) {
            $low = $middle + 1;
        } else {
            if ($middle < $high && $list[$middle + 1] == $value) {
                $low = $middle + 1;
            } else {
                return $middle;
            }
        }
    }
    return false;
}
$index = binarySearchLast($listA, 8);
var_dump($index);

echo 'binary search first elt value:';
// 判断临界值的上一个值是不是大于查找值
// 1 2 3 4 5 7 8 8 10 查找6，当找到5时，判断5的后一个数是不是大于6
function binarySearchFirstElt($list, $value) {
    $low = 0;
    $high = count($list) - 1;
    while ($low <= $high) {
        $middle = $low + (($high - $low) >> 1);
        $middleValue = $list[$middle];
        if ($middleValue <= $value) {
            if ($middle == count($list) - 1 || $list[$middle + 1] > $value) {
                return $middle;
            } else {
                $low = $middle + 1;
            }
        } else {
            $high = $middle - 1;
        }
    }
    return false;
}
var_dump(binarySearchFirstElt($listA, 7));


echo 'binary search first egt value:';
// 判断临界值的上一个值是否小于查找值
// 1 2 3 4 5 7 8 8 10 查找6，当找到7时，判断7的前一个数是不是小于6
function binarySearchFirstEgt($list, $value) {
    $low = 0;
    $high = count($list) - 1;
    while ($low <= $high) {
        $middle = $low + (($high - $low) >> 1);
        $middleValue = $list[$middle];
        if ($middleValue >= $value) {
            if ($middle == $low || $list[$middle - 1] < $value) {
                return $middle;
            } else {
                $high = $middle - 1;
            }
        } else {
            $low = $middle + 1;
        }
    }
    return false;
}
var_dump(binarySearchFirstEgt($listA, 7)); 
