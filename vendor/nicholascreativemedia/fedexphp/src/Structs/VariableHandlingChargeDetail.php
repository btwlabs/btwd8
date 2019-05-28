<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for VariableHandlingChargeDetail Structs
 * Meta informations extracted from the WSDL
 * - documentation: This definition of variable handling charge detail is intended for use in Jan 2011 corp load.
 * @subpackage Structs
 */
class VariableHandlingChargeDetail extends AbstractStructBase
{
    /**
     * The FixedValue
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\Money
     */
    public $FixedValue;
    /**
     * The PercentValue
     * Meta informations extracted from the WSDL
     * - documentation: Actual percentage (10 means 10%, which is a mutiplier of 0.1)
     * - minOccurs: 0
     * @var float
     */
    public $PercentValue;
    /**
     * The RateElementBasis
     * Meta informations extracted from the WSDL
     * - documentation: Select the value from a set of rate data to which the percentage is applied.
     * - minOccurs: 0
     * @var string
     */
    public $RateElementBasis;
    /**
     * The RateTypeBasis
     * Meta informations extracted from the WSDL
     * - documentation: Select the type of rate from which the element is to be selected.
     * - minOccurs: 0
     * @var string
     */
    public $RateTypeBasis;
    /**
     * Constructor method for VariableHandlingChargeDetail
     * @uses VariableHandlingChargeDetail::setFixedValue()
     * @uses VariableHandlingChargeDetail::setPercentValue()
     * @uses VariableHandlingChargeDetail::setRateElementBasis()
     * @uses VariableHandlingChargeDetail::setRateTypeBasis()
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $fixedValue
     * @param float $percentValue
     * @param string $rateElementBasis
     * @param string $rateTypeBasis
     */
    public function __construct(\NicholasCreativeMedia\FedExPHP\Structs\Money $fixedValue = null, $percentValue = null, $rateElementBasis = null, $rateTypeBasis = null)
    {
        $this
            ->setFixedValue($fixedValue)
            ->setPercentValue($percentValue)
            ->setRateElementBasis($rateElementBasis)
            ->setRateTypeBasis($rateTypeBasis);
    }
    /**
     * Get FixedValue value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Money|null
     */
    public function getFixedValue()
    {
        return $this->FixedValue;
    }
    /**
     * Set FixedValue value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $fixedValue
     * @return \NicholasCreativeMedia\FedExPHP\Structs\VariableHandlingChargeDetail
     */
    public function setFixedValue(\NicholasCreativeMedia\FedExPHP\Structs\Money $fixedValue = null)
    {
        $this->FixedValue = $fixedValue;
        return $this;
    }
    /**
     * Get PercentValue value
     * @return float|null
     */
    public function getPercentValue()
    {
        return $this->PercentValue;
    }
    /**
     * Set PercentValue value
     * @param float $percentValue
     * @return \NicholasCreativeMedia\FedExPHP\Structs\VariableHandlingChargeDetail
     */
    public function setPercentValue($percentValue = null)
    {
        $this->PercentValue = $percentValue;
        return $this;
    }
    /**
     * Get RateElementBasis value
     * @return string|null
     */
    public function getRateElementBasis()
    {
        return $this->RateElementBasis;
    }
    /**
     * Set RateElementBasis value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\RateElementBasisType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\RateElementBasisType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $rateElementBasis
     * @return \NicholasCreativeMedia\FedExPHP\Structs\VariableHandlingChargeDetail
     */
    public function setRateElementBasis($rateElementBasis = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\RateElementBasisType::valueIsValid($rateElementBasis)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $rateElementBasis, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\RateElementBasisType::getValidValues())), __LINE__);
        }
        $this->RateElementBasis = $rateElementBasis;
        return $this;
    }
    /**
     * Get RateTypeBasis value
     * @return string|null
     */
    public function getRateTypeBasis()
    {
        return $this->RateTypeBasis;
    }
    /**
     * Set RateTypeBasis value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\RateTypeBasisType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\RateTypeBasisType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $rateTypeBasis
     * @return \NicholasCreativeMedia\FedExPHP\Structs\VariableHandlingChargeDetail
     */
    public function setRateTypeBasis($rateTypeBasis = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\RateTypeBasisType::valueIsValid($rateTypeBasis)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $rateTypeBasis, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\RateTypeBasisType::getValidValues())), __LINE__);
        }
        $this->RateTypeBasis = $rateTypeBasis;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\VariableHandlingChargeDetail
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
