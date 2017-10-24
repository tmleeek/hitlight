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
class Magpleasure_Activecontent_Block_Adminhtml_System_Config_Form_Element_Size
    extends Mage_Adminhtml_Block_Template
{
    const TYPE_NONE = 'none';

    protected $_index;
    protected $_value;
    protected $_dimensionIndex;

    /**
     * @param $dimensionIndex
     * @return $this
     */
    public function setDimensionIndex($dimensionIndex)
    {
        $this->_dimensionIndex = $dimensionIndex;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDimensionIndex()
    {
        return $this->_dimensionIndex;
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('mp_activecontent/form/element/size_type.phtml');
    }

    /**
     * @param $fieldValue
     * @return $this
     */
    public function setValue($fieldValue)
    {
        $this->_value = $fieldValue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @param $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->_index = $index;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->_index;
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

    public function getList()
    {
        return array(
            self::TYPE_NONE => $this->_helper()->__("None"),
            '%' => $this->_helper()->__("%"),
            'px' => $this->_helper()->__("px"),
            'in' => $this->_helper()->__("in"),
            'cm' => $this->_helper()->__("cm"),
            'mm' => $this->_helper()->__("mm"),
            'em' => $this->_helper()->__("em"),
            'ex' => $this->_helper()->__("ex"),
            'pt' => $this->_helper()->__("pt"),
            'pc' => $this->_helper()->__("pc"),
        );
    }

    public function getNoneType()
    {
        return self::TYPE_NONE;
    }
}