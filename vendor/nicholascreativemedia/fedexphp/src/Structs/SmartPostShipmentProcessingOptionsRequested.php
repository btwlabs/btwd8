<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for SmartPostShipmentProcessingOptionsRequested Structs
 * @subpackage Structs
 */
class SmartPostShipmentProcessingOptionsRequested extends AbstractStructBase
{
    /**
     * The Options
     * Meta informations extracted from the WSDL
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var string[]
     */
    public $Options;
    /**
     * Constructor method for SmartPostShipmentProcessingOptionsRequested
     * @uses SmartPostShipmentProcessingOptionsRequested::setOptions()
     * @param string[] $options
     */
    public function __construct(array $options = array())
    {
        $this
            ->setOptions($options);
    }
    /**
     * Get Options value
     * @return string[]|null
     */
    public function getOptions()
    {
        return $this->Options;
    }
    /**
     * Set Options value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\SmartPostShipmentProcessingOptionType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\SmartPostShipmentProcessingOptionType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string[] $options
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SmartPostShipmentProcessingOptionsRequested
     */
    public function setOptions(array $options = array())
    {
        $invalidValues = array();
        foreach ($options as $smartPostShipmentProcessingOptionsRequestedOptionsItem) {
            if (!\NicholasCreativeMedia\FedExPHP\Enums\SmartPostShipmentProcessingOptionType::valueIsValid($smartPostShipmentProcessingOptionsRequestedOptionsItem)) {
                $invalidValues[] = var_export($smartPostShipmentProcessingOptionsRequestedOptionsItem);
            }
        }
        if (!empty($invalidValues)) {
            throw new \InvalidArgumentException(sprintf('Value(s) "%s" is/are invalid, please use one of: %s', implode(', ', $invalidValues), implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\SmartPostShipmentProcessingOptionType::getValidValues())), __LINE__);
        }
        $this->Options = $options;
        return $this;
    }
    /**
     * Add item to Options value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\SmartPostShipmentProcessingOptionType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\SmartPostShipmentProcessingOptionType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $item
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SmartPostShipmentProcessingOptionsRequested
     */
    public function addToOptions($item)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\SmartPostShipmentProcessingOptionType::valueIsValid($item)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $item, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\SmartPostShipmentProcessingOptionType::getValidValues())), __LINE__);
        }
        $this->Options[] = $item;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SmartPostShipmentProcessingOptionsRequested
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
