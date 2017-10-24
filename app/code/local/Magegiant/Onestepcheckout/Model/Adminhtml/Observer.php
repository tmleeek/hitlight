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
class Magegiant_Onestepcheckout_Model_Adminhtml_Observer
{
    /**
     * Observer admin before save attribute
     *
     * @param $observer
     * @return $this
     */
    public function afterSaveAttribute($observer)
    {
        $attributeObject = $observer->getAttribute();
        $attribute_id    = $attributeObject->getId();
        $this->_saveNewAttribute($attributeObject);
        if (!$attribute_id)
            return $this;
        $attribute_code = $attributeObject->getAttributeCode();
        $entity_type_id = $attributeObject->getEntityTypeId();
        if ($attribute_code == 'prefix' || $attribute_code == 'middlename' || $attribute_code == 'suffix') {
            return $this;
        }
        if ($attributeObject->getIsVisible()) {
            if ($attributeObject->getIsRequired()) {
                $attributeObject->setIsUsedForOnestepcheckout('req');
                $fields = array(
                    'is_used_for_onestepcheckout' => $attributeObject->getIsUsedForOnestepcheckout(),
                    'attribute_id'                => $attribute_id,
                );
                try {
                    $attributeObject->save();
                } catch (Exception $e) {
                }
            } else {
                $fields = array(
                    'is_used_for_onestepcheckout' => $attributeObject->getIsUsedForOnestepcheckout(),
                    'attribute_id'                => $attribute_id,
                );
            }
            Mage::getResourceModel('onestepcheckout/attribute')->updateAttribute($entity_type_id, $attribute_code, $fields);
        } else {
            Mage::getResourceModel('onestepcheckout/attribute')->deleteAttribute($entity_type_id, $attribute_code);
        }

        return $this;
    }

    protected function _saveNewAttribute($attribute)
    {
        if ($attribute instanceof Mage_Customer_Model_Attribute && $attribute->isObjectNew()) {
            Mage::getModel('onestepcheckout/sales_quote')
                ->saveNewAttribute($attribute);
            Mage::getModel('onestepcheckout/sales_order')
                ->saveNewAttribute($attribute);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function adminhtmlSystemConfigSave()
    {
        $section = Mage::app()->getRequest()->getParam('section');
        if ($section == 'onestepcheckout') {
            $websiteCode   = Mage::app()->getRequest()->getParam('website');
            $storeCode     = Mage::app()->getRequest()->getParam('store');
            $css_generator = Mage::getSingleton('onestepcheckout/generator_css');
            $css_generator->generateCss($websiteCode, $storeCode, 'design');
        }

        return $this;
    }
}