<?php
/**
 * Created by PhpStorm.
 * User: Adminstrator
 * Date: 3/29/2017
 * Time: 9:50 AM
 */ 
class Cyberfision_Custom_Block_Adminhtml_Cms_Page_Edit_Form extends Mage_Adminhtml_Block_Cms_Page_Edit_Form {
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array('id' => 'edit_form', 'enctype' => 'multipart/form-data', 'action' => $this->getData('action'), 'method' => 'post'));
        $form->setUseContainer(true);
        $this->setForm($form);
        return $this;
    }
}