<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 12:51 PM
 */
class GhoSter_ShopByProject_Model_Resource_Commonproduct_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Initialize collection
     *
     */
    public function _construct()
    {
        $this->_init('ghoster_shopbyproject/commonproduct');
    }
}
