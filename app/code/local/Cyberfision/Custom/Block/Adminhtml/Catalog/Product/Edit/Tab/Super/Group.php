<?php
/**
 * Created by PhpStorm.
 * User: hungmt
 * Date: 13/03/2017
 * Time: 4:17 PM
 */ 
class Cyberfision_Custom_Block_Adminhtml_Catalog_Product_Edit_Tab_Super_Group extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Super_Group {
    protected function _prepareColumns()
    {
        $this->addColumn('in_products', array(
            'header_css_class' => 'a-center',
            'type'      => 'checkbox',
            'name'      => 'in_products',
            'values'    => $this->_getSelectedProducts(),
            'align'     => 'center',
            'index'     => 'entity_id'
        ));

        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => '60px',
            'index'     => 'entity_id'
        ));
        $this->addColumn('name', array(
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name'
        ));
        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => '150px',
            'index'     => 'sku'
        ));
        $this->addColumn('price', array(
            'header'    => Mage::helper('catalog')->__('Price'),
            'type'      => 'currency',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'     => 'price'
        ));

        $this->addColumn('qty', array(
            'header'    => Mage::helper('catalog')->__('Default Qty'),
            'name'      => 'qty',
            'type'      => 'number',
            'validate_class' => 'validate-number',
            'index'     => 'qty',
            'width'     => '1',
            'editable'  => true
        ));

        $this->addColumn('position', array(
            'header'    => Mage::helper('catalog')->__('Position'),
            'name'      => 'position',
            'type'      => 'number',
            'validate_class' => 'validate-number',
            'index'     => 'position',
            'width'     => '1',
            'editable'  => true,
            'edit_only' => !$this->_getProduct()->getId()
        ));

        $attr_tab = $this->_getAttributeCode('attribute_group_is_tab');
        $attr_tabs = explode(',', $attr_tab);

        if($attr_tab) {
            foreach ($attr_tabs as $itemTab) {
                $this->addColumn($itemTab, array(
                    'header'    => $this->_getAttributeName($itemTab),
                    'index'     => $itemTab,
                    'type'  => 'options',
                    'filter' => false,
                    'options' => $this->_getAttributeOptions($itemTab),
                ));
            }
        }

        $this->addColumn('action_view', array(
            'header'    => Mage::helper('catalog')->__('View Product'),
            'type'      => 'action',
            'filter'     => false,
            'sortable'  => false,
            'getter'     => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('catalog')->__('View Product'),
                    'url'     => array(
                        'base' => 'catalog/product/view',
                    ),
                    'field'   => 'id',
                    'target'    => '_blank'
                )
            ),
        ));

        $this->sortColumnsByOrder();
        return $this;
    }

    protected function _getAttributeOptions($code)
    {
        $product = Mage::registry('current_product');
        $associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);

        $options = array();

        foreach ($associatedProducts as $_itemTab) {
            if($_itemTab->getData($code)) {
                $option['value'] = $_itemTab->getData($code);
                $options[$option['value']] = $_itemTab->getAttributeText($code);
            }
        }

        return $options;
    }

    protected function _getAttributeCode($code) {
        $product = Mage::registry('current_product');
        $attribute_code = $product->getData($code);

        return $attribute_code;
    }

    protected function _getAttributeName($code) {
        $attribute_name = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', $code)->getFrontendLabel();

        return $attribute_name;
    }
}