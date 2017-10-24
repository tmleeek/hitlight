<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */
class Unitech_LandingPage_Helper_View extends Mage_Core_Helper_Abstract
{
    /**
     * Inits landing page to be used for landing page controller actions and layouts
     *
     * @param int $landingPageId
     *
     * @return false|Unitech_LandingPage_Model_LandingPage
     */
    public function initLandingPage($landingPageId)
    {
        if (!$landingPageId) {
            return false;
        }

        $landingPage = Mage::getModel('unitech_landingpage/landingPage')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($landingPageId);

        // Register current data
        Mage::register('landingpage', $landingPage);
        return $landingPage;
    }
}