<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for SendNotificationsRequest Structs
 * Meta informations extracted from the WSDL
 * - type: ns:SendNotificationsRequest
 * @subpackage Structs
 */
class SendNotificationsRequest extends AbstractStructBase
{
    /**
     * The WebAuthenticationDetail
     * Meta informations extracted from the WSDL
     * - documentation: Descriptive data to be used in authentication of the sender's identity (and right to use FedEx web services).
     * - minOccurs: 1
     * @var \NicholasCreativeMedia\FedExPHP\Structs\WebAuthenticationDetail
     */
    public $WebAuthenticationDetail;
    /**
     * The ClientDetail
     * Meta informations extracted from the WSDL
     * - documentation: Descriptive data identifying the client submitting the transaction.
     * - minOccurs: 1
     * @var \NicholasCreativeMedia\FedExPHP\Structs\ClientDetail
     */
    public $ClientDetail;
    /**
     * The Version
     * Meta informations extracted from the WSDL
     * - minOccurs: 1
     * @var \NicholasCreativeMedia\FedExPHP\Structs\VersionId
     */
    public $Version;
    /**
     * The TrackingNumber
     * Meta informations extracted from the WSDL
     * - documentation: The tracking number to which the notifications will be triggered from.
     * - minOccurs: 1
     * @var string
     */
    public $TrackingNumber;
    /**
     * The SenderContactName
     * Meta informations extracted from the WSDL
     * - documentation: Included in the email notification identifying the requester of this notification.
     * - minOccurs: 1
     * @var string
     */
    public $SenderContactName;
    /**
     * The TransactionDetail
     * Meta informations extracted from the WSDL
     * - documentation: Contains a free form field that is echoed back in the reply to match requests with replies and data that governs the data payload language/translations
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\TransactionDetail
     */
    public $TransactionDetail;
    /**
     * The MultiPiece
     * Meta informations extracted from the WSDL
     * - documentation: Indicates whether to return tracking information for all associated packages.
     * - minOccurs: 0
     * @var bool
     */
    public $MultiPiece;
    /**
     * The PagingToken
     * Meta informations extracted from the WSDL
     * - documentation: When the MoreDataAvailable field is true in a TrackNotificationReply the PagingToken must be sent in the subsequent TrackNotificationRequest to retrieve the next page of data.
     * - minOccurs: 0
     * @var string
     */
    public $PagingToken;
    /**
     * The TrackingNumberUniqueId
     * Meta informations extracted from the WSDL
     * - documentation: Use this field when your original request informs you that there are duplicates of this tracking number. If you get duplicates you will also receive some information about each of the duplicate tracking numbers to enable you to chose
     * one and resend that number along with the TrackingNumberUniqueId to get notifications for that tracking number.
     * - minOccurs: 0
     * @var string
     */
    public $TrackingNumberUniqueId;
    /**
     * The ShipDateRangeBegin
     * Meta informations extracted from the WSDL
     * - documentation: To narrow the search to a period in time the ShipDateRangeBegin and ShipDateRangeEnd can be used to help eliminate duplicates.
     * - minOccurs: 0
     * @var string
     */
    public $ShipDateRangeBegin;
    /**
     * The ShipDateRangeEnd
     * Meta informations extracted from the WSDL
     * - documentation: To narrow the search to a period in time the ShipDateRangeBegin and ShipDateRangeEnd can be used to help eliminate duplicates.
     * - minOccurs: 0
     * @var string
     */
    public $ShipDateRangeEnd;
    /**
     * The SenderEMailAddress
     * Meta informations extracted from the WSDL
     * - documentation: Included in the email notification identifying the requester of this notification.
     * - minOccurs: 0
     * @var string
     */
    public $SenderEMailAddress;
    /**
     * The EventNotificationDetail
     * Meta informations extracted from the WSDL
     * - documentation: This replaces eMailNotificationDetail
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\ShipmentEventNotificationDetail
     */
    public $EventNotificationDetail;
    /**
     * Constructor method for SendNotificationsRequest
     * @uses SendNotificationsRequest::setWebAuthenticationDetail()
     * @uses SendNotificationsRequest::setClientDetail()
     * @uses SendNotificationsRequest::setVersion()
     * @uses SendNotificationsRequest::setTrackingNumber()
     * @uses SendNotificationsRequest::setSenderContactName()
     * @uses SendNotificationsRequest::setTransactionDetail()
     * @uses SendNotificationsRequest::setMultiPiece()
     * @uses SendNotificationsRequest::setPagingToken()
     * @uses SendNotificationsRequest::setTrackingNumberUniqueId()
     * @uses SendNotificationsRequest::setShipDateRangeBegin()
     * @uses SendNotificationsRequest::setShipDateRangeEnd()
     * @uses SendNotificationsRequest::setSenderEMailAddress()
     * @uses SendNotificationsRequest::setEventNotificationDetail()
     * @param \NicholasCreativeMedia\FedExPHP\Structs\WebAuthenticationDetail $webAuthenticationDetail
     * @param \NicholasCreativeMedia\FedExPHP\Structs\ClientDetail $clientDetail
     * @param \NicholasCreativeMedia\FedExPHP\Structs\VersionId $version
     * @param string $trackingNumber
     * @param string $senderContactName
     * @param \NicholasCreativeMedia\FedExPHP\Structs\TransactionDetail $transactionDetail
     * @param bool $multiPiece
     * @param string $pagingToken
     * @param string $trackingNumberUniqueId
     * @param string $shipDateRangeBegin
     * @param string $shipDateRangeEnd
     * @param string $senderEMailAddress
     * @param \NicholasCreativeMedia\FedExPHP\Structs\ShipmentEventNotificationDetail $eventNotificationDetail
     */
    public function __construct(\NicholasCreativeMedia\FedExPHP\Structs\WebAuthenticationDetail $webAuthenticationDetail = null, \NicholasCreativeMedia\FedExPHP\Structs\ClientDetail $clientDetail = null, \NicholasCreativeMedia\FedExPHP\Structs\VersionId $version = null, $trackingNumber = null, $senderContactName = null, \NicholasCreativeMedia\FedExPHP\Structs\TransactionDetail $transactionDetail = null, $multiPiece = null, $pagingToken = null, $trackingNumberUniqueId = null, $shipDateRangeBegin = null, $shipDateRangeEnd = null, $senderEMailAddress = null, \NicholasCreativeMedia\FedExPHP\Structs\ShipmentEventNotificationDetail $eventNotificationDetail = null)
    {
        $this
            ->setWebAuthenticationDetail($webAuthenticationDetail)
            ->setClientDetail($clientDetail)
            ->setVersion($version)
            ->setTrackingNumber($trackingNumber)
            ->setSenderContactName($senderContactName)
            ->setTransactionDetail($transactionDetail)
            ->setMultiPiece($multiPiece)
            ->setPagingToken($pagingToken)
            ->setTrackingNumberUniqueId($trackingNumberUniqueId)
            ->setShipDateRangeBegin($shipDateRangeBegin)
            ->setShipDateRangeEnd($shipDateRangeEnd)
            ->setSenderEMailAddress($senderEMailAddress)
            ->setEventNotificationDetail($eventNotificationDetail);
    }
    /**
     * Get WebAuthenticationDetail value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\WebAuthenticationDetail
     */
    public function getWebAuthenticationDetail()
    {
        return $this->WebAuthenticationDetail;
    }
    /**
     * Set WebAuthenticationDetail value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\WebAuthenticationDetail $webAuthenticationDetail
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setWebAuthenticationDetail(\NicholasCreativeMedia\FedExPHP\Structs\WebAuthenticationDetail $webAuthenticationDetail = null)
    {
        $this->WebAuthenticationDetail = $webAuthenticationDetail;
        return $this;
    }
    /**
     * Get ClientDetail value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ClientDetail
     */
    public function getClientDetail()
    {
        return $this->ClientDetail;
    }
    /**
     * Set ClientDetail value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\ClientDetail $clientDetail
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setClientDetail(\NicholasCreativeMedia\FedExPHP\Structs\ClientDetail $clientDetail = null)
    {
        $this->ClientDetail = $clientDetail;
        return $this;
    }
    /**
     * Get Version value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\VersionId
     */
    public function getVersion()
    {
        return $this->Version;
    }
    /**
     * Set Version value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\VersionId $version
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setVersion(\NicholasCreativeMedia\FedExPHP\Structs\VersionId $version = null)
    {
        $this->Version = $version;
        return $this;
    }
    /**
     * Get TrackingNumber value
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->TrackingNumber;
    }
    /**
     * Set TrackingNumber value
     * @param string $trackingNumber
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
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
     * Get SenderContactName value
     * @return string
     */
    public function getSenderContactName()
    {
        return $this->SenderContactName;
    }
    /**
     * Set SenderContactName value
     * @param string $senderContactName
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setSenderContactName($senderContactName = null)
    {
        // validation for constraint: string
        if (!is_null($senderContactName) && !is_string($senderContactName)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($senderContactName)), __LINE__);
        }
        $this->SenderContactName = $senderContactName;
        return $this;
    }
    /**
     * Get TransactionDetail value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TransactionDetail|null
     */
    public function getTransactionDetail()
    {
        return $this->TransactionDetail;
    }
    /**
     * Set TransactionDetail value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\TransactionDetail $transactionDetail
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setTransactionDetail(\NicholasCreativeMedia\FedExPHP\Structs\TransactionDetail $transactionDetail = null)
    {
        $this->TransactionDetail = $transactionDetail;
        return $this;
    }
    /**
     * Get MultiPiece value
     * @return bool|null
     */
    public function getMultiPiece()
    {
        return $this->MultiPiece;
    }
    /**
     * Set MultiPiece value
     * @param bool $multiPiece
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setMultiPiece($multiPiece = null)
    {
        $this->MultiPiece = $multiPiece;
        return $this;
    }
    /**
     * Get PagingToken value
     * @return string|null
     */
    public function getPagingToken()
    {
        return $this->PagingToken;
    }
    /**
     * Set PagingToken value
     * @param string $pagingToken
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setPagingToken($pagingToken = null)
    {
        // validation for constraint: string
        if (!is_null($pagingToken) && !is_string($pagingToken)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($pagingToken)), __LINE__);
        }
        $this->PagingToken = $pagingToken;
        return $this;
    }
    /**
     * Get TrackingNumberUniqueId value
     * @return string|null
     */
    public function getTrackingNumberUniqueId()
    {
        return $this->TrackingNumberUniqueId;
    }
    /**
     * Set TrackingNumberUniqueId value
     * @param string $trackingNumberUniqueId
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setTrackingNumberUniqueId($trackingNumberUniqueId = null)
    {
        // validation for constraint: string
        if (!is_null($trackingNumberUniqueId) && !is_string($trackingNumberUniqueId)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($trackingNumberUniqueId)), __LINE__);
        }
        $this->TrackingNumberUniqueId = $trackingNumberUniqueId;
        return $this;
    }
    /**
     * Get ShipDateRangeBegin value
     * @return string|null
     */
    public function getShipDateRangeBegin()
    {
        return $this->ShipDateRangeBegin;
    }
    /**
     * Set ShipDateRangeBegin value
     * @param string $shipDateRangeBegin
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setShipDateRangeBegin($shipDateRangeBegin = null)
    {
        // validation for constraint: string
        if (!is_null($shipDateRangeBegin) && !is_string($shipDateRangeBegin)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($shipDateRangeBegin)), __LINE__);
        }
        $this->ShipDateRangeBegin = $shipDateRangeBegin;
        return $this;
    }
    /**
     * Get ShipDateRangeEnd value
     * @return string|null
     */
    public function getShipDateRangeEnd()
    {
        return $this->ShipDateRangeEnd;
    }
    /**
     * Set ShipDateRangeEnd value
     * @param string $shipDateRangeEnd
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setShipDateRangeEnd($shipDateRangeEnd = null)
    {
        // validation for constraint: string
        if (!is_null($shipDateRangeEnd) && !is_string($shipDateRangeEnd)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($shipDateRangeEnd)), __LINE__);
        }
        $this->ShipDateRangeEnd = $shipDateRangeEnd;
        return $this;
    }
    /**
     * Get SenderEMailAddress value
     * @return string|null
     */
    public function getSenderEMailAddress()
    {
        return $this->SenderEMailAddress;
    }
    /**
     * Set SenderEMailAddress value
     * @param string $senderEMailAddress
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setSenderEMailAddress($senderEMailAddress = null)
    {
        // validation for constraint: string
        if (!is_null($senderEMailAddress) && !is_string($senderEMailAddress)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($senderEMailAddress)), __LINE__);
        }
        $this->SenderEMailAddress = $senderEMailAddress;
        return $this;
    }
    /**
     * Get EventNotificationDetail value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ShipmentEventNotificationDetail|null
     */
    public function getEventNotificationDetail()
    {
        return $this->EventNotificationDetail;
    }
    /**
     * Set EventNotificationDetail value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\ShipmentEventNotificationDetail $eventNotificationDetail
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
     */
    public function setEventNotificationDetail(\NicholasCreativeMedia\FedExPHP\Structs\ShipmentEventNotificationDetail $eventNotificationDetail = null)
    {
        $this->EventNotificationDetail = $eventNotificationDetail;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\SendNotificationsRequest
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
