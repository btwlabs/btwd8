<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for NaftaProducer Structs
 * @subpackage Structs
 */
class NaftaProducer extends AbstractStructBase
{
    /**
     * The Id
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var string
     */
    public $Id;
    /**
     * The Producer
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\Party
     */
    public $Producer;
    /**
     * Constructor method for NaftaProducer
     * @uses NaftaProducer::setId()
     * @uses NaftaProducer::setProducer()
     * @param string $id
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Party $producer
     */
    public function __construct($id = null, \NicholasCreativeMedia\FedExPHP\Structs\Party $producer = null)
    {
        $this
            ->setId($id)
            ->setProducer($producer);
    }
    /**
     * Get Id value
     * @return string|null
     */
    public function getId()
    {
        return $this->Id;
    }
    /**
     * Set Id value
     * @param string $id
     * @return \NicholasCreativeMedia\FedExPHP\Structs\NaftaProducer
     */
    public function setId($id = null)
    {
        // validation for constraint: string
        if (!is_null($id) && !is_string($id)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($id)), __LINE__);
        }
        $this->Id = $id;
        return $this;
    }
    /**
     * Get Producer value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\Party|null
     */
    public function getProducer()
    {
        return $this->Producer;
    }
    /**
     * Set Producer value
     * @param \NicholasCreativeMedia\FedExPHP\Structs\Party $producer
     * @return \NicholasCreativeMedia\FedExPHP\Structs\NaftaProducer
     */
    public function setProducer(\NicholasCreativeMedia\FedExPHP\Structs\Party $producer = null)
    {
        $this->Producer = $producer;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\NaftaProducer
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
