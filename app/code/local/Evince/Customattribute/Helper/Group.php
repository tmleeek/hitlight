<?php
/**
* @author Evince Team
* @package Evince_Customattribute
*/
class Evince_Customattribute_Helper_Group extends Mage_Core_Helper_Abstract
{
    protected $_isAllowed = false;
    protected $_attribute = 'tax_id';
    protected $_groupId   = 3;
    
    /**
     * Allow autoapply
     *
     * @return boolean
     */
    public function isAllowed()
    {
        return $this->_isAllowed;
    }
    
    /**
     * Retrieve specify validation
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->_attribute;
    }
    
    /**
     * Retrieve customer group id
     *
     * @return string
     */
    public function getGroupId()
    {
        return $this->_groupId;
    }
}