<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for VariableHandlingCharges Structs
 * @subpackage Structs
 */
class VariableHandlingCharges extends AbstractStructBase
{
    /**
     * The VariableHandlingCharge
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\Money
     */
    public $VariableHandlingCharge;
    /**
     * The FixedVariableHandlingCharge
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\Money
     */
    public $FixedVariableHandlingCharge;
    /**
     * The PercentVariableHandlingCharge
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\Money
     */
    public $PercentVariableHandlingCharge;
    /**
     * The TotalCustomerCharge
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\Money
     */
    public $TotalCustomerCharge;
    /**
     * Constructor method for VariableHandlingCharges
     * @uses VariableHandlingCharges::setVariableHandlingCharge()
     * @uses VariableHandlingCharges::setFixedVariableHandlingCharge()
     * @uses VariableHandlingCharges::setPercentVariableHandlingCharge()
     * @uses VariableHandlingCharges::setTotalCustomerCharge()
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $variableHandlingCharge
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $fixedVariableHandlingCharge
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $percentVariableHandlingCharge
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $totalCustomerCharge
     */
    public function __construct(\NicholasCreativeMedia\FedExPHP\Structs\Money $variableHandlingCharge = null, \NicholasCreativeMedia\FedExPHP\Structs\Money $fixedVariableHandlingCharge = null, \NicholasCreativeMedia\FedExPHP\Structs\Money $percentVariableHandlingCharge = null, \NicholasCreativeMedia\FedExPHP\Structs\Money $totalCustomerCharge = null)
    {
        $this
            ->setVariableHandlingCharge($variableHandlingCharge)
            ->setFixedVariableHandlingCharge($fixedVariableHandlingCharge)
            ->setPercentVariableHandlingCharge($percentVariableHandlingCharge)
            ->setTotalCustomerCharge($totalCustomerCharge);
    }
    /**
     * Get VariableHandlingCharge value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Money|null
     */
    public function getVariableHandlingCharge()
    {
        return $this->VariableHandlingCharge;
    }
    /**
     * Set VariableHandlingCharge value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $variableHandlingCharge
     * @return \NicholasCreativeMedia\FedExPHP\Structs\VariableHandlingCharges
     */
    public function setVariableHandlingCharge(\NicholasCreativeMedia\FedExPHP\Structs\Money $variableHandlingCharge = null)
    {
        $this->VariableHandlingCharge = $variableHandlingCharge;
        return $this;
    }
    /**
     * Get FixedVariableHandlingCharge value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Money|null
     */
    public function getFixedVariableHandlingCharge()
    {
        return $this->FixedVariableHandlingCharge;
    }
    /**
     * Set FixedVariableHandlingCharge value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $fixedVariableHandlingCharge
     * @return \NicholasCreativeMedia\FedExPHP\Structs\VariableHandlingCharges
     */
    public function setFixedVariableHandlingCharge(\NicholasCreativeMedia\FedExPHP\Structs\Money $fixedVariableHandlingCharge = null)
    {
        $this->FixedVariableHandlingCharge = $fixedVariableHandlingCharge;
        return $this;
    }
    /**
     * Get PercentVariableHandlingCharge value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Money|null
     */
    public function getPercentVariableHandlingCharge()
    {
        return $this->PercentVariableHandlingCharge;
    }
    /**
     * Set PercentVariableHandlingCharge value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $percentVariableHandlingCharge
     * @return \NicholasCreativeMedia\FedExPHP\Structs\VariableHandlingCharges
     */
    public function setPercentVariableHandlingCharge(\NicholasCreativeMedia\FedExPHP\Structs\Money $percentVariableHandlingCharge = null)
    {
        $this->PercentVariableHandlingCharge = $percentVariableHandlingCharge;
        return $this;
    }
    /**
     * Get TotalCustomerCharge value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Money|null
     */
    public function getTotalCustomerCharge()
    {
        return $this->TotalCustomerCharge;
    }
    /**
     * Set TotalCustomerCharge value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $totalCustomerCharge
     * @return \NicholasCreativeMedia\FedExPHP\Structs\VariableHandlingCharges
     */
    public function setTotalCustomerCharge(\NicholasCreativeMedia\FedExPHP\Structs\Money $totalCustomerCharge = null)
    {
        $this->TotalCustomerCharge = $totalCustomerCharge;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\VariableHandlingCharges
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
