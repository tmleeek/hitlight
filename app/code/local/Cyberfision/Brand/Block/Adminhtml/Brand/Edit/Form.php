<?php
class Cyberfision_Brand_Block_Adminhtml_Brand_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl(
                'cyberfision_brand_admin/brand/edit',
                array(
                    '_current' => true,
                    'continue' => 0,
                )
            ),
            'method' => 'post',
            
            'enctype' => 'multipart/form-data'
        ));
        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('Item Details')
            )
        );

        $brandSingleton = Mage::getSingleton(
            'cyberfision__brand/brand'
        );

        $this->_addFieldsToFieldset($fieldset, array(
            'name' => array(
                'label' => $this->__('Title'),
                'input' => 'text',
                'required' => true,
            ),

            'banner' => array(
                'label' => $this->__('Banner image'),
                'input' => 'image',
                'required' => true,
            ),

            'description' => array(
                'label' => $this->__('Description'),
                'input' => 'editor',
                'required' => true,
                'wysiwyg'   => true,
                'class' => 'description-tguide'
            ),

            'image' => array(
                'label' => $this->__('Image'),
                'required' => true,
                'input' => 'editor',
                'wysiwyg'   => true,
            ),

            'ordert' => array(
                'label' => $this->__('Order'),
                'input' => 'text'
            ),
            
        ));

        $form->getElement('image')->setRenderer(
            $this->getLayout()->createBlock('cyberfision_brand_adminhtml/widget_form_element_images')
                ->setData('image', Mage::registry('current_brand'))
        );

        return parent::_prepareForm();
    }

    protected function _addFieldsToFieldset(
        Varien_Data_Form_Element_Fieldset $fieldset, $fields)
    {
        $requestData = new Varien_Object($this->getRequest()
            ->getPost('brandData'));
            
        foreach ($fields as $name => $_data) {
            if ($requestValue = $requestData->getData($name)) {
                $_data['value'] = $requestValue;
            }

            $_data['name'] = "brandData[$name]";

            $_data['title'] = $_data['label'];

            if (!array_key_exists('value', $_data)) {
                $_data['value'] = $this->_getBrand()->getData($name);
            }

            $fieldset->addField($name, $_data['input'], $_data);
        }

        return $this;
    }

    protected function _getBrand()
    {
        if (!$this->hasData('brand')) {
            $brand = Mage::registry('current_brand');
            if (!$brand instanceof Cyberfision_Brand_Model_Brand) {
                $brand = Mage::getModel(
                    'cyberfision_brand/brand'
                );
            }

            $this->setData('brand', $brand);
        }

        return $this->getData('brand');
    }

    protected function _prepareLayout()
    {
        $return = parent::_prepareLayout();
        return $return;
    }
}