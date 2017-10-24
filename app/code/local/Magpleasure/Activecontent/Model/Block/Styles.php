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

class Magpleasure_Activecontent_Model_Block_Styles extends Magpleasure_Activecontent_Model_Block_Abstract
{
    public function getOptionArray()
    {
        return array(
            'default' => $this->_helper()->__("Default"),
            'emerald' => $this->_helper()->__("Emerald"),
            'glass' => $this->_helper()->__("Glass"),
            'simple' => $this->_helper()->__("Simple"),
            'shuffle' => $this->_helper()->__("Shuffle"),
            'metro' => $this->_helper()->__("Metro"),
            'zoom' => $this->_helper()->__("Zoom"),
            'shady' => $this->_helper()->__("Shady"),
            'elegant' => $this->_helper()->__("Elegant"),
            'subway' => $this->_helper()->__("Subway"),
            'studio' => $this->_helper()->__("Studio"),
        );
    }
}