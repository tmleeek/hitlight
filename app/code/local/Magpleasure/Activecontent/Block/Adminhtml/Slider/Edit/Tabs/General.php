<?php

/**
 * MagPleasure Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE-CE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magpleasure.com/LICENSE-CE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * MagPleasure does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Magpleasure does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   MagPleasure
 * @package    Magpleasure_Forms
 * @version    1.1.3
 * @copyright  Copyright (c) 2011-2014 MagPleasure Ltd. (http://www.magpleasure.com)
 * @license    http://www.magpleasure.com/LICENSE-CE.txt
 */
class Magpleasure_Activecontent_Block_Adminhtml_Slider_Edit_Tabs_General extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Form Helper
     *
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    protected function _getGenerateUrlKeyButtonHtml()
    {
        /** @var $button Mage_Adminhtml_Block_Widget_Button */
        $button = $this->getLayout()->createBlock('adminhtml/widget_button');

        if ($button) {
            $button->addData(array(
                'label' => $this->_helper()->__("Update"),
                'title' => $this->_helper()->__("Update"),
                'onclick' => "$('code').value = generateUrlKey($('name').value); return false;",
                'style' => 'display: none;',
                'id' => 'generate_code'

            ));
            return $button->toHtml() . "
            <script type=\"text/javascript\">
            $('name').observe('blur', function(e){
                if (!$('code').value){
                    $('code').value = generateUrlKey($('name').value);
                    $('generate_code').style.display = 'inline';
                }
            });
            </script>
            ";
        }
        return "";
    }

    protected function _isNew()
    {
        return !Mage::registry(Magpleasure_Activecontent_Model_Slider::PATH_IN_REGISTRY)->getId();
    }

    protected function _getTabDefaults()
    {
        return array(
            'status' => '1',
            'width' => '900',
            'width_type' => 'px',
            'height' => '300',
            'height_type' => 'px',
            'use_size' => false,
        );
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        # Extract data from session or registry
        if (Mage::registry(Magpleasure_Activecontent_Model_Slider::PATH_IN_REGISTRY)) {
            $values = Mage::registry(Magpleasure_Activecontent_Model_Slider::PATH_IN_REGISTRY)->getData();
        } else {
            $values = Mage::getSingleton('adminhtml/session')->getAcBlockData(true);
        }

        # Define default values
        foreach ($this->_getTabDefaults() as $key => $value){

            if (!isset($values[$key])){
                $values[$key] = $value;
            }
        }

        # Prepare Form Fields
        if ($sliderId = $this->getRequest()->getParam('id')){

            # Prepare Form
            $widgetTemplate = "{{widget type=\"activecontent/slider\" slider_id=\"{{slider_id}}\"}}";
            $blockTemplate = "{{block type=\"activecontent/slider\" slider_id=\"{{slider_id}}\"}}";
            $xmlTemplate = "<block type=\"activecontent/slider\" name=\"activecontent.slider.id{{slider_id}}\">
    <action method=\"setSliderId\"><value>{{slider_id}}</value></action>
</block>";

            $fieldset = $form->addFieldset('cms_widget_fieldset', array(
                'legend'       => $this->_helper()->__('CMS Widget Snippet'),
                'table_class'  => 'snippets',
                'snippet_class' => 'prettyprint linenums',
                'snippet_template' => $widgetTemplate,
                'bind' => array('slider_id' => $sliderId),
            ));
            $renderer = $this->getLayout()->createBlock('magpleasure/adminhtml_widget_form_snippet');
            $fieldset->setRenderer($renderer);

            $fieldset = $form->addFieldset('cms_blocks_fieldset', array(
                'legend'       => Mage::helper('sales')->__('CMS Block Snippet'),
                'table_class'  => 'snippets',
                'snippet_class' => 'prettyprint linenums',
                'snippet_template' => $blockTemplate,
                'bind' => array('slider_id' => $sliderId),
            ));
            $renderer = $this->getLayout()->createBlock('magpleasure/adminhtml_widget_form_snippet');
            $fieldset->setRenderer($renderer);

            $fieldset = $form->addFieldset('xml_layouts_fieldset', array(
                'legend'       => Mage::helper('sales')->__('XML Layout Update Snippet'),
                'table_class'  => 'snippets',
                'snippet_class' => 'prettyprint linenums xml',
                'snippet_template' => $xmlTemplate,
                'bind' => array('slider_id' => $sliderId),
            ));
            $renderer = $this->getLayout()->createBlock('magpleasure/adminhtml_widget_form_snippet');
            $fieldset->setRenderer($renderer);
        }

        $fieldset = $form->addFieldset('visibility', array('legend' => $this->_helper()->__('Visibility Settings')));

        $fieldset->addField('name', 'text', array(
            'label' => $this->_helper()->__('Name'),
            'required' => true,
            'name' => 'name',
        ));

        /** @var Magpleasure_Activecontent_Model_Slider $statuses */
        $statuses = Mage::getSingleton('activecontent/slider');

        $fieldset->addField('status', 'select', array(
            'label' => $this->_helper()->__('Status'),
            'title' => $this->_helper()->__('Status'),
            'name' => 'status',
            'required' => true,
            'options' => $statuses->getStatusesArray(),
        ));

        if (!Mage::app()->isSingleStoreMode()){

            $fieldset->addField('stores', 'multiselect',
                        array(
                            'label'     => $this->_helper()->__('Visible in'),
                            'required'  => true,
                            'name'      => 'stores[]',
                            'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm()
                        ));
        }

        $fieldset = $form->addFieldset('size', array('legend' => $this->_helper()->__('Size Settings')));

        $fieldset->addField('use_size', 'checkbox', array(
            'name' => 'use_size',
            'label' => $this->_helper()->__('Define Slider Size'),
            'required' => false,
            'checked' => $values['use_size'],
        ));

        /** @var Magpleasure_Activecontent_Block_Adminhtml_System_Config_Form_Element_Size $widthType */
        $widthType = $this->getLayout()->createBlock('activecontent/adminhtml_system_config_form_element_size');
        if ($widthType){
            $widthType
                ->setDimensionIndex('width')
                ->setValue($values['width_type'])
                ->setIndex('width_type')
                ;
        }

        /** @var Magpleasure_Activecontent_Block_Adminhtml_System_Config_Form_Element_Size $heightType */
        $heightType = $this->getLayout()->createBlock('activecontent/adminhtml_system_config_form_element_size');
        if ($heightType){
            $heightType
                ->setDimensionIndex('height')
                ->setValue($values['height_type'])
                ->setIndex('height_type')
            ;
        }

        $fieldset->addField('width', 'text', array(
            'name' => 'width',
            'label' => $this->_helper()->__('Width'),
            'class' => 'validate-number',
            'after_element_html' => $widthType ? $widthType->toHtml() : false,
        ));

        $fieldset->addField('height', 'text', array(
            'name' => 'height',
            'label' => $this->_helper()->__('Height'),
            'class' => 'validate-number',
            'after_element_html' => $heightType ? $heightType->toHtml() : false,
        ));

        # Define Form Values
        $form->setValues($values);

        return parent::_prepareForm();
    }
}
