<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for AvailableImagesDetail Structs
 * @subpackage Structs
 */
class AvailableImagesDetail extends AbstractStructBase
{
    /**
     * The Type
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var string
     */
    public $Type;
    /**
     * The Size
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var string
     */
    public $Size;
    /**
     * Constructor method for AvailableImagesDetail
     * @uses AvailableImagesDetail::setType()
     * @uses AvailableImagesDetail::setSize()
     * @param string $type
     * @param string $size
     */
    public function __construct($type = null, $size = null)
    {
        $this
            ->setType($type)
            ->setSize($size);
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
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\AvailableImageType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\AvailableImageType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $type
     * @return \NicholasCreativeMedia\FedExPHP\Structs\AvailableImagesDetail
     */
    public function setType($type = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\AvailableImageType::valueIsValid($type)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $type, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\AvailableImageType::getValidValues())), __LINE__);
        }
        $this->Type = $type;
        return $this;
    }
    /**
     * Get Size value
     * @return string|null
     */
    public function getSize()
    {
        return $this->Size;
    }
    /**
     * Set Size value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\ImageSizeType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\ImageSizeType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $size
     * @return \NicholasCreativeMedia\FedExPHP\Structs\AvailableImagesDetail
     */
    public function setSize($size = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\ImageSizeType::valueIsValid($size)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $size, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\ImageSizeType::getValidValues())), __LINE__);
        }
        $this->Size = $size;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\AvailableImagesDetail
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
