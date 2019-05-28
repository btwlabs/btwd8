<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for RecipientCustomsId Structs
 * Meta informations extracted from the WSDL
 * - documentation: Specifies how the recipient is identified for customs purposes; the requirements on this information vary with destination country.
 * @subpackage Structs
 */
class RecipientCustomsId extends AbstractStructBase
{
    /**
     * The Type
     * Meta informations extracted from the WSDL
     * - documentation: Specifies the kind of identification being used.
     * - minOccurs: 0
     * @var string
     */
    public $Type;
    /**
     * The Value
     * Meta informations extracted from the WSDL
     * - documentation: Contains the actual ID value, of the type specified above.
     * - minOccurs: 0
     * @var string
     */
    public $Value;
    /**
     * Constructor method for RecipientCustomsId
     * @uses RecipientCustomsId::setType()
     * @uses RecipientCustomsId::setValue()
     * @param string $type
     * @param string $value
     */
    public function __construct($type = null, $value = null)
    {
        $this
            ->setType($type)
            ->setValue($value);
    }
    /**
     * Get Type value
     * @return string|null
     */
    public function getType()
    {
        return $this->Type;
    }
    /**
     * Set Type value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\RecipientCustomsIdType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\RecipientCustomsIdType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $type
     * @return \NicholasCreativeMedia\FedExPHP\Structs\RecipientCustomsId
     */
    public function setType($type = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\RecipientCustomsIdType::valueIsValid($type)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $type, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\RecipientCustomsIdType::getValidValues())), __LINE__);
        }
        $this->Type = $type;
        return $this;
    }
    /**
     * Get Value value
     * @return string|null
     */
    public function getValue()
    {
        return $this->Value;
    }
    /**
     * Set Value value
     * @param string $value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\RecipientCustomsId
     */
    public function setValue($value = null)
    {
        // validation for constraint: string
        if (!is_null($value) && !is_string($value)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($value)), __LINE__);
        }
        $this->Value = $value;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\RecipientCustomsId
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
