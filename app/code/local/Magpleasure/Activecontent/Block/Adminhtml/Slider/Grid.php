<?php

/**
 * MagPleasure Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE-CE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magpleasure.com/LICENSE-CE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * MagPleasure does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Magpleasure does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   MagPleasure
 * @package    Magpleasure_Activecontent
 * @version    1.1.3
 * @copyright  Copyright (c) 2011-2014 MagPleasure Ltd. (http://www.magpleasure.com)
 * @license    http://www.magpleasure.com/LICENSE-CE.txt
 */
class Magpleasure_Activecontent_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('acSliderGrid');
        $this->setDefaultSort('slider_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        /** @var Magpleasure_Activecontent_Model_Mysql4_Slider_Collection $collection */
        $collection = Mage::getModel('activecontent/slider')->getCollection();

        if ($this->_helper()->getCommon()->getMagento()->isEnteprise()){

            $storeIds = $this->_helper()->getCommon()->getStore()->getFrontendStoreIds();
            $collection->addStoreFilter($storeIds);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Helper
     *
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    protected function _prepareColumns()
    {
        $this->addColumn('slider_id', array(
            'header' => $this->_helper()->__('ID'),
            'align' => 'left',
            'index' => 'slider_id',
            'width' => 50,
            'type' => 'number'
        ));

        $this->addColumn('name', array(
            'header' => $this->_helper()->__('Name'),
            'index' => 'name',
            'type' => 'text',
        ));

        $this->addColumn('size', array(
            'header' => $this->_helper()->__('Size'),
            'index' => 'size',
            'type' => 'text',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'Magpleasure_Activecontent_Block_Adminhtml_Widget_Grid_Column_Renderer_Size',
        ));

        $this->addColumn('status', array(
            'header' => $this->_helper()->__('Status'),
            'align' => 'left',
            'width' => '160px',
            'index' => 'status',
            'type' => 'options',
            'options' => Mage::getModel('activecontent/slider')->getStatusesArray(),
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('stores', array(
                'header' => $this->_helper()->__('Store View'),
                'index' => 'stores',
                'sortable' => true,
                'type' => 'store',
                'store_view' => true,
                'renderer' => 'Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Store',
                'filter_condition_callback' => array($this, '_filterStoresCondition')
            ));
        }

        $this->addColumn('created_at', array(
            'header' => $this->_helper()->__('Created at'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('updated_at', array(
            'header' => $this->_helper()->__('Updated at'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('action',
            array(
                'header' => $this->__('Action'),
                'width' => '80',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => $this->_helper()->__('Edit'),
                        'url' => array('base' => '*/*/edit'),
                        'field' => 'id',
                    ),
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
            ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('slider_id');
        $this->setMassactionIdFieldOnlyIndexValue(true);
        $this->getMassactionBlock()->setFormFieldName('sliders');

        $this->getMassactionBlock()->addItem('duplicate', array(
            'label' => $this->_helper()->__('Duplicate'),
            'url' => $this->getUrl('*/*/massDuplicate'),
        ));

        $this->getMassactionBlock()->addItem('update_status', array(
            'label' => $this->_helper()->__('Update Status'),
            'url' => $this->getUrl('*/*/massStatus'),
            'additional' => array(
                'status' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => $this->__('Status'),
                    'values' => Mage::getModel('activecontent/slider')->getStatusesArray(),
                ))));

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->_helper()->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => $this->__('Are you sure?')
        ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid');
    }

    public function getRowUrl($item)
    {
        return $this->getUrl('*/*/edit', array('id' => $item->getSliderId()));
    }

    protected function _filterStoresCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }

}