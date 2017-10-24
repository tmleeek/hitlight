<?php
class Cyberfision_Brand_Block_Adminhtml_Widget_Form_Element_Images extends Mage_Adminhtml_Block_Widget
    implements Varien_Data_Form_Element_Renderer_Interface{

    protected $_element;


    public function __construct(){
        parent::__construct();
        $this->setTemplate('cyberfision/step.phtml');
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
            'label'     => 'Add Item',
            'onclick'   => 'window.catalogSlider.add()',
            'class'     => 'add'
        ));
        $this->setChild('addBtn', $addBtn);

        $delBtn = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'onclick'   => 'window.catalogSlider.remove({{id}})',
            'class'     => 'delete'
        ));
        $this->setChild('delBtn', $delBtn);

        parent::_prepareLayout();
    }

    public function getItems(){
        $items = [];
        $instruction = $this->getData('image');
        if (!$instruction) return $items;
        $object = Mage::helper('core')->jsonDecode($instruction->getData('image'));

        if (!is_array($object)) return $items;

        //$i=0;
        foreach ($object as $key=>$step){

            $items[$key] = $step;
            //$i++;
        }
        return $items;

    }
}