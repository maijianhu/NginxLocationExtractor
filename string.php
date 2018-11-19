<?php
/**
 * 一个文本串，替换字符，将hello_world_how_are_you，替换为helloWorldHowAreYou
 */

$string = 'hello______how_______are________you';
function transform($string) {
    $length = strlen($string);
    $pos = 0;
    while ($pos < $length) {
        if ($string[$pos] === '_' && $string[$pos+1]) {
            $char = $string[$pos+1];
            if ($char >= 'a' && $char <= 'z') {
                $char = strtoupper($char);
                $string[$pos] = $char;
                $string = substr($string, 0, $pos) . $char . substr($string, $pos + 2);
                $length --;
            }
        }
        $pos ++;
    }
    return $string;
}
var_dump(transform($string));

function transformByRe($string) {
    return preg_replace_callback('/_(?<char>[a-z])/', function($match) {
        return strtoupper($match['char']);
    }, $string);
}
var_dump(transformByRe($string));

/**
 * 将一段大写字母转换为小写字母
 */
$string = 'HELLO WORLD! HOW ARE YOU!';
function convert($string) {
	$length = strlen($string);
	for ($i = 0; $i < $length; $i ++) {
		$char = $string[$i];
		$ord = ord($char);
		if ($ord >= 65 && $ord <= 90) {
			$newChar = chr($ord + 32);
			$string[$i] = $newChar;
		}
	}
	return $string;
}
var_dump(convert($string));
