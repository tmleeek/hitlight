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
 * @category    Magegiant
 * @package     Magegiant_Onestepcheckout
 * @copyright   Copyright (c) 2012 Magegiant (http://www.magegiant.com/)
 * @license     http://www.magegiant.com/license-agreement.html
 */
class Magegiant_Onestepcheckout_Block_Onestep_Form_Review_Terms extends Mage_Core_Block_Template
{
    protected $_helper;

    public function __construct()
    {
        $this->_helper = Mage::helper('onestepcheckout/config');

        return parent::__construct();
    }

    public function canShow()
    {
        if (!$this->_helper->isEnabledTerm()) {
            return false;
        }

        return true;
    }

    public function getAgreements()
    {
        $agreements   = array();
        $agree_config = array(
            'id'            => 'giant_osc_term',
            'checkbox_text' => $this->_helper->getTermCheckboxText(),
            'title'         => $this->_helper->getTermTitle(),
            'content'       => $this->_helper->getTermContent(),
        );
        $agreements[] = new Varien_Object($agree_config);

        return $agreements;
    }
}