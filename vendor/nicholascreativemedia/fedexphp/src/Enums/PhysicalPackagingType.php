<?php

namespace NicholasCreativeMedia\FedExPHP\Enums;

/**
 * This class stands for PhysicalPackagingType Enums
 * Meta informations extracted from the WSDL
 * - documentation: This enumeration rationalizes the former FedEx Express international "admissibility package" types (based on ANSI X.12) and the FedEx Freight packaging types. The values represented are those common to both carriers.
 * @subpackage Enumerations
 */
class PhysicalPackagingType
{
    /**
     * Constant for value 'BAG'
     * @return string 'BAG'
     */
    const VALUE_BAG = 'BAG';
    /**
     * Constant for value 'BARREL'
     * @return string 'BARREL'
     */
    const VALUE_BARREL = 'BARREL';
    /**
     * Constant for value 'BASKET'
     * @return string 'BASKET'
     */
    const VALUE_BASKET = 'BASKET';
    /**
     * Constant for value 'BOX'
     * @return string 'BOX'
     */
    const VALUE_BOX = 'BOX';
    /**
     * Constant for value 'BUCKET'
     * @return string 'BUCKET'
     */
    const VALUE_BUCKET = 'BUCKET';
    /**
     * Constant for value 'BUNDLE'
     * @return string 'BUNDLE'
     */
    const VALUE_BUNDLE = 'BUNDLE';
    /**
     * Constant for value 'CAGE'
     * @return string 'CAGE'
     */
    const VALUE_CAGE = 'CAGE';
    /**
     * Constant for value 'CARTON'
     * @return string 'CARTON'
     */
    const VALUE_CARTON = 'CARTON';
    /**
     * Constant for value 'CASE'
     * @return string 'CASE'
     */
    const VALUE_CASE = 'CASE';
    /**
     * Constant for value 'CHEST'
     * @return string 'CHEST'
     */
    const VALUE_CHEST = 'CHEST';
    /**
     * Constant for value 'CONTAINER'
     * @return string 'CONTAINER'
     */
    const VALUE_CONTAINER = 'CONTAINER';
    /**
     * Constant for value 'CRATE'
     * @return string 'CRATE'
     */
    const VALUE_CRATE = 'CRATE';
    /**
     * Constant for value 'CYLINDER'
     * @return string 'CYLINDER'
     */
    const VALUE_CYLINDER = 'CYLINDER';
    /**
     * Constant for value 'DRUM'
     * @return string 'DRUM'
     */
    const VALUE_DRUM = 'DRUM';
    /**
     * Constant for value 'ENVELOPE'
     * @return string 'ENVELOPE'
     */
    const VALUE_ENVELOPE = 'ENVELOPE';
    /**
     * Constant for value 'HAMPER'
     * @return string 'HAMPER'
     */
    const VALUE_HAMPER = 'HAMPER';
    /**
     * Constant for value 'OTHER'
     * @return string 'OTHER'
     */
    const VALUE_OTHER = 'OTHER';
    /**
     * Constant for value 'PACKAGE'
     * @return string 'PACKAGE'
     */
    const VALUE_PACKAGE = 'PACKAGE';
    /**
     * Constant for value 'PAIL'
     * @return string 'PAIL'
     */
    const VALUE_PAIL = 'PAIL';
    /**
     * Constant for value 'PALLET'
     * @return string 'PALLET'
     */
    const VALUE_PALLET = 'PALLET';
    /**
     * Constant for value 'PARCEL'
     * @return string 'PARCEL'
     */
    const VALUE_PARCEL = 'PARCEL';
    /**
     * Constant for value 'PIECE'
     * @return string 'PIECE'
     */
    const VALUE_PIECE = 'PIECE';
    /**
     * Constant for value 'REEL'
     * @return string 'REEL'
     */
    const VALUE_REEL = 'REEL';
    /**
     * Constant for value 'ROLL'
     * @return string 'ROLL'
     */
    const VALUE_ROLL = 'ROLL';
    /**
     * Constant for value 'SACK'
     * @return string 'SACK'
     */
    const VALUE_SACK = 'SACK';
    /**
     * Constant for value 'SHRINK_WRAPPED'
     * @return string 'SHRINK_WRAPPED'
     */
    const VALUE_SHRINK_WRAPPED = 'SHRINK_WRAPPED';
    /**
     * Constant for value 'SKID'
     * @return string 'SKID'
     */
    const VALUE_SKID = 'SKID';
    /**
     * Constant for value 'TANK'
     * @return string 'TANK'
     */
    const VALUE_TANK = 'TANK';
    /**
     * Constant for value 'TOTE_BIN'
     * @return string 'TOTE_BIN'
     */
    const VALUE_TOTE_BIN = 'TOTE_BIN';
    /**
     * Constant for value 'TUBE'
     * @return string 'TUBE'
     */
    const VALUE_TUBE = 'TUBE';
    /**
     * Constant for value 'UNIT'
     * @return string 'UNIT'
     */
    const VALUE_UNIT = 'UNIT';
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
     * @uses self::VALUE_BAG
     * @uses self::VALUE_BARREL
     * @uses self::VALUE_BASKET
     * @uses self::VALUE_BOX
     * @uses self::VALUE_BUCKET
     * @uses self::VALUE_BUNDLE
     * @uses self::VALUE_CAGE
     * @uses self::VALUE_CARTON
     * @uses self::VALUE_CASE
     * @uses self::VALUE_CHEST
     * @uses self::VALUE_CONTAINER
     * @uses self::VALUE_CRATE
     * @uses self::VALUE_CYLINDER
     * @uses self::VALUE_DRUM
     * @uses self::VALUE_ENVELOPE
     * @uses self::VALUE_HAMPER
     * @uses self::VALUE_OTHER
     * @uses self::VALUE_PACKAGE
     * @uses self::VALUE_PAIL
     * @uses self::VALUE_PALLET
     * @uses self::VALUE_PARCEL
     * @uses self::VALUE_PIECE
     * @uses self::VALUE_REEL
     * @uses self::VALUE_ROLL
     * @uses self::VALUE_SACK
     * @uses self::VALUE_SHRINK_WRAPPED
     * @uses self::VALUE_SKID
     * @uses self::VALUE_TANK
     * @uses self::VALUE_TOTE_BIN
     * @uses self::VALUE_TUBE
     * @uses self::VALUE_UNIT
     * @return string[]
     */
    public static function getValidValues()
    {
        return array(
            self::VALUE_BAG,
            self::VALUE_BARREL,
            self::VALUE_BASKET,
            self::VALUE_BOX,
            self::VALUE_BUCKET,
            self::VALUE_BUNDLE,
            self::VALUE_CAGE,
            self::VALUE_CARTON,
            self::VALUE_CASE,
            self::VALUE_CHEST,
            self::VALUE_CONTAINER,
            self::VALUE_CRATE,
            self::VALUE_CYLINDER,
            self::VALUE_DRUM,
            self::VALUE_ENVELOPE,
            self::VALUE_HAMPER,
            self::VALUE_OTHER,
            self::VALUE_PACKAGE,
            self::VALUE_PAIL,
            self::VALUE_PALLET,
            self::VALUE_PARCEL,
            self::VALUE_PIECE,
            self::VALUE_REEL,
            self::VALUE_ROLL,
            self::VALUE_SACK,
            self::VALUE_SHRINK_WRAPPED,
            self::VALUE_SKID,
            self::VALUE_TANK,
            self::VALUE_TOTE_BIN,
            self::VALUE_TUBE,
            self::VALUE_UNIT,
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
