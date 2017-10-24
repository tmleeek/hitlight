<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/10/16
 * Time: 3:50 PM
 */
class GhoSter_ShopByProject_Model_Resource_Instruction extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ghoster_shopbyproject/instruction', 'id');
    }
}
