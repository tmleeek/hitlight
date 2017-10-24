<?php

/**
 * @author Evince Team
 
 */
class Evince_Customattribute_Model_Mysql4_Relation extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
    {
        $this->_init('customattribute/relation', 'id');
    }
}
