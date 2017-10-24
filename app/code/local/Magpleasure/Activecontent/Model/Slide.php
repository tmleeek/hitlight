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

/** @method Magpleasure_Activecontent_Model_Mysql4_Slide getResource  */
class Magpleasure_Activecontent_Model_Slide extends Magpleasure_Common_Model_Abstract
{
    /**
     * Status Enabled
     */
    const STATUS_ENABLED = 1;

    /**
     * Status Disabled
     */
    const STATUS_DISABLED = 0;

    /**
     * Status Hidden
     */
    const STATUS_HIDDEN = 6;

    /**
     * Path in registry
     */
    const PATH_IN_REGISTRY = 'activecontent_slide_data';

	protected function _construct()
    {
        $this->_init('activecontent/slide');
    }

    /**
     * Helper
     *
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    /**
     * Retrives statuses array
     * @return array
     */
    public function getStatusArray()
    {
        $helper = Mage::helper('activecontent');
        return array(
            self::STATUS_ENABLED => $this->_helper()->__('Enabled'),
            self::STATUS_DISABLED => $this->_helper()->__('Disabled'),
        );
    }

    public function getFilterStatusArray()
    {
        $statuses = $this->getStatusArray();
        $statuses[self::STATUS_ENABLED] = $this->_helper()->__('Visible');
        $statuses[self::STATUS_HIDDEN] = $this->_helper()->__('Hidden');
        return $statuses;
    }

    public function duplicate()
    {
        $this
            ->setData('created_at', null)
            ->setData('updated_at', null)
            ->setData('slide_id', null)
            ->save()
        ;

        return $this;
    }

}