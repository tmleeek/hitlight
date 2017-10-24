<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/11/16
 * Time: 2:00 PM
 */
class GhoSter_ShopByProject_Model_Resource_Slide_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Initialize collection
     *
     */
    public function _construct()
    {
        $this->_init('ghoster_shopbyproject/slide');
    }
}
