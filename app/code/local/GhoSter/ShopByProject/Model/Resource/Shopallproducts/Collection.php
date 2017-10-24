<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/12/16
 * Time: 9:37 AM
 */

class GhoSter_ShopByProject_Model_Resource_Shopallproducts_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    /**
     * Initialize collection
     *
     */
    public function _construct()
    {
        $this->_init('ghoster_shopbyproject/shopallproducts');
    }
}
