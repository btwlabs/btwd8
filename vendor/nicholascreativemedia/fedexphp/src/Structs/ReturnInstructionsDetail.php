<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ReturnInstructionsDetail Structs
 * Meta informations extracted from the WSDL
 * - documentation: The instructions indicating how to print the return instructions( e.g. image type) Specifies characteristics of a shipping document to be produced.
 * @subpackage Structs
 */
class ReturnInstructionsDetail extends AbstractStructBase
{
    /**
     * The Format
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\ShippingDocumentFormat
     */
    public $Format;
    /**
     * The CustomText
     * Meta informations extracted from the WSDL
     * - documentation: Specifies additional customer provided text to be inserted into the return document.
     * - minOccurs: 0
     * @var string
     */
    public $CustomText;
    /**
     * Constructor method for ReturnInstructionsDetail
     * @uses ReturnInstructionsDetail::setFormat()
     * @uses ReturnInstructionsDetail::setCustomText()
     * @param \NicholasCreativeMedia\FedExPHP\Structs\ShippingDocumentFormat $format
     * @param string $customText
     */
    public function __construct(\NicholasCreativeMedia\FedExPHP\Structs\ShippingDocumentFormat $format = null, $customText = null)
    {
        $this
            ->setFormat($format)
            ->setCustomText($customText);
    }
    /**
     * Get Format value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ShippingDocumentFormat|null
     */
    public function getFormat()
    {
        return $this->Format;
    }
    /**
     * Set Format value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\ShippingDocumentFormat $format
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ReturnInstructionsDetail
     */
    public function setFormat(\NicholasCreativeMedia\FedExPHP\Structs\ShippingDocumentFormat $format = null)
    {
        $this->Format = $format;
        return $this;
    }
    /**
     * Get CustomText value
     * @return string|null
     */
    public function getCustomText()
    {
        return $this->CustomText;
    }
    /**
     * Set CustomText value
     * @param string $customText
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ReturnInstructionsDetail
     */
    public function setCustomText($customText = null)
    {
        // validation for constraint: string
        if (!is_null($customText) && !is_string($customText)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($customText)), __LINE__);
        }
        $this->CustomText = $customText;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ReturnInstructionsDetail
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
