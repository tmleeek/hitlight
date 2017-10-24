<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Block_Adminhtml_LandingPage_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    /**
     * Set form id prefix, set values if landing page is editing
     *
     * @return Unitech_LandingPage_Block_Adminhtml_LandingPage_Edit_Tab_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $htmlIdPrefix = 'landingpage_information_';
        $form->setHtmlIdPrefix($htmlIdPrefix);
        $fieldsetHtmlClass = 'fieldset-wide';
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
            array(
                'tab_id' => $this->getTabId(),
            )
        );

        /* @var $model Unitech_LandingPage_Model_LandingPage */
        $model = Mage::registry('current_landingpage');
        $contents = $model->getDescription();
        $sortContents = $model->getShortDescription();

        $fieldset = $form->addFieldset(
            'base_fieldset', 
            array(
                'legend' => Mage::helper('unitech_landingpage')->__('LandingPage information'),
                'class'  => $fieldsetHtmlClass,
            )
        );

        if ($model->getLandingPageId()) {
            $fieldset->addField(
                'landingpage_id', 
                'hidden', 
                array(
                    'name' => 'landingpage_id',
                )
            );
        }

        $fieldset->addField(
            'title', 
            'text', 
            array(
                'label'    => Mage::helper('unitech_landingpage')->__('Title'),
                'name'     => 'title',
                'required' => true,
            )
        );

        $fieldset->addField(
            'identifier', 
            'text', 
            array(
                'label' => Mage::helper('unitech_landingpage')->__('Identifier'),
                'name'  => 'identifier',
            )
        );

        $fieldset->addField(
            'status', 
            'select', 
            array(
                'label'    => Mage::helper('unitech_landingpage')->__('Status'),
                'name'     => 'status',
                'required' => true,
                'disabled' => (bool)$model->getIsReadonly(),
                'options'  => Mage::getModel('unitech_landingpage/status')->getAllOptions(),
            )
        );
        if (!$model->getId()) {
            $model->setData('status', Unitech_LandingPage_Model_Status::STATUS_ENABLED);
        }

        $fieldset->addField(
            'keywords', 
            'textarea', 
            array(
                'label'    => Mage::helper('unitech_landingpage')->__('Search Keyword(s)'),
                'name'     => 'keywords',
            )
        );

        $fieldset->addField(
            'part_numbers', 
            'textarea', 
            array(
                'label'    => Mage::helper('unitech_landingpage')->__('Featured Product(s) - SKU\'s'),
                'name'     => 'part_numbers',
                'note'     => 'comma saperated',
            )
        );

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_ids', 
                'multiselect', 
                array(
                    'name'     => 'store_ids[]',
                    'label'    => Mage::helper('unitech_landingpage')->__('Visible In'),
                    'required' => true,
                    'values'   => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
                    'value'    => $model->getStoreIds(),
                )
            );
        } else {
            $fieldset->addField(
                'store_id', 
                'hidden', 
                array(
                    'name'  => 'store_ids[]',
                    'value' => Mage::app()->getStore(true)->getId()
                )
            );
            $model->setStoreIds(Mage::app()->getStore(true)->getId());
        }

        $fieldset->addField(
            'short_description', 
            'editor', 
            array(
                'name'      => 'short_description',
                'label'     => Mage::helper('unitech_landingpage')->__('Short Description'),
                'title'     => Mage::helper('unitech_landingpage')->__('Short Description'),
                'style'     => 'height:18em',
                'required'  => true,
                'config'    => $wysiwygConfig,
            )
        );
        
        $fieldset->addField(
            'description', 
            'editor', 
            array(
                'name'      => 'description',
                'label'     => Mage::helper('unitech_landingpage')->__('Description'),
                'title'     => Mage::helper('unitech_landingpage')->__('Description'),
                'style'     => 'height:18em',
                'required'  => true,
                'config'    => $wysiwygConfig,
            )
        );

        $fieldset->addField(
            'sort_order', 'text', 
            array(
                'label' => Mage::helper('unitech_landingpage')->__('Sort Order'),
                'title' => Mage::helper('unitech_landingpage')->__('Sort Order'),
                'name'  => 'sort_order',
            )
        );

        $fieldset->addField(
            'other_link_text', 'text', 
            array(
                'label' => Mage::helper('unitech_landingpage')->__('Other link text'),
                'title' => Mage::helper('unitech_landingpage')->__('Other link text'),
                'name'  => 'other_link_text',
            )
        );
        
        $fieldset->addField(
            'other_link', 'textarea', 
            array(
                'label' => Mage::helper('unitech_landingpage')->__('Other link(s)'),
                'title' => Mage::helper('unitech_landingpage')->__('Other link(s)'),
                'name'  => 'other_link',
                'note'     => 'comma saperated',
            )
        );
        
          $form->setValues($model->getData());
          $this->setForm($form);
          return $this;
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('unitech_landingpage')->__('General Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }
}