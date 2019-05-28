<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for PendingShipmentAccessDetail Structs
 * Meta informations extracted from the WSDL
 * - documentation: This information describes how and when a pending shipment may be accessed for completion.
 * @subpackage Structs
 */
class PendingShipmentAccessDetail extends AbstractStructBase
{
    /**
     * The AccessorDetails
     * Meta informations extracted from the WSDL
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessorDetail[]
     */
    public $AccessorDetails;
    /**
     * Constructor method for PendingShipmentAccessDetail
     * @uses PendingShipmentAccessDetail::setAccessorDetails()
     * @param \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessorDetail[] $accessorDetails
     */
    public function __construct(array $accessorDetails = array())
    {
        $this
            ->setAccessorDetails($accessorDetails);
    }
    /**
     * Get AccessorDetails value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessorDetail[]|null
     */
    public function getAccessorDetails()
    {
        return $this->AccessorDetails;
    }
    /**
     * Set AccessorDetails value
     * @throws \InvalidArgumentException
     * @param \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessorDetail[] $accessorDetails
     * @return \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessDetail
     */
    public function setAccessorDetails(array $accessorDetails = array())
    {
        foreach ($accessorDetails as $pendingShipmentAccessDetailAccessorDetailsItem) {
            // validation for constraint: itemType
            if (!$pendingShipmentAccessDetailAccessorDetailsItem instanceof \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessorDetail) {
                throw new \InvalidArgumentException(sprintf('The AccessorDetails property can only contain items of \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessorDetail, "%s" given', is_object($pendingShipmentAccessDetailAccessorDetailsItem) ? get_class($pendingShipmentAccessDetailAccessorDetailsItem) : gettype($pendingShipmentAccessDetailAccessorDetailsItem)), __LINE__);
            }
        }
        $this->AccessorDetails = $accessorDetails;
        return $this;
    }
    /**
     * Add item to AccessorDetails value
     * @throws \InvalidArgumentException
     * @param \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessorDetail $item
     * @return \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessDetail
     */
    public function addToAccessorDetails(\NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessorDetail $item)
    {
        // validation for constraint: itemType
        if (!$item instanceof \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessorDetail) {
            throw new \InvalidArgumentException(sprintf('The AccessorDetails property can only contain items of \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessorDetail, "%s" given', is_object($item) ? get_class($item) : gettype($item)), __LINE__);
        }
        $this->AccessorDetails[] = $item;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\PendingShipmentAccessDetail
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
