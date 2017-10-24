<?php
class Hil_Slider_Model_Mysql4_Slider extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init("slider/slider", "id");
    }
}