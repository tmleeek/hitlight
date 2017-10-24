<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Block_Adminhtml_LandingPage_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize landing page edit page tabs
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('landingpage_info_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('unitech_landingpage')->__('Landing Page Information'));
    }
}