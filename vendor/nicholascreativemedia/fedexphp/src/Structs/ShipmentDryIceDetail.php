<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ShipmentDryIceDetail Structs
 * Meta informations extracted from the WSDL
 * - documentation: Shipment-level totals of dry ice data across all packages.
 * @subpackage Structs
 */
class ShipmentDryIceDetail extends AbstractStructBase
{
    /**
     * The PackageCount
     * Meta informations extracted from the WSDL
     * - documentation: Total number of packages in the shipment that contain dry ice.
     * - minOccurs: 1
     * @var int
     */
    public $PackageCount;
    /**
     * The TotalWeight
     * Meta informations extracted from the WSDL
     * - documentation: Total shipment dry ice weight for all packages.
     * - minOccurs: 1
     * @var \NicholasCreativeMedia\FedExPHP\Structs\Weight
     */
    public $TotalWeight;
    /**
     * The ProcessingOptions
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\ShipmentDryIceProcessingOptionsRequested
     */
    public $ProcessingOptions;
    /**
     * Constructor method for ShipmentDryIceDetail
     * @uses ShipmentDryIceDetail::setPackageCount()
     * @uses ShipmentDryIceDetail::setTotalWeight()
     * @uses ShipmentDryIceDetail::setProcessingOptions()
     * @param int $packageCount
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Weight $totalWeight
     * @param \NicholasCreativeMedia\FedExPHP\Structs\ShipmentDryIceProcessingOptionsRequested $processingOptions
     */
    public function __construct($packageCount = null, \NicholasCreativeMedia\FedExPHP\Structs\Weight $totalWeight = null, \NicholasCreativeMedia\FedExPHP\Structs\ShipmentDryIceProcessingOptionsRequested $processingOptions = null)
    {
        $this
            ->setPackageCount($packageCount)
            ->setTotalWeight($totalWeight)
            ->setProcessingOptions($processingOptions);
    }
    /**
     * Get PackageCount value
     * @return int
     */
    public function getPackageCount()
    {
        return $this->PackageCount;
    }
    /**
     * Set PackageCount value
     * @param int $packageCount
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ShipmentDryIceDetail
     */
    public function setPackageCount($packageCount = null)
    {
        // validation for constraint: int
        if (!is_null($packageCount) && !is_numeric($packageCount)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a numeric value, "%s" given', gettype($packageCount)), __LINE__);
        }
        $this->PackageCount = $packageCount;
        return $this;
    }
    /**
     * Get TotalWeight value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Weight
     */
    public function getTotalWeight()
    {
        return $this->TotalWeight;
    }
    /**
     * Set TotalWeight value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Weight $totalWeight
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ShipmentDryIceDetail
     */
    public function setTotalWeight(\NicholasCreativeMedia\FedExPHP\Structs\Weight $totalWeight = null)
    {
        $this->TotalWeight = $totalWeight;
        return $this;
    }
    /**
     * Get ProcessingOptions value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ShipmentDryIceProcessingOptionsRequested|null
     */
    public function getProcessingOptions()
    {
        return $this->ProcessingOptions;
    }
    /**
     * Set ProcessingOptions value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\ShipmentDryIceProcessingOptionsRequested $processingOptions
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ShipmentDryIceDetail
     */
    public function setProcessingOptions(\NicholasCreativeMedia\FedExPHP\Structs\ShipmentDryIceProcessingOptionsRequested $processingOptions = null)
    {
        $this->ProcessingOptions = $processingOptions;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ShipmentDryIceDetail
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
