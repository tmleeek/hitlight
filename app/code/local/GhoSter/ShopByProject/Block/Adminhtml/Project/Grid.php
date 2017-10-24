<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 2:26 PM
 */
class GhoSter_ShopByProject_Block_Adminhtml_Project_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('project_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);

    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ghoster_shopbyproject/project')->getCollection();

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('ghoster_shopbyproject')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'type' => 'number',
            'index' => 'id',
        ));

        $this->addColumn("project_image", array(
            "header" => Mage::helper("ghoster_shopbyproject")->__("Project Image"),
            "index" => "project_image",
            'width' => '160px',
            'filter' => false,
            'renderer' => 'GhoSter_ShopByProject_Block_Adminhtml_Project_Grid_Renderer_Thumbnail',
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('ghoster_shopbyproject')->__('Title'),
            'index' => 'title',
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('ghoster_shopbyproject')->__('Created At'),
            'index' => 'created_at',
            'type' => 'datetime',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('ghoster_shopbyproject')->__('Status'),
            'index' => 'status',
            'type' => 'options',
            'options' => self::getStatusOption(),
        ));


        $this->addColumn('action',
            array(
                'header'         => Mage::helper('ghoster_shopbyproject')->__('Action'),
                'width'          => '170px',
                'align'          => 'center',
                'filter'         => false,
                'sortable'       => false,
                'frame_callback' => array($this, 'showActions')
            ))
        ;

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');

        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('remove_project', array(
            'label' => Mage::helper('ghoster_shopbyproject')->__('Remove Project'),
            'url' => $this->getUrl('*/adminhtml_project/massRemove'),
            'confirm' => Mage::helper('ghoster_shopbyproject')->__('Are you sure you want to delete the selected Project(s)?')
        ));

        return $this;
    }


    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }


    /**
     * Get Status Options
     *
     * @return array
     */
    static public function getStatusOption()
    {
        $data_array = [];
        $data_array[0] = Mage::helper('ghoster_shopbyproject')->__('Disabled');
        $data_array[1] = Mage::helper('ghoster_shopbyproject')->__('Enabled');

        return ($data_array);
    }


    public function showActions($value, $row, $column)
    {
        $html = "";
        $html .= '<a style="margin-right: 5px" href="' . $this->getUrl('*/*/edit', array('id' => $row->getId())) . '"><span>' . Mage::helper('ghoster_shopbyproject')->__('Edit') . '</span></a>';
        $html .= '<a style="margin-left: 5px" href="' . $this->getUrl('*/*/delete', array('id' => $row->getId())) . '" onclick="return confirm(\'Are you sure you want to delete the selected Project(s)?\')"><span>' . Mage::helper('ghoster_shopbyproject')->__('Delete') . '</span></a>';
        return $html;
    }
}
