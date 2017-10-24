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
 * Activecontent Edit Content
 */
class Magpleasure_Activecontent_Block_Adminhtml_Slide_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected $_slider;

    /**
     * Helper
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    protected function getSlider()
    {
        if (!$this->_slider) {

            $sliderId = $this->getRequest()->getParam('id');

            if ($sliderId) {

                /** @var Magpleasure_Activecontent_Model_Slider $slider */
                $slider = Mage::getModel('activecontent/slider');
                $slider->load($sliderId);
                $this->_slider = $slider;
            }
        }

        return $this->_slider;
    }

    public function getFormActionUrl()
    {
        return $this->getUrl('*/admin_slide/save', array(
                'id' => $this->getRequest()->getParam('id'),
                'slide_id' => $this->getRequest()->getParam('slide_id'),
            )
        );
    }

    public function getDeleteUrl()
    {
        return $this->getUrl(
            '*/admin_slide/delete',
            array(
                'id' => $this->getRequest()->getParam('id'),
                'slide_id' => $this->getRequest()->getParam('slide_id'),
            )
        );
    }

    public function getBackUrl()
    {
        return $this->getUrl(
            '*/admin_slider/edit',
            array(
                'id' => $this->getRequest()->getParam('id'),
                'tab' => 'slide_section',
            )
        );
    }

    /**
     * Class constructor/
     */
    public function __construct()
    {
        parent::__construct();

        $id = $this->getRequest()->getParam('slide_id');
        $this->_objectId = 'slide_id';
        $this->_blockGroup = 'activecontent';
        $this->_controller = 'adminhtml_slide';

        $this->_updateButton('back', 'label', $this->_helper()->__('Back to Slider'));
        $this->_updateButton('save', 'label', $this->_helper()->__('Save Slide'));
        $this->_updateButton('delete', 'label', $this->_helper()->__('Delete Slide'));
        $this->_updateButton('delete', 'onclick',
            'deleteConfirm(\''.
            $this->_helper()->__('It will delete this slider and all slides. Are you sure?')
            .'\', \'' . $this->getDeleteUrl() . '\')'
        );

        $duplicateUrl = $this->getUrl('*/*/duplicate', array(
            'id' => $this->getRequest()->getParam('id'),
            'slide_id' => $this->getRequest()->getParam('slide_id'),
        ));

        $this->_addButton('duplicate', array(
            'label' => $this->_helper()->__('Duplicate'),
            'onclick' => "setLocation('{$duplicateUrl}'); return false;",
            'class' => 'save duplicate',
        ), 0);

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'block_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";


        $this->_formScripts[] = "

        $('display_from').observe('change', function(){
            if ($('display_from_orig')){
                $('display_from_orig').value = '0';
            }
        });

        ";

        $this->_formScripts[] = "

        $('display_to').observe('change', function(){
            if ($('display_to_orig')){
                $('display_to_orig').value = '0';
            }
        });

        ";

        if (!$this->getRequest()->getParam('slide_id')){
            $this->_removeButton('delete');
        }
    }

    /**
     * Retrives Header text
     * @return string
     */
    public function getHeaderText()
    {
        if (($regBlock = Mage::registry(Magpleasure_Activecontent_Model_Slide::PATH_IN_REGISTRY)) && $regBlock->getId()) {

            return $this->_helper()->__(
                "Edit Slide '%s' in '%s'",
                Mage::registry(Magpleasure_Activecontent_Model_Slide::PATH_IN_REGISTRY)->getTitle(),
                $this->getSlider()->getName()
            );

        } else {
            return $this->_helper()->__("New Slide in '%s'", $this->getSlider()->getName());
        }
    }
}