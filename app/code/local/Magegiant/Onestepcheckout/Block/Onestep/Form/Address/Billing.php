<?php

/**
 * Magegiant
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magegiant.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magegiant.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magegiant
 * @package     Magegiant_Onestepcheckout
 * @copyright   Copyright (c) 2012 Magegiant (http://www.magegiant.com/)
 * @license     http://www.magegiant.com/license-agreement.html
 */
class Magegiant_Onestepcheckout_Block_Onestep_Form_Address_Billing extends Mage_Checkout_Block_Onepage_Billing
{
    /**
     * Customer Taxvat Widget block
     *
     * @var Mage_Customer_Block_Widget_Taxvat
     */
    protected $_taxvat;

    protected $_attributeValidationClasses = array(
        'company'   => '',
        'fax'       => '',
        'telephone' => 'required-entry',
        'region'    => '',
        'postcode'  => 'required-entry',
        'city'      => 'required-entry',
        'street'    => 'required-entry',
    );

    public function getAddressesHtmlSelect($type)
    {
        if ($this->isCustomerLoggedIn()) {
            $options = array();
            foreach ($this->getCustomer()->getAddresses() as $address) {
                $options[] = array(
                    'value' => $address->getId(),
                    'label' => $address->format('oneline')
                );
            }

            $addressDetails = Mage::getSingleton('checkout/session')->getData('onestepcheckout_form_values');
            if (isset($addressDetails[$type . '_address_id'])) {
                if (empty($addressDetails[$type . '_address_id'])) {
                    $addressId = 0;
                } else {
                    $addressId = $addressDetails[$type . '_address_id'];
                }
            } else {
                $addressId = $this->getQuote()->getBillingAddress()->getCustomerAddressId();
            }
            if (empty($addressId) && $addressId !== 0) {
                $address = $this->getCustomer()->getPrimaryBillingAddress();
                if ($address) {
                    $addressId = $address->getId();
                }
            }

            $select = $this->getLayout()->createBlock('core/html_select')
                ->setName($type . '_address_id')
                ->setId($type . '-address-select')
                ->setClass('address-select')
                ->setValue($addressId)
                ->setOptions($options);

            $select->addOption('', Mage::helper('checkout')->__('New Address'));

            return $select->getHtml();
        }

        return '';
    }

    public function isVatAttributeVisible()
    {
        $helper = Mage::helper('customer/address');
        if (method_exists($helper, 'isVatAttributeVisible')) {
            return $helper->isVatAttributeVisible();
        }

        return false;
    }

    /**
     * Check whether taxvat is enabled
     *
     * @return bool
     */
    public function isTaxvatEnabled()
    {
        return $this->getCustomerWidgetTaxvat()->isEnabled();
    }

    public function getAttributeValidationClass($attributeCode)
    {
        $helper = Mage::helper('customer/address');
        if (method_exists($helper, 'getAttributeValidationClass')) {
            return $helper->getAttributeValidationClass($attributeCode);
        }
        if (array_key_exists($attributeCode, $this->_attributeValidationClasses)) {
            return $this->_attributeValidationClasses[$attributeCode];
        }

        return '';
    }

    public function getCustomerWidgetName($template)
    {
        $version = '';
        if (version_compare(Mage::getVersion(), '1.7.0.0', '<')) {
            $version = '1.6/';
        }

        return $this->getLayout()
            ->createBlock('customer/widget_name')
            ->setTemplate('magegiant/onestepcheckout/onestep/form/address/customer/widget/' . $version . $template . '.phtml')
            ->setObject($this->_getObjectForCustomerNameWidget())
            ->setForceUseCustomerRequiredAttributes(!$this->isCustomerLoggedIn())
            ->setFieldIdFormat('billing:%s')
            ->setFieldNameFormat('billing[%s]');
    }

    /**
     * Enterprise Customer Attribute
     *
     * @return string
     */
    public function getEnterpriseCustomerAttributesHtml()
    {
        if (Mage::helper('core')->isModuleEnabled('Enterprise_Customer')) {
            $customerAttributes = Mage::app()->getLayout()
                ->createBlock('enterprise_customer/form')
                ->setTemplate('magegiant/onestepcheckout/customer/form/attributes.phtml')
                ->setFormCode('checkout_register')
                ->addRenderer('text', 'enterprise_customer/form_renderer_text', 'customer/form/renderer/text.phtml')
                ->addRenderer('textarea', 'enterprise_customer/form_renderer_textarea', 'customer/form/renderer/textarea.phtml')
                ->addRenderer('multiline', 'enterprise_customer/form_renderer_multiline', 'customer/form/renderer/multiline.phtml')
                ->addRenderer('date', 'enterprise_customer/form_renderer_date', 'customer/form/renderer/date.phtml')
                ->addRenderer('select', 'enterprise_customer/form_renderer_select', 'customer/form/renderer/select.phtml')
                ->addRenderer('multiselect', 'enterprise_customer/form_renderer_multiselect', 'customer/form/renderer/multiselect.phtml')
                ->addRenderer('boolean', 'enterprise_customer/form_renderer_boolean', 'customer/form/renderer/boolean.phtml')
                ->addRenderer('file', 'enterprise_customer/form_renderer_file', 'customer/form/renderer/file.phtml')
                ->addRenderer('image', 'enterprise_customer/form_renderer_image', 'customer/form/renderer/image.phtml');

            if ($customerAttributes) {
                $customerModel = new Mage_Customer_Model_Customer(
                    Mage::getSingleton('checkout/session')->getData('onestepcheckout_form_values/billing')
                );
                $customerAttributes->setEntity($customerModel);
                $customerAttributes->setEntityModelClass('customer/customer')->setFieldIdFormat('billing:%1$s');
                $customerAttributes->setFieldNameFormat('billing[%1$s]')->setShowContainer(false);

                return $customerAttributes->setExcludeFileAttributes(true)->toHtml();
            }
        }

        return '';
    }

    /**
     * Enterprise Customer Address Attribute
     *
     * @return string
     */
    public function getEnterpriseAddressAttributesHtml()
    {
        if (Mage::helper('core')->isModuleEnabled('Enterprise_Customer')) {
            $addressAttributes = Mage::app()->getLayout()
                ->createBlock('enterprise_customer/form')
                ->setTemplate('magegiant/onestepcheckout/customer/form/attributes.phtml')
                ->setFormCode('customer_register_address')
                ->addRenderer('text', 'enterprise_customer/form_renderer_text', 'customer/form/renderer/text.phtml')
                ->addRenderer('textarea', 'enterprise_customer/form_renderer_textarea', 'customer/form/renderer/textarea.phtml')
                ->addRenderer('multiline', 'enterprise_customer/form_renderer_multiline', 'customer/form/renderer/multiline.phtml')
                ->addRenderer('date', 'enterprise_customer/form_renderer_date', 'customer/form/renderer/date.phtml')
                ->addRenderer('select', 'enterprise_customer/form_renderer_select', 'customer/form/renderer/select.phtml')
                ->addRenderer('multiselect', 'enterprise_customer/form_renderer_multiselect', 'customer/form/renderer/multiselect.phtml')
                ->addRenderer('boolean', 'enterprise_customer/form_renderer_boolean', 'customer/form/renderer/boolean.phtml')
                ->addRenderer('file', 'enterprise_customer/form_renderer_file', 'customer/form/renderer/file.phtml')
                ->addRenderer('image', 'enterprise_customer/form_renderer_image', 'customer/form/renderer/image.phtml');

            if ($addressAttributes) {
                $addressModel = new Mage_Customer_Model_Address(
                    Mage::getSingleton('checkout/session')->getData('aw_onestepcheckout_form_values/billing')
                );
                $addressAttributes->setEntity($addressModel);
                $addressAttributes->setFieldIdFormat('billing:%1$s')->setFieldNameFormat('billing[%1$s]');

                return $addressAttributes->setExcludeFileAttributes(true)->setShowContainer(false)->toHtml();
            }
        }

        return '';
    }

    public function getCustomerWidgetDateOfBirth()
    {
        return $this->getLayout()
            ->createBlock('customer/widget_dob')
            ->setDate($this->_getDateForDOBWidget())
            ->setFieldIdFormat('billing:%s')
            ->setFieldNameFormat('billing[%s]');
    }

    public function getCustomerWidgetGender()
    {
        return $this->getLayout()
            ->createBlock('customer/widget_gender')
            ->setGender($this->getDataFromSession('gender'))
            ->setFieldIdFormat('billing:%s')
            ->setFieldNameFormat('billing[%s]');
    }

    public function getCountryHtmlSelect($type)
    {
        $countryId = $this->getDataFromSession('country_id');
        if (is_null($countryId)) {
            $countryId = Mage::helper('onestepcheckout/config')->getDefaultCountryId();
        }
        $select = $this->getLayout()->createBlock('core/html_select')
            ->setName($type . '[country_id]')
            ->setId($type . ':country_id')
            ->setTitle($this->__('Country'))
            ->setClass('validate-select')
            ->setValue($countryId)
            ->setOptions($this->getCountryOptions());

        return $select->getHtml();
    }

    public function getTaxvatHtml()
    {
        return $this->getCustomerWidgetTaxvat()
            ->setTaxvat($this->getDataFromSession('taxvat'))
            ->setFieldIdFormat('billing:%s')
            ->setFieldNameFormat('billing[%s]')
            ->toHtml();
    }

    /**
     * Get Customer Taxvat Widget block
     *
     * @return Mage_Customer_Block_Widget_Taxvat
     */
    protected function getCustomerWidgetTaxvat()
    {
        if (!$this->_taxvat) {
            $this->_taxvat = $this->getLayout()->createBlock('customer/widget_taxvat');
        }

        return $this->_taxvat;
    }

    public function allowShipToDifferent()
    {
        return $this->getConfig()->allowShipToDifferent();
    }

    public function getConfig()
    {
        return Mage::helper('onestepcheckout/config');
    }

    public function getAddressChangedUrl()
    {
        return Mage::getUrl('onestepcheckout/ajax/saveAddress');
    }

    public function allowShipToDifferentChecked()
    {
        if ($address = $this->getQuote()->getShippingAddress()) {
            return $this->getQuote()->getShippingAddress()->getData('same_as_billing');
        }

        return false;
    }

    public function getDataFromSession($path)
    {
        $formData = Mage::getSingleton('checkout/session')->getData('onestepcheckout_form_values/billing');
        if (!empty($formData[$path])) {
            return $formData[$path];
        }

        return null;
    }

    public function customerMustBeRegistered()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn()
        || Mage::helper('checkout')->isAllowedGuestCheckout($this->getQuote());
    }

    protected function _getObjectForCustomerNameWidget()
    {
        $formData = Mage::getSingleton('checkout/session')->getData('onestepcheckout_form_values');
        $address  = Mage::getModel('sales/quote_address');
        if (isset($formData['billing'])) {
            $address->addData($formData['billing']);
        }
        if ($address->getFirstname() || $address->getLastname()) {
            return $address;
        }

        return $this->getQuote()->getCustomer();
    }

    protected function _getDateForDOBWidget()
    {
        $formData = Mage::getSingleton('checkout/session')->getData('onestepcheckout_form_values');
        if (isset($formData['billing'])) {
            $billing = $formData['billing'];
            if (!empty($billing['year']) && !empty($billing['month']) && !empty($billing['day'])) {
                $zDate = new Zend_Date(array(
                    'year'  => $billing['year'],
                    'month' => $billing['month'],
                    'day'   => $billing['day'],
                ));

                return $zDate->toString();
            }
        }

        return '';
    }

    /**
     * @param null $store
     * @return Magegiant_Onestepcheckout_Model_Mysql4_Attribute_Collection
     */
    public function getAttributePosition()
    {
        return Mage::getModel('onestepcheckout/attribute')->getBillingFields();
    }

    /**
     * @param $attribute_code
     * @param $entity_type
     * @return mixed
     */
    public function getAttributeLabel($attribute_code, $entity_type)
    {
        return Mage::helper('onestepcheckout')->getAttributeFrontendLabel($attribute_code, $entity_type);
    }

}