<?php

namespace NicholasCreativeMedia\FedExPHP\Enums;

/**
 * This class stands for RequestedShippingDocumentType Enums
 * @subpackage Enumerations
 */
class RequestedShippingDocumentType
{
    /**
     * Constant for value 'CERTIFICATE_OF_ORIGIN'
     * @return string 'CERTIFICATE_OF_ORIGIN'
     */
    const VALUE_CERTIFICATE_OF_ORIGIN = 'CERTIFICATE_OF_ORIGIN';
    /**
     * Constant for value 'COMMERCIAL_INVOICE'
     * @return string 'COMMERCIAL_INVOICE'
     */
    const VALUE_COMMERCIAL_INVOICE = 'COMMERCIAL_INVOICE';
    /**
     * Constant for value 'CUSTOMER_SPECIFIED_LABELS'
     * @return string 'CUSTOMER_SPECIFIED_LABELS'
     */
    const VALUE_CUSTOMER_SPECIFIED_LABELS = 'CUSTOMER_SPECIFIED_LABELS';
    /**
     * Constant for value 'CUSTOM_PACKAGE_DOCUMENT'
     * @return string 'CUSTOM_PACKAGE_DOCUMENT'
     */
    const VALUE_CUSTOM_PACKAGE_DOCUMENT = 'CUSTOM_PACKAGE_DOCUMENT';
    /**
     * Constant for value 'CUSTOM_SHIPMENT_DOCUMENT'
     * @return string 'CUSTOM_SHIPMENT_DOCUMENT'
     */
    const VALUE_CUSTOM_SHIPMENT_DOCUMENT = 'CUSTOM_SHIPMENT_DOCUMENT';
    /**
     * Constant for value 'DANGEROUS_GOODS_SHIPPERS_DECLARATION'
     * @return string 'DANGEROUS_GOODS_SHIPPERS_DECLARATION'
     */
    const VALUE_DANGEROUS_GOODS_SHIPPERS_DECLARATION = 'DANGEROUS_GOODS_SHIPPERS_DECLARATION';
    /**
     * Constant for value 'EXPORT_DECLARATION'
     * @return string 'EXPORT_DECLARATION'
     */
    const VALUE_EXPORT_DECLARATION = 'EXPORT_DECLARATION';
    /**
     * Constant for value 'FREIGHT_ADDRESS_LABEL'
     * @return string 'FREIGHT_ADDRESS_LABEL'
     */
    const VALUE_FREIGHT_ADDRESS_LABEL = 'FREIGHT_ADDRESS_LABEL';
    /**
     * Constant for value 'GENERAL_AGENCY_AGREEMENT'
     * @return string 'GENERAL_AGENCY_AGREEMENT'
     */
    const VALUE_GENERAL_AGENCY_AGREEMENT = 'GENERAL_AGENCY_AGREEMENT';
    /**
     * Constant for value 'LABEL'
     * @return string 'LABEL'
     */
    const VALUE_LABEL = 'LABEL';
    /**
     * Constant for value 'NAFTA_CERTIFICATE_OF_ORIGIN'
     * @return string 'NAFTA_CERTIFICATE_OF_ORIGIN'
     */
    const VALUE_NAFTA_CERTIFICATE_OF_ORIGIN = 'NAFTA_CERTIFICATE_OF_ORIGIN';
    /**
     * Constant for value 'OP_900'
     * @return string 'OP_900'
     */
    const VALUE_OP_900 = 'OP_900';
    /**
     * Constant for value 'PRO_FORMA_INVOICE'
     * @return string 'PRO_FORMA_INVOICE'
     */
    const VALUE_PRO_FORMA_INVOICE = 'PRO_FORMA_INVOICE';
    /**
     * Constant for value 'RETURN_INSTRUCTIONS'
     * @return string 'RETURN_INSTRUCTIONS'
     */
    const VALUE_RETURN_INSTRUCTIONS = 'RETURN_INSTRUCTIONS';
    /**
     * Return true if value is allowed
     * @uses self::getValidValues()
     * @param mixed $value value
     * @return bool true|false
     */
    public static function valueIsValid($value)
    {
        return ($value === null) || in_array($value, self::getValidValues(), true);
    }
    /**
     * Return allowed values
     * @uses self::VALUE_CERTIFICATE_OF_ORIGIN
     * @uses self::VALUE_COMMERCIAL_INVOICE
     * @uses self::VALUE_CUSTOMER_SPECIFIED_LABELS
     * @uses self::VALUE_CUSTOM_PACKAGE_DOCUMENT
     * @uses self::VALUE_CUSTOM_SHIPMENT_DOCUMENT
     * @uses self::VALUE_DANGEROUS_GOODS_SHIPPERS_DECLARATION
     * @uses self::VALUE_EXPORT_DECLARATION
     * @uses self::VALUE_FREIGHT_ADDRESS_LABEL
     * @uses self::VALUE_GENERAL_AGENCY_AGREEMENT
     * @uses self::VALUE_LABEL
     * @uses self::VALUE_NAFTA_CERTIFICATE_OF_ORIGIN
     * @uses self::VALUE_OP_900
     * @uses self::VALUE_PRO_FORMA_INVOICE
     * @uses self::VALUE_RETURN_INSTRUCTIONS
     * @return string[]
     */
    public static function getValidValues()
    {
        return array(
            self::VALUE_CERTIFICATE_OF_ORIGIN,
            self::VALUE_COMMERCIAL_INVOICE,
            self::VALUE_CUSTOMER_SPECIFIED_LABELS,
            self::VALUE_CUSTOM_PACKAGE_DOCUMENT,
            self::VALUE_CUSTOM_SHIPMENT_DOCUMENT,
            self::VALUE_DANGEROUS_GOODS_SHIPPERS_DECLARATION,
            self::VALUE_EXPORT_DECLARATION,
            self::VALUE_FREIGHT_ADDRESS_LABEL,
            self::VALUE_GENERAL_AGENCY_AGREEMENT,
            self::VALUE_LABEL,
            self::VALUE_NAFTA_CERTIFICATE_OF_ORIGIN,
            self::VALUE_OP_900,
            self::VALUE_PRO_FORMA_INVOICE,
            self::VALUE_RETURN_INSTRUCTIONS,
        );
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
