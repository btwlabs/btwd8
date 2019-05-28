<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for CompletedCodDetail Structs
 * Meta informations extracted from the WSDL
 * - documentation: Specifies the results of processing for the COD special service.
 * @subpackage Structs
 */
class CompletedCodDetail extends AbstractStructBase
{
    /**
     * The CollectionAmount
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\Money
     */
    public $CollectionAmount;
    /**
     * The AdjustmentType
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var string
     */
    public $AdjustmentType;
    /**
     * Constructor method for CompletedCodDetail
     * @uses CompletedCodDetail::setCollectionAmount()
     * @uses CompletedCodDetail::setAdjustmentType()
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $collectionAmount
     * @param string $adjustmentType
     */
    public function __construct(\NicholasCreativeMedia\FedExPHP\Structs\Money $collectionAmount = null, $adjustmentType = null)
    {
        $this
            ->setCollectionAmount($collectionAmount)
            ->setAdjustmentType($adjustmentType);
    }
    /**
     * Get CollectionAmount value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Money|null
     */
    public function getCollectionAmount()
    {
        return $this->CollectionAmount;
    }
    /**
     * Set CollectionAmount value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Money $collectionAmount
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedCodDetail
     */
    public function setCollectionAmount(\NicholasCreativeMedia\FedExPHP\Structs\Money $collectionAmount = null)
    {
        $this->CollectionAmount = $collectionAmount;
        return $this;
    }
    /**
     * Get AdjustmentType value
     * @return string|null
     */
    public function getAdjustmentType()
    {
        return $this->AdjustmentType;
    }
    /**
     * Set AdjustmentType value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\CodAdjustmentType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\CodAdjustmentType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $adjustmentType
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedCodDetail
     */
    public function setAdjustmentType($adjustmentType = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\CodAdjustmentType::valueIsValid($adjustmentType)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $adjustmentType, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\CodAdjustmentType::getValidValues())), __LINE__);
        }
        $this->AdjustmentType = $adjustmentType;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedCodDetail
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
