<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */
class Unitech_LandingPage_Model_Status extends Varien_Object
{
    const STATUS_ENABLED    = 1;
    const STATUS_DISABLED    = 0;

    static public function getAllOptions()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('unitech_landingpage')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('unitech_landingpage')->__('Disabled')
        );
    }
}