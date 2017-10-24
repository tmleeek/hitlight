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

class Magpleasure_Activecontent_Block_Adminhtml_Slide_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_slider;

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('activecontentSlideGrid');
        $this->setDefaultSort('position_grid');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    protected function _getParams()
    {
        $params = array(
            'id' => $this->getSlider()->getId(),
        );

        return $params;
    }

    /**
     * Helper
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    protected function getSlider()
    {
        if (!$this->_slider){

            $sliderId = $this->getRequest()->getParam('id');

            if ($sliderId){

                /** @var Magpleasure_Activecontent_Model_Slider $slider */
                $slider = Mage::getModel('activecontent/slider');
                $slider->load($sliderId);
                $this->_slider = $slider;
            }
        }

        return $this->_slider;
    }

    protected function _prepareCollection()
    {
        if ($slider = $this->getSlider()){
            $collection = $slider->getSlideCollection();
            $this->setCollection($collection);
            parent::_prepareCollection();
        }

        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('slide_id_grid', array(
            'header' => $this->__('ID'),
            'align' => 'left',
            'index' => 'slide_id',
            'width' => 50,
            'type' => 'number',
        ));

        $this->addColumn('title_grid', array(
            'header' => $this->__('Title'),
            'index' => 'title',
            'type' => 'text',
            'width' => 100,
        ));

        $this->addColumn('status_grid', array(
            'header' => $this->__('Visibility'),
            'align' => 'left',
            'width' => '160px',
            'index' => 'status',
            'type' => 'options',
            'renderer' => 'Magpleasure_Activecontent_Block_Adminhtml_Widget_Grid_Column_Renderer_Status',
            'options' => Mage::getModel('activecontent/slide')->getFilterStatusArray(),
            'filter_condition_callback' => array($this, '_filterByStatus')
        ));

        $this->addColumn('position_grid', array(
            'header' => $this->__('Position'),
            'align' => 'left',
            'index' => 'position',
            'width' => 50,
            'type' => 'number'
        ));

        $this->addColumn('created_at_grid', array(
            'header' => $this->_helper()->__('Created At'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('updated_at_grid', array(
            'header' => $this->_helper()->__('Updated At'),
            'index' => 'updated_at',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('edit_slide', array(
            'header' => $this->_helper()->__('Edit'),
            'index' => 'slide_id',
            'width' => '100px',
            'is_system' => true,
            'sortable' => false,
            'filter' => false,
            'renderer' => 'Magpleasure_Activecontent_Block_Adminhtml_Widget_Grid_Column_Renderer_Edit',
        ));

        $this->addColumn('delete_slide', array(
            'header' => $this->_helper()->__('Delete'),
            'index' => 'slide_id',
            'width' => '70px',
            'is_system' => true,
            'sortable' => false,
            'filter' => false,
            'renderer' => 'Magpleasure_Activecontent_Block_Adminhtml_Widget_Grid_Column_Renderer_Delete',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('slide_id');
        $this->setMassactionIdFieldOnlyIndexValue(true);
        $this->getMassactionBlock()->setFormFieldName('slides');

        $this->getMassactionBlock()->addItem('duplicate', array(
            'label' => $this->_helper()->__('Duplicate Slides'),
            'url' => $this->getUrl('*/admin_slide/massDuplicate', $this->_getParams()),
        ));

        $this->getMassactionBlock()->addItem('update_status', array(
            'label' => Mage::helper('activecontent')->__('Update Slides Visibility'),
            'url' => $this->getUrl('*/admin_slide/massStatus', $this->_getParams()),
            'additional' => array(
                'status' => array(
                    'name' => 'new_status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => $this->__('Visibility'),
                    'values' => Mage::getModel('activecontent/slide')->getStatusArray(),
                ))));

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete Slides'),
            'url' => $this->getUrl('*/admin_slide/massDelete', $this->_getParams()),
            'confirm' => $this->__('Are you sure?')
        ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/admin_slide/grid', $this->_getParams());
    }

    public function getRowUrl($item)
    {
        $params = $this->_getParams();
        $params['slide_id'] = $item->getSlideId();
        return $this->getUrl('*/admin_slide/edit', $params);
    }

    /**
     * Filter by visibility
     *
     * @param Magpleasure_Activecontent_Model_Mysql4_Slide_Collection $collection
     * @param $column
     */
    protected function _filterByStatus($collection, $column)
    {
        $value = $column->getFilter()->getValue();
        if (is_null($value)) {
            return;
        }

        if ($value == Magpleasure_Activecontent_Model_Slide::STATUS_HIDDEN){

            $collection->addInvisibilityFilter();

        } elseif($value == Magpleasure_Activecontent_Model_Slide::STATUS_ENABLED) {

            $collection->addVisibilityFilter();

        } else {

            $collection->addFieldToFilter('status', Magpleasure_Activecontent_Model_Slide::STATUS_DISABLED);
        }

    }

}