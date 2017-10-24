<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Block_Adminhtml_LandingPage_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set defaults
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('landingPageGrid');
        $this->setDefaultSort('landingpage_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Instantiate and prepare collection
     *
     * @return Unitech_LandingPage_Block_Adminhtml_LandingPage_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('unitech_landingpage/landingPage_collection');
        if (!Mage::app()->isSingleStoreMode()) {
            $collection->addStoresVisibility();
        }
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Define grid columns
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'landingpage_id', 
            array(
                'header'=> Mage::helper('unitech_landingpage')->__('ID'),
                'type'  => 'number',
                'width' => '1',
                'index' => 'landingpage_id',
            )
        );

        $this->addColumn(
            'landingpage_title', 
            array(
                'header' => Mage::helper('unitech_landingpage')->__('Page Title'),
                'type'   => 'text',
                'index'  => 'title',
            )
        );

        $this->addColumn(
            'landingpage_update_time', 
            array(
                'header' => Mage::helper('unitech_landingpage')->__('Last Updated'),
                'type'   => 'datetime',
                'index'  => 'update_time',
            )
        );


        $this->addColumn(
            'landingpage_status', 
            array(
                'header'  => Mage::helper('unitech_landingpage')->__('Status'),
                'align'   => 'center',
                'width'   => 1,
                'index'   => 'status',
                'type'    => 'options',
                'options' => Mage::getModel('unitech_landingpage/status')->getAllOptions(),
            )
        );

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn(
                'visible_in', 
                array(
                    'header'     => Mage::helper('unitech_landingpage')->__('Visible In'),
                    'type'       => 'store',
                    'index'      => 'stores',
                    'sortable'   => false,
                    'store_view' => true,
                    'width'      => 200
                )
            );
        }

        $this->addColumn(
            'action',
            array(
                'header'  => Mage::helper('unitech_landingpage')->__('Action'),
                'width'   => '50',
                'type'    => 'action',
                'align'   => 'center',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('unitech_landingpage')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
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

    /**
     * Prepare mass action options for this grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('landingpage_id');
        $this->getMassactionBlock()->setFormFieldName('landingpage');

        $this->getMassactionBlock()->addItem(
            'delete', 
            array(
                'label'   => Mage::helper('unitech_landingpage')->__('Delete'),
                'url'     => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('unitech_landingpage')->__(
                    'Are you sure you want to delete these landing page(s)?'
                )
            )
        );

        return $this;
    }

    /**
     * Grid row URL getter
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getLandingpageId()));
    }

    /**
     * Define row click callback
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * Add store filter
     *
     * @param Mage_Adminhtml_Block_Widget_Grid_Column  $column
     * @return Unitech_LandingPage_Block_Adminhtml_LandingPage_Grid
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getIndex() == 'stores') {
            $this->getCollection()->addStoreFilter($column->getFilter()->getCondition(), false);
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}