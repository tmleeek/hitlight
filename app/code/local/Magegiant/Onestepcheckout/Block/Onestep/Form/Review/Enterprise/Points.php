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

class Magegiant_Onestepcheckout_Block_Onestep_Form_Review_Enterprise_Points extends Mage_Checkout_Block_Onepage_Abstract
{
    public function canShow()
    {
        if (Mage::helper('onestepcheckout/enterprise_points')->isPointsEnabled()) {
            return true;
        }
        return false;
    }

    public function isPointsSectionAvailable()
    {
        return Mage::helper('onestepcheckout/enterprise_points')->isPointsSectionAvailable();
    }

    public function getPointsUnitName()
    {
        return Mage::helper('onestepcheckout/enterprise_points')->getPointsUnitName();
    }

    public function getSummaryForCustomer()
    {
        return Mage::helper('onestepcheckout/enterprise_points')->getSummaryForCustomer();
    }

    public function getMoneyForPoints()
    {
        return Mage::helper('onestepcheckout/enterprise_points')->getMoneyForPoints();
    }

    public function useRewardPoints()
    {
        return Mage::helper('onestepcheckout/enterprise_points')->useRewardPoints();
    }

    public function getMaxAvailablePointsAmount()
    {
        return min($this->getSummaryForCustomer()->getPoints(), $this->getNeededPoints(), $this->getLimitedPoints());
    }

    public function getApplyPointsAjaxUrl()
    {
        return Mage::getUrl('onestepcheckout/ajax/applyEnterprisePoints', array('_secure' => true));
    }
}