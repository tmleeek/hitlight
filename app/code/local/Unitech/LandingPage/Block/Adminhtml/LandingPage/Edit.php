<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Block_Adminhtml_LandingPage_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize landing page edit page. Set management buttons
     *
     */
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_landingPage';
        $this->_blockGroup = 'unitech_landingpage';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('unitech_landingpage')->__('Save Landing Page'));
        $this->_updateButton('delete', 'label', Mage::helper('unitech_landingpage')->__('Delete Landing Page'));

        $this->_addButton(
            'save_and_edit_button', 
            array(
                'label'   => Mage::helper('unitech_landingpage')->__('Save and Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save'
            ), 100
        );
        $this->_formScripts[] = '
            function saveAndContinueEdit() {
            editForm.submit($(\'edit_form\').action + \'back/edit/\');}';
    }

    /**
     * Get current loaded landing page ID
     *
     */
    public function getLandingPageId()
    {
        return Mage::registry('current_landingpage')->getId();
    }

    /**
     * Get header text for landing page edit page
     *
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_landingpage')->getId()) {
            return $this->htmlEscape(Mage::registry('current_landingpage')->getTitle());
        } else {
            return Mage::helper('unitech_landingpage')->__('New Landing Page');
        }
    }

    /**
     * Get form action URL
     *
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('*/*/save');
    }
}