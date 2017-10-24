<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 2:53 PM
 */
class GhoSter_ShopByProject_Block_Adminhtml_Project_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'ghoster_shopbyproject';
        $this->_controller = 'adminhtml_project';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('ghoster_shopbyproject')->__('Save Project'));
        $this->_updateButton('delete', 'label', Mage::helper('ghoster_shopbyproject')->__('Delete Project'));

        $this->_formScripts[] = "
							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
        if (!$this->hasData('template')) {
            $this->setTemplate('ghoster/shopbyproject/container.phtml');
        }
    }

    public function getProjectId()
    {
        return Mage::registry('current_project')->getId();
    }

    public function getHeaderText()
    {
        if (Mage::registry('current_project') && Mage::registry('current_project')->getId()) {

            return Mage::helper('ghoster_shopbyproject')->__('Edit "%s"', $this->escapeHtml(Mage::registry('current_project')->getTitle()));

        } else {

            return Mage::helper('ghoster_shopbyproject')->__('Add Project');

        }
    }

    protected function _prepareLayout()
    {
        $this->_addButton('save_and_continue', array(
            'label' => Mage::helper('customer')->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
            'class' => 'save'
        ), 10);

        return parent::_prepareLayout();
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current' => true,
            'back' => 'edit',
            'tab' => '{{tab_id}}'
        ));
    }
}
