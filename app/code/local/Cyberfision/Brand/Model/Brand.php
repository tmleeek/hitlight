<?php
class Cyberfision_Brand_Model_Brand extends Mage_Core_Model_Abstract
{
    const VISIBILITY_HIDDEN = '0';
    const VISIBILITY_DIRECTORY = '1';

    protected  function _construct()
    {
        $this->_init('cyberfision_brand/brand');
    }

    public function _beforeSave()
    {
        parent::_beforeSave();
        $this->_updateTimestamps();
        $this->_prepareUrlKey();
        return $this;
    }

    public function _updateTimestamps()
    {
        $timestamp = now();
        $this->setUpdatedAt($timestamp);
        if ($this->isObjectNew()) {
            $this->setCreatedAt($timestamp);
        }
        return $this;
    }

    public function _prepareUrlKey()
    {
        return $this;
    }
}
?>