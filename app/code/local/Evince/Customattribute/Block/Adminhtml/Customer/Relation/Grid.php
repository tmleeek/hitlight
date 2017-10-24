<?php
/**
* @author Evince Team
* @package Evince_Customattribute
*/
class Evince_Customattribute_Block_Adminhtml_Customer_Relation_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('relationGrid');
        $this->setDefaultSort('attribute_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('customattribute/relation')->getResourceCollection()
        	->addRelations();
        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }
    
    protected function _prepareColumns()
    {
        $this->addColumn('name', array(
            'header'   => Mage::helper('customattribute')->__('Relation Name'),
            'sortable' => false,
            'index'    => 'name',
        ));

        $this->addColumn('parent_label', array(
            'header'   => Mage::helper('customattribute')->__('Parent Attribute'),
            'sortable' => false,
            'index'    => 'parent_label',
        ));
        
        $this->addColumn('dependent_label', array(
            'header'   => Mage::helper('customattribute')->__('Dependent Attributes'),
            'sortable' => false,
            'index'    => 'dependent_label',
            'renderer' => 'customattribute/adminhtml_customer_relation_grid_renderer_label',
        ));    
        
        $this->addColumn('attribute_codes', array(
            'header'   => Mage::helper('customattribute')->__('Attribute Codes'),
            'sortable' => false,
            'index'    => 'attribute_codes',
            'renderer' => 'customattribute/adminhtml_customer_relation_grid_renderer_code',
        ));
        
        $this->addColumn('action', 
            array(
            	'header'  => Mage::helper('customattribute')->__('Action'), 
            	'width'   => '100', 
                'type'    => 'action', 
                'getter'  => 'getId', 
                'actions' => array(
                    array(
                    	'caption' => Mage::helper('customattribute')->__('Edit'), 
        				'url' => array('base' => '*/*/edit'), 
        				'field' => 'id'
                    )
                ), 
    			'filter'    => false, 
    			'sortable'  => false, 
    			'index'     => 'stores', 
    			'is_system' => true,
            )
        ); 

        return parent::_prepareColumns();
    }
    
	protected function _prepareMassaction ()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('relation');
        
        $this->getMassactionBlock()->addItem('delete', 
            array(
            	'label'   => Mage::helper('customattribute')->__('Delete'), 
        		'url'     => $this->getUrl('*/*/massDelete'), 
            	'confirm' => Mage::helper('customattribute')->__('Are you sure?')));
            
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}