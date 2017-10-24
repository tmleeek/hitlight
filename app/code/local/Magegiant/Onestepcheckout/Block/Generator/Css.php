<?php

/**
 * Magegiant
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magegiant.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magegiant.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Magegiant
 * @package    Magegiant_Onestepcheckout
 * @version    3.0.0
 * @copyright   Copyright (c) 2012 Magegiant (http://www.magegiant.com/)
 * @license     http://www.magegiant.com/license-agreement.html
 */
class Magegiant_Onestepcheckout_Block_Generator_Css extends Mage_Core_Block_Template
{
    protected $_helper;

    public function __construct()
    {
        $this->_helper = Mage::helper('onestepcheckout/config');

        return parent::__construct();
    }

    public function getFieldColspan($attribute_code)
    {
        return Mage::getModel('onestepcheckout/attribute')->getFieldColspanByCode($attribute_code);
    }
}