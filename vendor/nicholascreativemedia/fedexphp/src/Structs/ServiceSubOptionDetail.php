<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ServiceSubOptionDetail Structs
 * Meta informations extracted from the WSDL
 * - documentation: Supporting detail for applied options identified in a rate quote.
 * @subpackage Structs
 */
class ServiceSubOptionDetail extends AbstractStructBase
{
    /**
     * The FreightGuarantee
     * Meta informations extracted from the WSDL
     * - documentation: Identifies the type of Freight Guarantee applied, if FREIGHT_GUARANTEE is applied to the rate quote.
     * - minOccurs: 0
     * @var string
     */
    public $FreightGuarantee;
    /**
     * The SmartPostHubId
     * Meta informations extracted from the WSDL
     * - documentation: Identifies the smartPostHubId used during rate quote, if SMART_POST_HUB_ID is a variable option on the rate request.
     * - minOccurs: 0
     * @var string
     */
    public $SmartPostHubId;
    /**
     * The SmartPostIndicia
     * Meta informations extracted from the WSDL
     * - documentation: Identifies the indicia used during rate quote, if SMART_POST_ALLOWED_INDICIA is a variable option on the rate request.
     * - minOccurs: 0
     * @var string
     */
    public $SmartPostIndicia;
    /**
     * Constructor method for ServiceSubOptionDetail
     * @uses ServiceSubOptionDetail::setFreightGuarantee()
     * @uses ServiceSubOptionDetail::setSmartPostHubId()
     * @uses ServiceSubOptionDetail::setSmartPostIndicia()
     * @param string $freightGuarantee
     * @param string $smartPostHubId
     * @param string $smartPostIndicia
     */
    public function __construct($freightGuarantee = null, $smartPostHubId = null, $smartPostIndicia = null)
    {
        $this
            ->setFreightGuarantee($freightGuarantee)
            ->setSmartPostHubId($smartPostHubId)
            ->setSmartPostIndicia($smartPostIndicia);
    }
    /**
     * Get FreightGuarantee value
     * @return string|null
     */
    public function getFreightGuarantee()
    {
        return $this->FreightGuarantee;
    }
    /**
     * Set FreightGuarantee value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\FreightGuaranteeType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\FreightGuaranteeType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $freightGuarantee
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ServiceSubOptionDetail
     */
    public function setFreightGuarantee($freightGuarantee = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\FreightGuaranteeType::valueIsValid($freightGuarantee)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $freightGuarantee, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\FreightGuaranteeType::getValidValues())), __LINE__);
        }
        $this->FreightGuarantee = $freightGuarantee;
        return $this;
    }
    /**
     * Get SmartPostHubId value
     * @return string|null
     */
    public function getSmartPostHubId()
    {
        return $this->SmartPostHubId;
    }
    /**
     * Set SmartPostHubId value
     * @param string $smartPostHubId
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ServiceSubOptionDetail
     */
    public function setSmartPostHubId($smartPostHubId = null)
    {
        // validation for constraint: string
        if (!is_null($smartPostHubId) && !is_string($smartPostHubId)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($smartPostHubId)), __LINE__);
        }
        $this->SmartPostHubId = $smartPostHubId;
        return $this;
    }
    /**
     * Get SmartPostIndicia value
     * @return string|null
     */
    public function getSmartPostIndicia()
    {
        return $this->SmartPostIndicia;
    }
    /**
     * Set SmartPostIndicia value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\SmartPostIndiciaType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\SmartPostIndiciaType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $smartPostIndicia
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ServiceSubOptionDetail
     */
    public function setSmartPostIndicia($smartPostIndicia = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\SmartPostIndiciaType::valueIsValid($smartPostIndicia)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $smartPostIndicia, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\SmartPostIndiciaType::getValidValues())), __LINE__);
        }
        $this->SmartPostIndicia = $smartPostIndicia;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ServiceSubOptionDetail
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
