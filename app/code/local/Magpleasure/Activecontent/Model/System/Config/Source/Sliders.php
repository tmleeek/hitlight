<?php

/**
 * MagPleasure Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE-CE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magpleasure.com/LICENSE-CE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * MagPleasure does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Magpleasure does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   MagPleasure
 * @package    Magpleasure_Activecontent
 * @version    1.1.3
 * @copyright  Copyright (c) 2011-2014 MagPleasure Ltd. (http://www.magpleasure.com)
 * @license    http://www.magpleasure.com/LICENSE-CE.txt
 */
class Magpleasure_Activecontent_Model_System_Config_Source_Sliders
{
    /**
     * Common Helper
     *
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    public function toOptionArray()
    {
        $sliders = array();
        $storeIds = $this->_helper()->getCommon()->getStore()->getFrontendStoreIds();

        /** @var Magpleasure_Activecontent_Model_Mysql4_Slider_Collection $collection */
        $collection = Mage::getModel('activecontent/slider')->getCollection();
        $collection
            ->addStoreFilter($storeIds)
            ->setOrder('name', 'ASC')
            ;

        $sliders[] = array(
            'label' => $this->_helper()->__("Select a slider..."),
            'value' => ''
        );

        foreach ($collection as $slider) {
            $sliders[] = (array(
                'label' => $slider->getName(),
                'value' => $slider->getId()
            ));
        }

        return $sliders;
    }
}