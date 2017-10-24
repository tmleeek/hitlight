<?php

class Cyberfision_HidePrice_Model_Observer
{
    protected $oHidePriceHelper;
    public function __construct()
    {
        $this->oHidePriceHelper = Mage::helper('cyberhideprice');
    }
    public function catalogProductTypePrepareFullOptions($observer){
        if ($this->oHidePriceHelper->isAllow() === false) {
            throw new Mage_Catalog_Exception('Your account is not allowed to access this store.');
        }
    }
}