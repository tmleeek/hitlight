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


class Magegiant_Onestepcheckout_Block_Onestep_Related_Arp2 extends Magegiant_Onestepcheckout_Block_Onestep_Related_Abstract
{

    public function getItems()
    {
        $items = $this->getData('items');
        if (is_null($items)) {
            if ($collection = $this->_getCollection()) {
                $collection->setPageSize($this->_maxItemCount);
                $items = $collection->getItems();
            } else {
                $items = array();
            }
            $this->setData('items', $items);
        }
        return $items;
    }

    protected function _getCollection()
    {
        $storeId = Mage::app()->getStore()->getId();
        $blockId = Mage::helper('onestepcheckout/config')->getAutomaticRelatedRuleId($storeId);

        $collection = $this->_getCollectionFromArp2($blockId, $this->getQuote()->getId());
        return $collection;
    }

    //copy-paste from giant-autorelated api
    protected function _getCollectionFromArp2($blockId, $quoteId)
    {
        return null;
    }

}
