<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 12:49 PM
 */

class GhoSter_ShopByProject_Model_Resource_Commonproduct extends Mage_Core_Model_Resource_Db_Abstract {
    /**
     * Initialize resource
     *
     */
    protected function _construct()
    {
        $this->_init('ghoster_shopbyproject/commonproduct', 'id');
    }
}
