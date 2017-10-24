<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */
class Unitech_LandingPage_Model_Adminhtml_System_Config_Source_LandingPage_ListSort
{
    /**
     * Retrieve option values array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = array();
        $options[] = array(
            'label' => Mage::helper('unitech_landingpage')->__('Position'),
            'value' => 'sort_order'
        );
        $options[] = array(
                'label' => Mage::helper('unitech_landingpage')->__('Name'),
                'value' => 'title'
            );
        return $options;
    }

    /**
     * Retrieve Landing Page Config Singleton
     *
     * @return Unitech_LandingPage_Model_Config
     */
    protected function _getLandingPageConfig()
    {
        return Mage::getSingleton('unitech_landingpage/config');
    }
}
