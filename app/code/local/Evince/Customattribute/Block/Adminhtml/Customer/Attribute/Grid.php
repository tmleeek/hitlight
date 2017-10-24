<?php
/**
* @author Evince Team
* @copyright Copyright (c) 2008-2015 Evince (http://www.evincedev.com/)
* @package Evince_Customattribute
*/
class Evince_Customattribute_Block_Adminhtml_Customer_Attribute_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('attributeGrid');
        $this->setDefaultSort('attribute_code');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('customer/attribute')->getCollection();
        $alias = Mage::helper('customattribute')->getProperAlias($collection->getSelect()->getPart('from'), 'eav_attribute');
        $collection->getSelect()
            ->where($alias . 'is_user_defined = ?', 1)
            ->where($alias . 'attribute_code != ?', 'customer_activated');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('attribute_code', array(
            'header'=>Mage::helper('catalog')->__('Code'),
            'sortable'=>true,
            'index'=>'attribute_code'
        ));

        $this->addColumn('frontend_label', array(
            'header'=>Mage::helper('catalog')->__('Label'),
            'sortable'=>true,
            'index'=>'frontend_label'
        ));
        
        $this->addColumn('frontend_input', array(
            'header'   => Mage::helper('catalog')->__('Type'),
            'sortable' => true,
            'index'    => 'frontend_input',
            'type'     => 'options',
            'options'  => Mage::helper('customattribute')->getAttributeTypes(true),
            'align'    => 'center',
        ));

        $this->addColumn('sorting_order', array(
            'header'   => Mage::helper('customattribute')->__('Sorting Order'),
            'sortable' => true,
            'index'    => 'sorting_order',
            'width'    => '90px',
            'align'    => 'right',
        ));
        
        $this->addColumn('is_filterable_in_search', array(
            'header'=>Mage::helper('customattribute')->__('Show on the Customers Grid'),
            'sortable'=>true,
            'index'=>'is_filterable_in_search',
            'type' => 'options',
            'width' => '90px',
            'options' => array(
                '1' => Mage::helper('catalog')->__('Yes'),
                '0' => Mage::helper('catalog')->__('No'),
            ),
            'align' => 'center',
        ));
        
        $this->addColumn('used_in_order_grid', array(
            'header'=>Mage::helper('customattribute')->__('Show on the Orders Grid'),
            'sortable'=>true,
            'index'=>'used_in_order_grid',
            'type' => 'options',
            'width' => '50px',
            'options' => array(
                '1' => Mage::helper('catalog')->__('Yes'),
                '0' => Mage::helper('catalog')->__('No'),
            ),
            'align' => 'center',
        ));
        
        $this->addColumn('on_order_view', array(
            'header'=>Mage::helper('customattribute')->__('Show on the Order View page'),
            'sortable'=>true,
            'index'=>'on_order_view',
            'type' => 'options',
            'width' => '90px',
            'options' => array(
                '1' => Mage::helper('catalog')->__('Yes'),
                '0' => Mage::helper('catalog')->__('No'),
            ),
            'align' => 'center',
        ));
        
        $this->addColumn('is_visible', array(
            'header'=>Mage::helper('customattribute')->__('Show on the Account Information page'),
            'sortable'=>true,
            'index'=>'is_visible_on_front',
            'type' => 'options',
            'width' => '90px',
            'options' => array(
                '1' => Mage::helper('catalog')->__('Yes'),
                '0' => Mage::helper('catalog')->__('No'),
            ),
            'align' => 'center',
        ));
        
        $this->addColumn('on_registration', array(
            'header'=>Mage::helper('customattribute')->__('Show on the Registration page'),
            'sortable'=>true,
            'index'=>'on_registration',
            'type' => 'options',
            'width' => '90px',
            'options' => array(
                '1' => Mage::helper('catalog')->__('Yes'),
                '0' => Mage::helper('catalog')->__('No'),
            ),
            'align' => 'center',
        ));
        
        $this->addColumn('used_in_product_listing', array(
            'header'=>Mage::helper('customattribute')->__('Show on the Billing page'),
            'sortable'=>true,
            'index'=>'used_in_product_listing',
            'type' => 'options',
            'width' => '90px',
            'options' => array(
                '1' => Mage::helper('catalog')->__('Yes'),
                '0' => Mage::helper('catalog')->__('No'),
            ),
            'align' => 'center',
        ));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('attribute_id' => $row->getAttributeId()));
    }

}