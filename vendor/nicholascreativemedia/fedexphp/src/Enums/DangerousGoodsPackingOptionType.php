<?php

namespace NicholasCreativeMedia\FedExPHP\Enums;

/**
 * This class stands for DangerousGoodsPackingOptionType Enums
 * @subpackage Enumerations
 */
class DangerousGoodsPackingOptionType
{
    /**
     * Constant for value 'OVERPACK'
     * @return string 'OVERPACK'
     */
    const VALUE_OVERPACK = 'OVERPACK';
    /**
     * Return true if value is allowed
     * @uses self::getValidValues()
     * @param mixed $value value
     * @return bool true|false
     */
    public static function valueIsValid($value)
    {
        return ($value === null) || in_array($value, self::getValidValues(), true);
    }
    /**
     * Return allowed values
     * @uses self::VALUE_OVERPACK
     * @return string[]
     */
    public static function getValidValues()
    {
        return array(
            self::VALUE_OVERPACK,
        );
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
