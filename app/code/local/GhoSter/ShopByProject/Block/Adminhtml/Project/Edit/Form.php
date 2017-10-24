<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 3:13 PM
 */

class GhoSter_ShopByProject_Block_Adminhtml_Project_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * Prepare form for render
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
            )
        );

        $project = Mage::registry('current_project');

        if ($project->getId()) {
            $form->addField('id', 'hidden', array(
                'name' => 'id',
            ));
            $form->setValues($project->getData());
        }

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
