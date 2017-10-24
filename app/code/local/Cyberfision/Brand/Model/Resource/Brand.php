<?php
class Cyberfision_Brand_Model_Resource_Brand extends Mage_Core_Model_Resource_Db_Abstract
{
    protected  function _construct()
    {
        $this->_init('cyberfision_brand/brand', 'entity_id');
    }
}
?>