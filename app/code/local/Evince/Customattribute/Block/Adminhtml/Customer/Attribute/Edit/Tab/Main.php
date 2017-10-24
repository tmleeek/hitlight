<?php
/**
* @author Evince Team
* @copyright Copyright (c) 2008-2015 Evince (http://www.evincedev.com/)
* @package Evince_Customattribute
*/
class Evince_Customattribute_Block_Adminhtml_Customer_Attribute_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('entity_attribute');

        if (!Mage::app()->isSingleStoreMode()) {
            $model->setData('stores', explode(',', $model->getData('store_ids')));
        }

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getData('action'),
            'method' => 'post'
        ));

        $disableAttributeFields = array(
        );

        $rewriteAttributeValue = array(
            'status'    => array(
                'is_configurable' => 0
            )
        );

        $fieldset = $form->addFieldset('base_fieldset',
            array('legend'=>Mage::helper('customattribute')->__('Attribute Properties'))
        );
        if ($model->getAttributeId()) {
            $fieldset->addField('attribute_id', 'hidden', array(
                'name' => 'attribute_id',
            ));
        }

        $this->_addElementTypes($fieldset);

        $yesno = array(
            array(
                'value' => 1,
                'label' => Mage::helper('customattribute')->__('Yes')
            ),
            array(
                'value' => 0,
                'label' => Mage::helper('customattribute')->__('No')
            ),
        );

        $fieldset->addField('attribute_code', 'text', array(
            'name'  => 'attribute_code',
            'label' => Mage::helper('customattribute')->__('Attribute Code'),
            'title' => Mage::helper('customattribute')->__('Attribute Code - for internal use. Must be unique with no spaces'),
            'note'  => Mage::helper('customattribute')->__('For internal use. Must be unique with no spaces'),
            'class' => 'validate-code',
            'required' => true,
        ));
        
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('stores', 'multiselect', array(
                'name'      => 'stores[]',
                'label'     => Mage::helper('customattribute')->__('Store View'),
                'title'     => Mage::helper('customattribute')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        }
        else {
            $fieldset->addField('stores', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $scopes = array(
            Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE =>Mage::helper('customattribute')->__('Store View'),
            Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE =>Mage::helper('customattribute')->__('Website'),
            Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL =>Mage::helper('customattribute')->__('Global'),
        );

        if ($model->getAttributeCode() == 'status' || $model->getAttributeCode() == 'tax_class_id') {
            unset($scopes[Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE]);
        }

        $inputTypes = Mage::helper('customattribute')->getAttributeTypes();
        
        $response = new Varien_Object();
        $response->setTypes(array());

        $_disabledTypes = array();
        $_hiddenFields = array();
        foreach ($response->getTypes() as $type) {
            $inputTypes[] = $type;
            if (isset($type['hide_fields'])) {
                $_hiddenFields[$type['value']] = $type['hide_fields'];
            }
            if (isset($type['disabled_types'])) {
                $_disabledTypes[$type['value']] = $type['disabled_types'];
            }
        }
        
        $ordinaryValidationRules = array(
            array(
                'value' => '',
                'label' => Mage::helper('customattribute')->__('None')
            ),
            array(
                'value' => 'validate-number',
                'label' => Mage::helper('customattribute')->__('Decimal Number')
            ),
            array(
                'value' => 'validate-digits',
                'label' => Mage::helper('customattribute')->__('Integer Number')
            ),
            array(
                'value' => 'validate-tendigits',
                'label' => Mage::helper('customattribute')->__('10 Digits Integer Number')
            ),
            array(
                'value' => 'validate-aaa-0000',
                'label' => Mage::helper('customattribute')->__('AAA-0000')
            ),
            array(
                'value' => 'validate-email',
                'label' => Mage::helper('customattribute')->__('Email')
            ),
            array(
                'value' => 'validate-url',
                'label' => Mage::helper('customattribute')->__('Url')
            ),
            array(
                'value' => 'validate-alpha',
                'label' => Mage::helper('customattribute')->__('Letters')
            ),
            array(
                'value' => 'validate-alphanum',
                'label' => Mage::helper('customattribute')->__('Letters(a-zA-Z) or Numbers(0-9)')
            ),
        );
        $additionalValidationRules = array();
        $additionalValidationRules = Mage::getModel('customattribute/validation')->getAdditionalValidation();
        $validationRules = array_merge($ordinaryValidationRules, $additionalValidationRules);

        $fieldset->addField('frontend_input', 'select', array(
            'name' => 'frontend_input',
            'label' => Mage::helper('customattribute')->__('Catalog Input Type for Store Owner'),
            'title' => Mage::helper('customattribute')->__('Catalog Input Type for Store Owner'),
            'value' => 'text',
            'values'=> $inputTypes
        ));

        $fieldset->addField('default_value_text', 'text', array(
            'name' => 'default_value_text',
            'label' => Mage::helper('customattribute')->__('Default value'),
            'title' => Mage::helper('customattribute')->__('Default value'),
            'value' => $model->getDefaultValue(),
        ));

        $fieldset->addField('default_value_yesno', 'select', array(
            'name'  => 'default_value_yesno',
            'label'  => Mage::helper('customattribute')->__('Default value'),
            'title'  => Mage::helper('customattribute')->__('Default value'),
            'values' => $yesno,
            'value'  => $model->getDefaultValue(),
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
        $fieldset->addField('default_value_date', 'date', array(
            'name'   => 'default_value_date',
            'label'  => Mage::helper('customattribute')->__('Default value'),
            'title'  => Mage::helper('customattribute')->__('Default value'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            'value'  => $model->getDefaultValue(),
            'format' => $dateFormatIso
        ));

        $fieldset->addField('default_value_textarea', 'textarea', array(
            'name' => 'default_value_textarea',
            'label' => Mage::helper('customattribute')->__('Default value'),
            'title' => Mage::helper('customattribute')->__('Default value'),
            'value' => $model->getDefaultValue(),
        ));
        
        $fieldset->addField('is_unique', 'select', array(
            'name' => 'is_unique',
            'label' => Mage::helper('customattribute')->__('Unique Value'),
            'title' => Mage::helper('customattribute')->__('Unique Value - not shared with other customers'),
            'note'  => Mage::helper('customattribute')->__('Not shared with other customers'),
            'values' => $yesno,
        ));

        $fieldset->addField('is_required', 'select', array(
            'name' => 'is_required',
            'label' => Mage::helper('customattribute')->__('Values Required'),
            'title' => Mage::helper('customattribute')->__('Values Required'),
            'values' => $yesno,
        ));
        
        $fieldset->addField('is_read_only', 'select', array(
            'name' => 'is_read_only',
            'label' => Mage::helper('customattribute')->__('Is Read Only'),
            'title' => Mage::helper('customattribute')->__('Is Read Only'),
            'values' => $yesno,
        ));

        $fieldset->addField('frontend_class', 'select', array(
            'name'  => 'frontend_class',
            'label' => Mage::helper('customattribute')->__('Input Validation'),
            'title' => Mage::helper('customattribute')->__('Input Validation'),
            'values'=> $validationRules 
        ));
        
        $fieldset->addField('file_size', 'text', array(
            'name'  => 'file_size',
            'label' => Mage::helper('customattribute')->__('Max File Size'),
            'title' => Mage::helper('customattribute')->__('Max File Size - in Mb'),
            'note'  => Mage::helper('customattribute')->__('In Mb'),
        ));
        
        $fieldset->addField('file_dimentions', 'text', array(
            'name'  => 'file_dimentions',
            'label' => Mage::helper('customattribute')->__('Image Dimentions'),
            'title' => Mage::helper('customattribute')->__('Image Dimentions - in pixels like: 30/40 (where 30 - width, 40 - height)'),
            'note'  => Mage::helper('customattribute')->__('In pixels like: 30/40 (where 30 - width, 40 - height)'),
        ));
        
        $fieldset->addField('file_types', 'text', array(
            'name'  => 'file_types',
            'label' => Mage::helper('customattribute')->__('File Types'),
            'title' => Mage::helper('customattribute')->__('File Types - list comma-separated file types like: png,txt,jpg'),
            'note'  => Mage::helper('customattribute')->__('List comma-separated file types like: png,txt,jpg'),
        ));
        
        // frontend properties fieldset
        $fieldset = $form->addFieldset('front_fieldset', array('legend'=>Mage::helper('customattribute')->__('Attribute Configuration')));

        $fieldset->addField('is_filterable_in_search', 'select', array(
            'name' => 'is_filterable_in_search',
            'label' => Mage::helper('customattribute')->__('Show on the Customers Grid'),
            'title' => Mage::helper('customattribute')->__('Show on the Customers Grid'),
            'values' => $yesno,
        ));
        
        $fieldset->addField('used_in_order_grid', 'select', array(
            'name' => 'used_in_order_grid',
            'label' => Mage::helper('customattribute')->__('Show on the Orders Grid'),
            'title' => Mage::helper('customattribute')->__('Show on the Orders Grid'),
            'values' => $yesno,
        ));
        
        $fieldset->addField('on_order_view', 'select', array(
            'name'  => 'on_order_view',
            'label' => Mage::helper('customattribute')->__('Show on the Order View page'),
            'title' => Mage::helper('customattribute')->__('Show on the Order View page - in the Account Information block at the Backend'),
            'note'  => Mage::helper('customattribute')->__('In the Account Information block at the Backend'),
            'values' => $yesno,
        ));
        
        $fieldset->addField('is_visible_on_front', 'select', array(
            'name'   => 'is_visible_on_front',
            'label'  => Mage::helper('customattribute')->__('Show on the Account Information page'),
            'title'  => Mage::helper('customattribute')->__('Show on the Account Information page - on the Frontend'),
            'note'   => Mage::helper('customattribute')->__('On the Frontend'),
            'values' => $yesno,
        ));
        
        $fieldset->addField('account_filled', 'select', array(
            'name'   => 'account_filled',
            'label'  => Mage::helper('customattribute')->__('Do not Show if Filled'),
            'title'  => Mage::helper('customattribute')->__('Do not Show if Filled - on the Account Information page on the Frontend'),
            'note'   => Mage::helper('customattribute')->__('On the Account Information page on the Frontend'),
            'values' => $yesno,
        ));
        
        $fieldset->addField('used_in_product_listing', 'select', array(
            'name'   => 'used_in_product_listing',
            'label'  => Mage::helper('customattribute')->__('Show on the Billing page'),
            'title'  => Mage::helper('customattribute')->__('Show on the Billing page - during Checkout'),
            'note'   => Mage::helper('customattribute')->__('During Checkout'),
            'values' => $yesno,
        ));
        
        $fieldset->addField('billing_filled', 'select', array(
            'name'   => 'billing_filled',
            'label'  => Mage::helper('customattribute')->__('Do not Show if Filled'),
            'title'  => Mage::helper('customattribute')->__('Do not Show if Filled - on the Billing page during Checkout'),
            'note'   => Mage::helper('customattribute')->__('On the Billing page during Checkout'),
            'values' => $yesno,
        ));
        
        $fieldset->addField('on_registration', 'select', array(
            'name'  => 'on_registration',
            'label' => Mage::helper('customattribute')->__('Show on the Registration page'),
            'title' => Mage::helper('customattribute')->__('Show on the Registration page'),
            'values' => $yesno,
        ));
        
        $fieldset->addField('sorting_order', 'text', array(
            'name'  => 'sorting_order',
            'label' => Mage::helper('customattribute')->__('Sorting Order'),
            'title' => Mage::helper('customattribute')->__('Sorting Order - the order to display field on Frontend'),
            'note'  => Mage::helper('customattribute')->__('The order to display field on frontend'),
        ));
        
        if ($model->getId()) {
            $form->getElement('attribute_code')->setDisabled(1);
            $form->getElement('frontend_input')->setDisabled(1);
        }

        $form->addValues($model->getData());

        if ($model->getId() && isset($rewriteAttributeValue[$model->getAttributeCode()])) {
            foreach ($rewriteAttributeValue[$model->getAttributeCode()] as $field => $value) {
                $form->getElement($field)->setValue($value);
            }
        }

        if ($applyTo = $model->getApplyTo()) {
            $applyTo = is_array($applyTo) ? $applyTo : explode(',', $applyTo);
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }

    protected function _getAdditionalElementTypes()
    {
        return array(
            'apply' => Mage::getConfig()->getBlockClassName('adminhtml/catalog_product_helper_form_apply')
        );
    }

}