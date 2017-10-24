<?php

class Hil_Slider_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId("sliderGrid");
        $this->setDefaultSort("id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("slider/slider")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn("id", array(
            "header" => Mage::helper("slider")->__("ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "id",
        ));

        $this->addColumn("banner_image", array(
            "header" => Mage::helper("slider")->__("Image"),
            "index" => "banner_image",
            "filter" => false,
            'renderer'  => 'slider/adminhtml_renderer_banner',
        ));

        $this->addColumn("url_banner", array(
            "header" => Mage::helper("slider")->__("Url Banner"),
            "index" => "url_banner",
        ));

        $this->addColumn("desc_banner", array(
            "header" => Mage::helper("slider")->__("Description Banner"),
            "index" => "desc_banner",
        ));

        $this->addColumn("url_ebook", array(
            "header" => Mage::helper("slider")->__("Link e-Book"),
            "index" => "url_ebook",
        ));
        $this->addColumn("desc_ebook", array(
            "header" => Mage::helper("slider")->__("Description e-Book"),
            "index" => "desc_ebook",
        ));
        $this->addColumn('status', array(
            'header' => Mage::helper('slider')->__('Enable'),
            'index' => 'status',
            'type' => 'options',
            'options' => Hil_Slider_Block_Adminhtml_Slider_Grid::getOptionArray5(),
        ));

        $this->addColumn('create_at', array(
            'header' => Mage::helper('slider')->__('Created'),
            'index' => 'create_at',
            'type' => 'datetime',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
    }


    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('remove_slider', array(
            'label' => Mage::helper('slider')->__('Remove Slider'),
            'url' => $this->getUrl('*/adminhtml_slider/massRemove'),
            'confirm' => Mage::helper('slider')->__('Are you sure?')
        ));
        return $this;
    }

    static public function getOptionArray5()
    {
        $data_array = array();
        $data_array['0'] = 'No';
        $data_array['1'] = 'Yes';
        return ($data_array);
    }

    static public function getValueArray5()
    {
        $data_array = array();
        foreach (Hil_Slider_Block_Adminhtml_Slider_Grid::getOptionArray5() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return ($data_array);

    }


}