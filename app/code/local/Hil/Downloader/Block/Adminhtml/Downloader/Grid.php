<?php

class Hil_Downloader_Block_Adminhtml_Downloader_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId("downloaderGrid");
        $this->setDefaultSort("id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("downloader/downloader")->getCollection();
        $collection
            ->getSelect()
            ->columns(
                array(
                    'count_downloader' => 'count(*)',
                    'max_date' => "MAX(`create_at`)"
//                    'group_name' =>'SELECT `customer_group_code` FROM `customer_group` LEFT JOIN `hil_downloader` ON `customer_group`.`customer_group_id` = `hil_downloader`.`customer_group_id` WHERE `customer_group`.`customer_group_id` = `hil_downloader`.`customer_group_id`',
                    ))
            ->group('customer_id');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn("customer_id", array(
            "header" => Mage::helper("downloader")->__("Customer ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "customer_id",
        ));

        $this->addColumn("customer_name", array(
            "header" => Mage::helper("downloader")->__("Customer Name"),
            "index" => "customer_name",
        ));

        $this->addColumn("customer_email", array(
            "header" => Mage::helper("downloader")->__("Customer Email"),
            "index" => "customer_email",
        ));

//        $this->addColumn('customer_group', array(
//            'header' => Mage::helper('downloader')->__('Customer group'),
//            'index' => 'customer_group',
//            'type' => 'options',
//            'options' => Hil_Downloader_Block_Adminhtml_Downloader_Grid::getOptionArray6(),
//        ));

        $this->addColumn("customer_download", array(
            "header" => Mage::helper("downloader")->__("Number of download"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => 'count_downloader',
            'filter' => false,
        ));

        $this->addColumn('create_at', array(
            'header' => Mage::helper('downloader')->__('Date of Download'),
            'index' => 'max_date',
            'type' => 'datetime',
            'filter' => false,
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
//        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
//        $this->getMassactionBlock()->addItem('remove_downloader', array(
//            'label' => Mage::helper('downloader')->__('Remove Downloader'),
//            'url' => $this->getUrl('*/adminhtml_downloader/massRemove'),
//            'confirm' => Mage::helper('downloader')->__('Are you sure?')
//        ));
        return $this;
    }

    static public function getOptionArray6()
    {
        $data_array = array();
        $data_array['0'] = 'No';
        $data_array['1'] = 'Yes';
        return ($data_array);
    }

    static public function getValueArray6()
    {
        $data_array = array();
        foreach (Hil_Downloader_Block_Adminhtml_Downloader_Grid::getOptionArray6() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return ($data_array);

    }
}