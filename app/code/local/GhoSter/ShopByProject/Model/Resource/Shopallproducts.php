<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/12/16
 * Time: 9:36 AM
 */

class GhoSter_ShopByProject_Model_Resource_Shopallproducts extends Mage_Core_Model_Resource_Db_Abstract {
    /**
     * Initialize resource
     *
     */
    protected function _construct()
    {
        $this->_init('ghoster_shopbyproject/product', 'id');
    }
}
