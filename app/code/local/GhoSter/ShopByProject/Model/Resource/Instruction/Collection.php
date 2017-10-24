<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/10/16
 * Time: 3:51 PM
 */

class GhoSter_ShopByProject_Model_Resource_Instruction_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    public function _construct()
    {
        $this->_init('ghoster_shopbyproject/instruction');
    }
}
