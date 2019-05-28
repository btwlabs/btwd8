<?php

namespace NicholasCreativeMedia\FedExPHP\Enums;

/**
 * This class stands for ShippingDocumentImageType Enums
 * Meta informations extracted from the WSDL
 * - documentation: Specifies the image format used for a shipping document.
 * @subpackage Enumerations
 */
class ShippingDocumentImageType
{
    /**
     * Constant for value 'DOC'
     * @return string 'DOC'
     */
    const VALUE_DOC = 'DOC';
    /**
     * Constant for value 'EPL2'
     * @return string 'EPL2'
     */
    const VALUE_EPL_2 = 'EPL2';
    /**
     * Constant for value 'PDF'
     * @return string 'PDF'
     */
    const VALUE_PDF = 'PDF';
    /**
     * Constant for value 'PNG'
     * @return string 'PNG'
     */
    const VALUE_PNG = 'PNG';
    /**
     * Constant for value 'RTF'
     * @return string 'RTF'
     */
    const VALUE_RTF = 'RTF';
    /**
     * Constant for value 'TEXT'
     * @return string 'TEXT'
     */
    const VALUE_TEXT = 'TEXT';
    /**
     * Constant for value 'ZPLII'
     * @return string 'ZPLII'
     */
    const VALUE_ZPLII = 'ZPLII';
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
     * @uses self::VALUE_DOC
     * @uses self::VALUE_EPL_2
     * @uses self::VALUE_PDF
     * @uses self::VALUE_PNG
     * @uses self::VALUE_RTF
     * @uses self::VALUE_TEXT
     * @uses self::VALUE_ZPLII
     * @return string[]
     */
    public static function getValidValues()
    {
        return array(
            self::VALUE_DOC,
            self::VALUE_EPL_2,
            self::VALUE_PDF,
            self::VALUE_PNG,
            self::VALUE_RTF,
            self::VALUE_TEXT,
            self::VALUE_ZPLII,
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
