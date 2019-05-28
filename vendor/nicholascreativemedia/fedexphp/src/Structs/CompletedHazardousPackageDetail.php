<?php

namespace NicholasCreativeMedia\FedExPHP\Structs;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for CompletedHazardousPackageDetail Structs
 * Meta informations extracted from the WSDL
 * - documentation: Completed package-level hazardous commodity information for a single package.
 * @subpackage Structs
 */
class CompletedHazardousPackageDetail extends AbstractStructBase
{
    /**
     * The ReferenceId
     * Meta informations extracted from the WSDL
     * - documentation: A unique reference id that matches the package to a package configuration. This is populated if the client provided a package configuration for several packages that have the exact same dangerous goods content.
     * - minOccurs: 0
     * @var string
     */
    public $ReferenceId;
    /**
     * The Accessibility
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var string
     */
    public $Accessibility;
    /**
     * The CargoAircraftOnly
     * Meta informations extracted from the WSDL
     * - documentation: When true indicates that the package can be transported only on a cargo aircraft.
     * - minOccurs: 0
     * @var bool
     */
    public $CargoAircraftOnly;
    /**
     * The Regulation
     * Meta informations extracted from the WSDL
     * - minOccurs: 0
     * @var string
     */
    public $Regulation;
    /**
     * The RadioactiveTransportIndex
     * Meta informations extracted from the WSDL
     * - documentation: Specifies the maximum radiation level from the package (measured in microSieverts per hour at a distance of one meter from the external surface of the package, divided by 10).
     * - minOccurs: 0
     * @var float
     */
    public $RadioactiveTransportIndex;
    /**
     * The LabelType
     * Meta informations extracted from the WSDL
     * - documentation: Specifies the label that is to be put on a package containing radioactive material. The label type is determined in accordance with the Transportation of Dangerous Goods Act and indicates the type of radioactive material being
     * handled as well as the relative risk.
     * - minOccurs: 0
     * @var string
     */
    public $LabelType;
    /**
     * The Containers
     * Meta informations extracted from the WSDL
     * - documentation: Documents the kinds and quantities of all hazardous commodities in the current package.
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var \NicholasCreativeMedia\FedExPHP\Structs\ValidatedHazardousContainer[]
     */
    public $Containers;
    /**
     * Constructor method for CompletedHazardousPackageDetail
     * @uses CompletedHazardousPackageDetail::setReferenceId()
     * @uses CompletedHazardousPackageDetail::setAccessibility()
     * @uses CompletedHazardousPackageDetail::setCargoAircraftOnly()
     * @uses CompletedHazardousPackageDetail::setRegulation()
     * @uses CompletedHazardousPackageDetail::setRadioactiveTransportIndex()
     * @uses CompletedHazardousPackageDetail::setLabelType()
     * @uses CompletedHazardousPackageDetail::setContainers()
     * @param string $referenceId
     * @param string $accessibility
     * @param bool $cargoAircraftOnly
     * @param string $regulation
     * @param float $radioactiveTransportIndex
     * @param string $labelType
     * @param \NicholasCreativeMedia\FedExPHP\Structs\ValidatedHazardousContainer[] $containers
     */
    public function __construct($referenceId = null, $accessibility = null, $cargoAircraftOnly = null, $regulation = null, $radioactiveTransportIndex = null, $labelType = null, array $containers = array())
    {
        $this
            ->setReferenceId($referenceId)
            ->setAccessibility($accessibility)
            ->setCargoAircraftOnly($cargoAircraftOnly)
            ->setRegulation($regulation)
            ->setRadioactiveTransportIndex($radioactiveTransportIndex)
            ->setLabelType($labelType)
            ->setContainers($containers);
    }
    /**
     * Get ReferenceId value
     * @return string|null
     */
    public function getReferenceId()
    {
        return $this->ReferenceId;
    }
    /**
     * Set ReferenceId value
     * @param string $referenceId
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedHazardousPackageDetail
     */
    public function setReferenceId($referenceId = null)
    {
        // validation for constraint: string
        if (!is_null($referenceId) && !is_string($referenceId)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($referenceId)), __LINE__);
        }
        $this->ReferenceId = $referenceId;
        return $this;
    }
    /**
     * Get Accessibility value
     * @return string|null
     */
    public function getAccessibility()
    {
        return $this->Accessibility;
    }
    /**
     * Set Accessibility value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\DangerousGoodsAccessibilityType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\DangerousGoodsAccessibilityType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $accessibility
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedHazardousPackageDetail
     */
    public function setAccessibility($accessibility = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\DangerousGoodsAccessibilityType::valueIsValid($accessibility)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $accessibility, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\DangerousGoodsAccessibilityType::getValidValues())), __LINE__);
        }
        $this->Accessibility = $accessibility;
        return $this;
    }
    /**
     * Get CargoAircraftOnly value
     * @return bool|null
     */
    public function getCargoAircraftOnly()
    {
        return $this->CargoAircraftOnly;
    }
    /**
     * Set CargoAircraftOnly value
     * @param bool $cargoAircraftOnly
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedHazardousPackageDetail
     */
    public function setCargoAircraftOnly($cargoAircraftOnly = null)
    {
        $this->CargoAircraftOnly = $cargoAircraftOnly;
        return $this;
    }
    /**
     * Get Regulation value
     * @return string|null
     */
    public function getRegulation()
    {
        return $this->Regulation;
    }
    /**
     * Set Regulation value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\HazardousCommodityRegulationType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\HazardousCommodityRegulationType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $regulation
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedHazardousPackageDetail
     */
    public function setRegulation($regulation = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\HazardousCommodityRegulationType::valueIsValid($regulation)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $regulation, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\HazardousCommodityRegulationType::getValidValues())), __LINE__);
        }
        $this->Regulation = $regulation;
        return $this;
    }
    /**
     * Get RadioactiveTransportIndex value
     * @return float|null
     */
    public function getRadioactiveTransportIndex()
    {
        return $this->RadioactiveTransportIndex;
    }
    /**
     * Set RadioactiveTransportIndex value
     * @param float $radioactiveTransportIndex
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedHazardousPackageDetail
     */
    public function setRadioactiveTransportIndex($radioactiveTransportIndex = null)
    {
        $this->RadioactiveTransportIndex = $radioactiveTransportIndex;
        return $this;
    }
    /**
     * Get LabelType value
     * @return string|null
     */
    public function getLabelType()
    {
        return $this->LabelType;
    }
    /**
     * Set LabelType value
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\RadioactiveLabelType::valueIsValid()
     * @uses \NicholasCreativeMedia\FedExPHP\Enums\RadioactiveLabelType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $labelType
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedHazardousPackageDetail
     */
    public function setLabelType($labelType = null)
    {
        // validation for constraint: enumeration
        if (!\NicholasCreativeMedia\FedExPHP\Enums\RadioactiveLabelType::valueIsValid($labelType)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $labelType, implode(', ', \NicholasCreativeMedia\FedExPHP\Enums\RadioactiveLabelType::getValidValues())), __LINE__);
        }
        $this->LabelType = $labelType;
        return $this;
    }
    /**
     * Get Containers value
     * @return \NicholasCreativeMedia\FedExPHP\Structs\ValidatedHazardousContainer[]|null
     */
    public function getContainers()
    {
        return $this->Containers;
    }
    /**
     * Set Containers value
     * @throws \InvalidArgumentException
     * @param \NicholasCreativeMedia\FedExPHP\Structs\ValidatedHazardousContainer[] $containers
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedHazardousPackageDetail
     */
    public function setContainers(array $containers = array())
    {
        foreach ($containers as $completedHazardousPackageDetailContainersItem) {
            // validation for constraint: itemType
            if (!$completedHazardousPackageDetailContainersItem instanceof \NicholasCreativeMedia\FedExPHP\Structs\ValidatedHazardousContainer) {
                throw new \InvalidArgumentException(sprintf('The Containers property can only contain items of \NicholasCreativeMedia\FedExPHP\Structs\ValidatedHazardousContainer, "%s" given', is_object($completedHazardousPackageDetailContainersItem) ? get_class($completedHazardousPackageDetailContainersItem) : gettype($completedHazardousPackageDetailContainersItem)), __LINE__);
            }
        }
        $this->Containers = $containers;
        return $this;
    }
    /**
     * Add item to Containers value
     * @throws \InvalidArgumentException
     * @param \NicholasCreativeMedia\FedExPHP\Structs\ValidatedHazardousContainer $item
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedHazardousPackageDetail
     */
    public function addToContainers(\NicholasCreativeMedia\FedExPHP\Structs\ValidatedHazardousContainer $item)
    {
        // validation for constraint: itemType
        if (!$item instanceof \NicholasCreativeMedia\FedExPHP\Structs\ValidatedHazardousContainer) {
            throw new \InvalidArgumentException(sprintf('The Containers property can only contain items of \NicholasCreativeMedia\FedExPHP\Structs\ValidatedHazardousContainer, "%s" given', is_object($item) ? get_class($item) : gettype($item)), __LINE__);
        }
        $this->Containers[] = $item;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \NicholasCreativeMedia\FedExPHP\Structs\CompletedHazardousPackageDetail
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
