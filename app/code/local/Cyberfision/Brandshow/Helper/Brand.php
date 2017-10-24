<?php
class Cyberfision_Brandshow_Helper_Brand extends Mage_Core_Helper_Abstract
{
    public function getBrandUrl(Cyberfision_Brand_Model_Brand $brand)
    {
        if (!$brand instanceof Cyberfision_Brand_Model_Brand) {
            return '#';
        }
        
        return $this->_getUrl(
            'cyberfision_brandshow/index/view',
            array(
                'url' => $brand->getUrlKey(),
            )
        );
    }
}