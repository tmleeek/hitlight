<?php
class Cyberfision_Brandshow_Block_List extends Mage_Core_Block_Template
{
    public function getBrandCollection()
    {
        return Mage::getModel('cyberfision_brand/brand')->getCollection()
            ->setOrder('ordert','ASC');
    }
}