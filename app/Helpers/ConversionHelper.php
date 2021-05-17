<?php 
namespace App\Helpers;

class ConversionHelper
{
    public static function heightToInches($height)
    {
        if(in_array($height, [NULL, "\N", ""]) || empty($height)) return NULL;

        if(strpos($height, "-") === NULL) return NULL;

        list($feet, $inches) = explode("-", $height);

        return ($feet * 12) + $inches;
    }
}