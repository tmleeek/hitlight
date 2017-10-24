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

/** @method Magpleasure_Activecontent_Model_Mysql4_Slider getResource */

class Magpleasure_Activecontent_Model_Slider extends Magpleasure_Common_Model_Abstract
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Path in registry
     */
    const PATH_IN_REGISTRY = 'slider_data';

    /**
     * Class constructor
     */
	protected function _construct()
    {
        $this->_init('activecontent/slider');
    }

    /**
     * Retrives statuses array
     * @return array
     */
    public function getStatusesArray()
    {
        $helper = Mage::helper('activecontent');
        return array(
            self::STATUS_ENABLED => $helper->__('Enabled'),
            self::STATUS_DISABLED => $helper->__('Disabled'),
        );
    }

    public function getSlideCollection()
    {
        /** @var Magpleasure_Activecontent_Model_Mysql4_Slide_Collection $collection */
        $collection = Mage::getModel('activecontent/slide')->getCollection();
        $collection->addFieldToFilter('slider_id', $this->getId());

        return $collection;
    }

    public function duplicate()
    {
        $previousSliderId = $this->getId();

        $this
            ->setData('created_at', null)
            ->setData('updated_at', null)
            ->setData('slider_id', null)
            ->save()
        ;

        $newSliderId = $this->getId();
        $this->getResource()->copySlides($previousSliderId, $newSliderId);

        return $this;
    }

    public function isEnabled()
    {
        return $this->getStatus() == self::STATUS_ENABLED;
    }
}