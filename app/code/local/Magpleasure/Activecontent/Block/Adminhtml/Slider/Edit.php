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
 * @package    Magpleasure_Activecontent
 * @version    1.1.3
 * @copyright  Copyright (c) 2011-2014 MagPleasure Ltd. (http://www.magpleasure.com)
 * @license    http://www.magpleasure.com/LICENSE-CE.txt
 */

/**
 * Activecontent Edit Block
 */
class Magpleasure_Activecontent_Block_Adminhtml_Slider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Helper
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    /**
     * Class constructor/
     */
    public function __construct()
    {
        parent::__construct();

        $id = $this->getRequest()->getParam('id');
        $this->_objectId = 'id';
        $this->_blockGroup = 'activecontent';
        $this->_controller = 'adminhtml_slider';

        $this->_updateButton('back', 'label', $this->_helper()->__('Back to Manage Sliders'));
        $this->_updateButton('save', 'label', $this->_helper()->__('Save Slider'));
        $this->_updateButton('delete', 'label', $this->_helper()->__('Delete Slider'));

        if ($this->_isNew()) {

            $this->_addButton('saveandcontinue', array(
                'label' => $this->_helper()->__('Save And Manage Slides'),
                'onclick' => 'saveAndContinueEdit()',
                'class' => 'save',
            ), -100);

        } else {

            $duplicateUrl = $this->getUrl('*/*/duplicate', array('id'=>$this->getRequest()->getParam('id')));
            $this->_addButton('duplicate', array(
                'label' => $this->_helper()->__('Duplicate'),
                'onclick' => "setLocation('{$duplicateUrl}'); return false;",
                'class' => 'save duplicate',
            ), 0);

            $this->_addButton('saveandcontinue', array(
                'label' => $this->_helper()->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class' => 'save',
            ), -100);
        }

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/tab/'+slider_tabsJsTabs.activeTab.id.replace('slider_tabs_', '')+'/');
            }
        ";

        $this->_formScripts[] = "
            relativeFields({
                'use_size':{
                    'width': true,
                    'height': true
                }
            });
        ";
    }

    protected function _isNew()
    {
        return !(($regBlock = Mage::registry(Magpleasure_Activecontent_Model_Slider::PATH_IN_REGISTRY)) && $regBlock->getId());
    }

    /**
     * Retrives Header text
     * @return string
     */
    public function getHeaderText()
    {
        if ($this->_isNew()) {

            return $this->_helper()->__("New Slider");
        } else {
            return $this->_helper()->__(
                "Edit Slider '%s'",
                Mage::registry(Magpleasure_Activecontent_Model_Slider::PATH_IN_REGISTRY)->getName()
            );
        }
    }
}