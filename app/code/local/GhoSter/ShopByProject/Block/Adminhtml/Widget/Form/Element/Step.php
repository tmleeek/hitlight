<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/10/16
 * Time: 2:49 PM
 */
class GhoSter_ShopByProject_Block_Adminhtml_Widget_Form_Element_Step extends Mage_Adminhtml_Block_Widget
    implements Varien_Data_Form_Element_Renderer_Interface
{
    protected $_element;

    public function __construct(){
        parent::__construct();
        $this->setTemplate('ghoster/shopbyproject/step.phtml');
    }

    public function getElement(){
        return $this->_element;
    }

    public function setElement(Varien_Data_Form_Element_Abstract $element){
        return $this->_element = $element;
    }

    public function render(Varien_Data_Form_Element_Abstract $element){
        $this->setElement($element);
        return $this->toHtml();
    }

    public function getAddButtonHtml(){
        return $this->getChildHtml('addBtn');
    }

    public function getDeleteButtonHtml(){
        return $this->getChildHtml('delBtn');
    }

    public function getBrowserFieldHtml(){
        return $this->getChildHtml('browser');
    }

    protected function _prepareLayout(){
        $addBtn = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'label'     => Mage::helper('ghoster_shopbyproject')->__('Add Instruction Step'),
            'onclick'   => 'window.instructionStep.add()',
            'class'     => 'add'
        ));
        $this->setChild('addBtn', $addBtn);

        $delBtn = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'onclick'   => 'window.instructionStep.remove({{id}})',
            'class'     => 'delete'
        ));
        $this->setChild('delBtn', $delBtn);

        parent::_prepareLayout();
    }

    public function getSteps(){
        $steps = [];
        $instruction = $this->getData('instruction');
        if (!$instruction) return $steps;

        $object = Mage::helper('core')->jsonDecode($instruction->getData('data'));

        if (!is_array($object)) return $steps;

        //$i=0;
        foreach ($object as $key=>$step){

            $steps[$key] = $step;
            //$i++;
        }

        return $steps;
    }
}
