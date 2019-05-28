<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for Weight Structs
 * Meta informations extracted from the WSDL
 * - documentation: The descriptive data for the heaviness of an object.
 * @subpackage Structs
 */
class Weight extends AbstractStructBase
{
    /**
     * The Units
     * Meta informations extracted from the WSDL
     * - documentation: Identifies the unit of measure associated with a weight value.
     * - minOccurs: 0
     * @var string
     */
    public $Units;
    /**
     * The Value
     * Meta informations extracted from the WSDL
     * - documentation: Identifies the weight value of a package/shipment.
     * - minOccurs: 0
     * @var float
     */
    public $Value;
    /**
     * Constructor method for Weight
     * @uses Weight::setUnits()
     * @uses Weight::setValue()
     * @param string $units
     * @param float $value
     */
    public function __construct($units = null, $value = null)
    {
        $this
            ->setUnits($units)
            ->setValue($value);
    }
    /**
     * Get Units value
     * @return string|null
     */
    public function getUnits()
    {
        return $this->Units;
    }
    /**
     * Set Units value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\WeightUnits::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\WeightUnits::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $units
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Weight
     */
    public function setUnits($units = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\WeightUnits::valueIsValid($units)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $units, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\WeightUnits::getValidValues())), __LINE__);
        }
        $this->Units = $units;
        return $this;
    }
    /**
     * Get Value value
     * @return float|null
     */
    public function getValue()
    {
        return $this->Value;
    }
    /**
     * Set Value value
     * @param float $value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Weight
     */
    public function setValue($value = null)
    {
        $this->Value = $value;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Weight
     */
    public static function __set_state(array $array)
    {
        return parent::__set_state($array);
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
