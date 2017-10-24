<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/15/16
 * Time: 2:53 PM
 */
class Cyberfision_Custom_Block_Homepage_Banner extends Mage_Core_Block_Template
{
    public function __construct(array $args)
    {
        parent::__construct($args);
        $this->setStoreConfig(Mage::helper('cyberfision_custom')->getStoreConfig());

        return $this;
    }
}
