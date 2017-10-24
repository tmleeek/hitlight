<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Block_Adminhtml_LandingPage extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
    * Initialize landing page manage page
    *
    * @return void
    */
    public function __construct()
    {
        $this->_controller = 'adminhtml_landingPage';
        $this->_blockGroup = 'unitech_landingpage';
        $this->_headerText = Mage::helper('unitech_landingpage')->__('Manage Landing Page');
        $this->_addButtonLabel = Mage::helper('unitech_landingpage')->__('Add Landing Page');
        parent::__construct();
    }
}