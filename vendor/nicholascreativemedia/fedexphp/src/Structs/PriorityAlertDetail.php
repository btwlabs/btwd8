<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for PriorityAlertDetail Structs
 * @subpackage Structs
 */
class PriorityAlertDetail extends AbstractStructBase
{
    /**
     * The Content
     * Meta informations extracted from the WSDL
     * - maxOccurs: unbounded
     * - minOccurs: 1
     * @var string[]
     */
    public $Content;
    /**
     * The EnhancementTypes
     * Meta informations extracted from the WSDL
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var string[]
     */
    public $EnhancementTypes;
    /**
     * Constructor method for PriorityAlertDetail
     * @uses PriorityAlertDetail::setContent()
     * @uses PriorityAlertDetail::setEnhancementTypes()
     * @param string[] $content
     * @param string[] $enhancementTypes
     */
    public function __construct(array $content = array(), array $enhancementTypes = array())
    {
        $this
            ->setContent($content)
            ->setEnhancementTypes($enhancementTypes);
    }
    /**
     * Get Content value
     * @return string[]
     */
    public function getContent()
    {
        return $this->Content;
    }
    /**
     * Set Content value
     * @throws \InvalidArgumentException
     * @param string[] $content
     * @return \NicholasCreativeMedia\FedExPHP\Structs\PriorityAlertDetail
     */
    public function setContent(array $content = array())
    {
        foreach ($content as $priorityAlertDetailContentItem) {
            // validation for constraint: itemType
            if (!is_string($priorityAlertDetailContentItem)) {
                throw new \InvalidArgumentException(sprintf('The Content property can only contain items of string, "%s" given', is_object($priorityAlertDetailContentItem) ? get_class($priorityAlertDetailContentItem) : gettype($priorityAlertDetailContentItem)), __LINE__);
            }
        }
        $this->Content = $content;
        return $this;
    }
    /**
     * Add item to Content value
     * @throws \InvalidArgumentException
     * @param string $item
     * @return \NicholasCreativeMedia\FedExPHP\Structs\PriorityAlertDetail
     */
    public function addToContent($item)
    {
        // validation for constraint: itemType
        if (!is_string($item)) {
            throw new \InvalidArgumentException(sprintf('The Content property can only contain items of string, "%s" given', is_object($item) ? get_class($item) : gettype($item)), __LINE__);
        }
        $this->Content[] = $item;
        return $this;
    }
    /**
     * Get EnhancementTypes value
     * @return string[]|null
     */
    public function getEnhancementTypes()
    {
        return $this->EnhancementTypes;
    }
    /**
     * Set EnhancementTypes value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\PriorityAlertEnhancementType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\PriorityAlertEnhancementType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string[] $enhancementTypes
     * @return \NicholasCreativeMedia\FedExPHP\Structs\PriorityAlertDetail
     */
    public function setEnhancementTypes(array $enhancementTypes = array())
    {
        $invalidValues = array();
        foreach ($enhancementTypes as $priorityAlertDetailEnhancementTypesItem) {
            if (!\NicholasCreativeMedia\FedExPHP\Enums\PriorityAlertEnhancementType::valueIsValid($priorityAlertDetailEnhancementTypesItem)) {
                $invalidValues[] = var_export($priorityAlertDetailEnhancementTypesItem);
            }
        }
        if (!empty($invalidValues)) {
            throw new \InvalidArgumentException(sprintf('Value(s) "%s" is/are invalid, please use one of: %s', implode(', ', $invalidValues), implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\PriorityAlertEnhancementType::getValidValues())), __LINE__);
        }
        $this->EnhancementTypes = $enhancementTypes;
        return $this;
    }
    /**
     * Add item to EnhancementTypes value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\PriorityAlertEnhancementType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\PriorityAlertEnhancementType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $item
     * @return \NicholasCreativeMedia\FedExPHP\Structs\PriorityAlertDetail
     */
    public function addToEnhancementTypes($item)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\PriorityAlertEnhancementType::valueIsValid($item)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $item, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\PriorityAlertEnhancementType::getValidValues())), __LINE__);
        }
        $this->EnhancementTypes[] = $item;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\PriorityAlertDetail
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
