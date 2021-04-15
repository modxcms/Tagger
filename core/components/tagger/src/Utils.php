<?php
namespace Tagger;

class Utils {
    public static function cleanAndImplode($array, $delimiter = ',')
    {
        $array = array_map('trim', $array);       // Trim array's values
        $array = array_keys(array_flip($array));  // Remove duplicate fields
        $array = array_filter($array);            // Remove empty values from array
        $array = implode($delimiter, $array);

        return $array;
    }

    public static function explodeAndClean($array, $delimiter = ',', $keepZero = false)
    {
        $array = explode($delimiter, $array);           // Explode fields to array
        $array = array_map('trim', $array);             // Trim array's values
        $array = array_keys(array_flip($array));        // Remove duplicate fields

        if ($keepZero === false) {
            $array = array_filter($array);              // Remove empty values from array
        } else {
            $array = array_filter(
                $array,
                function ($value) {
                    return $value !== '';
                }
            );
        }

        return $array;
    }
}
