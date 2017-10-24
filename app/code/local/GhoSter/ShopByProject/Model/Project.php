<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 12:01 PM
 */ 
class GhoSter_ShopByProject_Model_Project extends Mage_Core_Model_Abstract
{

    CONST PROJECT_TITLE_MAX_LENGTH = 100;


    protected function _construct()
    {
        $this->_init('ghoster_shopbyproject/project');
    }

}
