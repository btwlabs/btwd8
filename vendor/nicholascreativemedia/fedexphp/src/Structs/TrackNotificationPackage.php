<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for TrackNotificationPackage Structs
 * @subpackage Structs
 */
class TrackNotificationPackage extends AbstractStructBase
{
    /**
     * The TrackingNumber
     * Meta informations extracted from the WSDL
     * - documentation: FedEx assigned identifier for a package/shipment.
     * - minOccurs: 0
     * @var string
     */
    public $TrackingNumber;
    /**
     * The TrackingNumberUniqueIdentifiers
     * Meta informations extracted from the WSDL
     * - documentation: When duplicate tracking numbers exist this data is returned with summary information for each of the duplicates. The summary information is used to determine which of the duplicates the intended tracking number is. This identifier is
     * used on a subsequent track request to retrieve the tracking data for the desired tracking number.
     * - minOccurs: 0
     * @var string
     */
    public $TrackingNumberUniqueIdentifiers;
    /**
     * The CarrierCode
     * Meta informations extracted from the WSDL
     * - documentation: Identification of a FedEx operating company (transportation).
     * - minOccurs: 0
     * @var string
     */
    public $CarrierCode;
    /**
     * The ShipDate
     * Meta informations extracted from the WSDL
     * - documentation: The date the package was shipped (tendered to FedEx).
     * - minOccurs: 0
     * @var string
     */
    public $ShipDate;
    /**
     * The Destination
     * Meta informations extracted from the WSDL
     * - documentation: The destination address of this package. Only city, state/province, and country are returned.
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\Address
     */
    public $Destination;
    /**
     * The RecipientDetails
     * Meta informations extracted from the WSDL
     * - documentation: Options available for a tracking notification recipient.
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationRecipientDetail[]
     */
    public $RecipientDetails;
    /**
     * Constructor method for TrackNotificationPackage
     * @uses TrackNotificationPackage::setTrackingNumber()
     * @uses TrackNotificationPackage::setTrackingNumberUniqueIdentifiers()
     * @uses TrackNotificationPackage::setCarrierCode()
     * @uses TrackNotificationPackage::setShipDate()
     * @uses TrackNotificationPackage::setDestination()
     * @uses TrackNotificationPackage::setRecipientDetails()
     * @param string $trackingNumber
     * @param string $trackingNumberUniqueIdentifiers
     * @param string $carrierCode
     * @param string $shipDate
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Address $destination
     * @param \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationRecipientDetail[] $recipientDetails
     */
    public function __construct($trackingNumber = null, $trackingNumberUniqueIdentifiers = null, $carrierCode = null, $shipDate = null, \NicholasCreativeMedia\FedExPHP\Structs\Address $destination = null, array $recipientDetails = array())
    {
        $this
            ->setTrackingNumber($trackingNumber)
            ->setTrackingNumberUniqueIdentifiers($trackingNumberUniqueIdentifiers)
            ->setCarrierCode($carrierCode)
            ->setShipDate($shipDate)
            ->setDestination($destination)
            ->setRecipientDetails($recipientDetails);
    }
    /**
     * Get TrackingNumber value
     * @return string|null
     */
    public function getTrackingNumber()
    {
        return $this->TrackingNumber;
    }
    /**
     * Set TrackingNumber value
     * @param string $trackingNumber
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationPackage
     */
    public function setTrackingNumber($trackingNumber = null)
    {
        // validation for constraint: string
        if (!is_null($trackingNumber) && !is_string($trackingNumber)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($trackingNumber)), __LINE__);
        }
        $this->TrackingNumber = $trackingNumber;
        return $this;
    }
    /**
     * Get TrackingNumberUniqueIdentifiers value
     * @return string|null
     */
    public function getTrackingNumberUniqueIdentifiers()
    {
        return $this->TrackingNumberUniqueIdentifiers;
    }
    /**
     * Set TrackingNumberUniqueIdentifiers value
     * @param string $trackingNumberUniqueIdentifiers
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationPackage
     */
    public function setTrackingNumberUniqueIdentifiers($trackingNumberUniqueIdentifiers = null)
    {
        // validation for constraint: string
        if (!is_null($trackingNumberUniqueIdentifiers) && !is_string($trackingNumberUniqueIdentifiers)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($trackingNumberUniqueIdentifiers)), __LINE__);
        }
        $this->TrackingNumberUniqueIdentifiers = $trackingNumberUniqueIdentifiers;
        return $this;
    }
    /**
     * Get CarrierCode value
     * @return string|null
     */
    public function getCarrierCode()
    {
        return $this->CarrierCode;
    }
    /**
     * Set CarrierCode value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\CarrierCodeType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\CarrierCodeType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $carrierCode
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationPackage
     */
    public function setCarrierCode($carrierCode = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\CarrierCodeType::valueIsValid($carrierCode)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $carrierCode, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\CarrierCodeType::getValidValues())), __LINE__);
        }
        $this->CarrierCode = $carrierCode;
        return $this;
    }
    /**
     * Get ShipDate value
     * @return string|null
     */
    public function getShipDate()
    {
        return $this->ShipDate;
    }
    /**
     * Set ShipDate value
     * @param string $shipDate
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationPackage
     */
    public function setShipDate($shipDate = null)
    {
        // validation for constraint: string
        if (!is_null($shipDate) && !is_string($shipDate)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($shipDate)), __LINE__);
        }
        $this->ShipDate = $shipDate;
        return $this;
    }
    /**
     * Get Destination value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Address|null
     */
    public function getDestination()
    {
        return $this->Destination;
    }
    /**
     * Set Destination value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Address $destination
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationPackage
     */
    public function setDestination(\NicholasCreativeMedia\FedExPHP\Structs\Address $destination = null)
    {
        $this->Destination = $destination;
        return $this;
    }
    /**
     * Get RecipientDetails value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationRecipientDetail[]|null
     */
    public function getRecipientDetails()
    {
        return $this->RecipientDetails;
    }
    /**
     * Set RecipientDetails value
     * @throws \InvalidArgumentException
     * @param \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationRecipientDetail[] $recipientDetails
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationPackage
     */
    public function setRecipientDetails(array $recipientDetails = array())
    {
        foreach ($recipientDetails as $trackNotificationPackageRecipientDetailsItem) {
            // validation for constraint: itemType
            if (!$trackNotificationPackageRecipientDetailsItem instanceof \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationRecipientDetail) {
                throw new \InvalidArgumentException(sprintf('The RecipientDetails property can only contain items of \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationRecipientDetail, "%s" given', is_object($trackNotificationPackageRecipientDetailsItem) ? get_class($trackNotificationPackageRecipientDetailsItem) : gettype($trackNotificationPackageRecipientDetailsItem)), __LINE__);
            }
        }
        $this->RecipientDetails = $recipientDetails;
        return $this;
    }
    /**
     * Add item to RecipientDetails value
     * @throws \InvalidArgumentException
     * @param \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationRecipientDetail $item
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationPackage
     */
    public function addToRecipientDetails(\NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationRecipientDetail $item)
    {
        // validation for constraint: itemType
        if (!$item instanceof \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationRecipientDetail) {
            throw new \InvalidArgumentException(sprintf('The RecipientDetails property can only contain items of \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationRecipientDetail, "%s" given', is_object($item) ? get_class($item) : gettype($item)), __LINE__);
        }
        $this->RecipientDetails[] = $item;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackNotificationPackage
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
