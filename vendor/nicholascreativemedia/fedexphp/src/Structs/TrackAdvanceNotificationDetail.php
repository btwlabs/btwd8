<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for TrackAdvanceNotificationDetail Structs
 * @subpackage Structs
 */
class TrackAdvanceNotificationDetail extends AbstractStructBase
{
    /**
     * The EstimatedTimeOfArrival
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var string
     */
    public $EstimatedTimeOfArrival;
    /**
     * The Reason
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var string
     */
    public $Reason;
    /**
     * The Status
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var string
     */
    public $Status;
    /**
     * The StatusDescription
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var string
     */
    public $StatusDescription;
    /**
     * The StatusTime
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var string
     */
    public $StatusTime;
    /**
     * Constructor method for TrackAdvanceNotificationDetail
     * @uses TrackAdvanceNotificationDetail::setEstimatedTimeOfArrival()
     * @uses TrackAdvanceNotificationDetail::setReason()
     * @uses TrackAdvanceNotificationDetail::setStatus()
     * @uses TrackAdvanceNotificationDetail::setStatusDescription()
     * @uses TrackAdvanceNotificationDetail::setStatusTime()
     * @param string $estimatedTimeOfArrival
     * @param string $reason
     * @param string $status
     * @param string $statusDescription
     * @param string $statusTime
     */
    public function __construct($estimatedTimeOfArrival = null, $reason = null, $status = null, $statusDescription = null, $statusTime = null)
    {
        $this
            ->setEstimatedTimeOfArrival($estimatedTimeOfArrival)
            ->setReason($reason)
            ->setStatus($status)
            ->setStatusDescription($statusDescription)
            ->setStatusTime($statusTime);
    }
    /**
     * Get EstimatedTimeOfArrival value
     * @return string|null
     */
    public function getEstimatedTimeOfArrival()
    {
        return $this->EstimatedTimeOfArrival;
    }
    /**
     * Set EstimatedTimeOfArrival value
     * @param string $estimatedTimeOfArrival
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackAdvanceNotificationDetail
     */
    public function setEstimatedTimeOfArrival($estimatedTimeOfArrival = null)
    {
        // validation for constraint: string
        if (!is_null($estimatedTimeOfArrival) && !is_string($estimatedTimeOfArrival)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($estimatedTimeOfArrival)), __LINE__);
        }
        $this->EstimatedTimeOfArrival = $estimatedTimeOfArrival;
        return $this;
    }
    /**
     * Get Reason value
     * @return string|null
     */
    public function getReason()
    {
        return $this->Reason;
    }
    /**
     * Set Reason value
     * @param string $reason
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackAdvanceNotificationDetail
     */
    public function setReason($reason = null)
    {
        // validation for constraint: string
        if (!is_null($reason) && !is_string($reason)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($reason)), __LINE__);
        }
        $this->Reason = $reason;
        return $this;
    }
    /**
     * Get Status value
     * @return string|null
     */
    public function getStatus()
    {
        return $this->Status;
    }
    /**
     * Set Status value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\TrackAdvanceNotificationStatusType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\TrackAdvanceNotificationStatusType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $status
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackAdvanceNotificationDetail
     */
    public function setStatus($status = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\TrackAdvanceNotificationStatusType::valueIsValid($status)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $status, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\TrackAdvanceNotificationStatusType::getValidValues())), __LINE__);
        }
        $this->Status = $status;
        return $this;
    }
    /**
     * Get StatusDescription value
     * @return string|null
     */
    public function getStatusDescription()
    {
        return $this->StatusDescription;
    }
    /**
     * Set StatusDescription value
     * @param string $statusDescription
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackAdvanceNotificationDetail
     */
    public function setStatusDescription($statusDescription = null)
    {
        // validation for constraint: string
        if (!is_null($statusDescription) && !is_string($statusDescription)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($statusDescription)), __LINE__);
        }
        $this->StatusDescription = $statusDescription;
        return $this;
    }
    /**
     * Get StatusTime value
     * @return string|null
     */
    public function getStatusTime()
    {
        return $this->StatusTime;
    }
    /**
     * Set StatusTime value
     * @param string $statusTime
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackAdvanceNotificationDetail
     */
    public function setStatusTime($statusTime = null)
    {
        // validation for constraint: string
        if (!is_null($statusTime) && !is_string($statusTime)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($statusTime)), __LINE__);
        }
        $this->StatusTime = $statusTime;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\TrackAdvanceNotificationDetail
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
