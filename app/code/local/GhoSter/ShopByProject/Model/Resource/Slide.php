<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/11/16
 * Time: 1:59 PM
 */

class GhoSter_ShopByProject_Model_Resource_Slide extends Mage_Core_Model_Resource_Db_Abstract {
    /**
     * Initialize resource
     *
     */
    protected function _construct()
    {
        $this->_init('ghoster_shopbyproject/slide', 'slide_id');
    }
}
