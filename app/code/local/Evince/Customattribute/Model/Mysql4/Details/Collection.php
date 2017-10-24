<?php

/**
 * @author Evince Team
 
 */
class Evince_Customattribute_Model_Mysql4_Details_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('customattribute/details', 'id');
    }
    
    public function getByRelation($relationId)
    {
    	 $this->getSelect()
    	 	->where('relation_id = ?', $relationId);
    	 return $this;
    }
    
    
}
