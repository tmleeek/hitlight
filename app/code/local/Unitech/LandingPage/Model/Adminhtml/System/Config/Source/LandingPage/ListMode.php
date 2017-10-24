<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Adminhtml_System_Config_Source_LandingPage_ListMode
{
    public function toOptionArray()
    {
        return array(
            //array('value'=>'grid', 'label'=>Mage::helper('adminhtml')->__('Grid Only')),
            array('value'=>'list', 'label'=>Mage::helper('adminhtml')->__('List Only')),
            //array('value'=>'grid-list', 'label'=>Mage::helper('adminhtml')->__('Grid (default) / List')),
            //array('value'=>'list-grid', 'label'=>Mage::helper('adminhtml')->__('List (default) / Grid')),
        );
    }
}
