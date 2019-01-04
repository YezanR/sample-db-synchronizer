<?php

namespace App\Utils;

class ArrayUtils
{
    public static function arrayToBracketsString(array $array)
    {
        $length = count($array);
        $result = '(';
        foreach ($array as $index => $elt) {
            $result .= $elt;
            if ($index < $length - 1) {
                $result .= ', ';
            }
        }
        $result .= ')';

        return $result;
    }
}