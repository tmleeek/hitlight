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

class Magpleasure_Activecontent_Block_Slider
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{
    const TEMPLATE_PATH = 'mp_activecontent/slider.phtml';

    const DEFAULT_WIDTH = '685';
    const DEFAULT_HEIGHT = '200';
    const DEFAULT_SIZE_TYPE = 'px';

    const CACHE_PREFIX = 'activecontent_slider_';

    protected $_slider;
    protected $_slides = array();
    protected $_blockId;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(self::TEMPLATE_PATH);
    }

    /**
     * Helper
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    /**
     * Block
     *
     * @return Magpleasure_Activecontent_Model_Slider
     */
    public function getSlider()
    {
        if (!$this->_slider){

            if ($sliderId = $this->_getData('slider_id')){

                /** @var Magpleasure_Activecontent_Model_Slider $slider  */
                $slider = Mage::getModel('activecontent/slider')->load($sliderId);

                if (Mage::app()->isSingleStoreMode()){
                    $canDisplayInThisStore = true;
                } else {
                    $canDisplayInThisStore = in_array(Mage::app()->getStore()->getId(), $slider->getStores());
                }

                if ($slider->isEnabled() && $canDisplayInThisStore){
                    $this->_slider = $slider;
                }

            } elseif ($code = $this->_getData('code')){

                /** @var Magpleasure_Activecontent_Model_Mysql4_Slider_Collection $block  */
                $sliderCollection = Mage::getModel('activecontent/slider')->getCollection();
                $sliderCollection
                    ->addFieldToFilter('status', Magpleasure_Activecontent_Model_Slider::STATUS_ENABLED)
                    ->addFieldToFilter('code', $code)
                    ;

                if (!Mage::app()->isSingleStoreMode()){
                    $sliderCollection->addStoreFilter(Mage::app()->getStore()->getId());
                }

                foreach ($sliderCollection as $slider){

                    if ($slider->getId()){
                        $slider->load($slider->getId());

                        if (Mage::app()->isSingleStoreMode()){
                            $this->_slider = $slider;
                            break;
                        } else {
                            if (in_array(Mage::app()->getStore()->getId(), $slider->getStores())){
                                $this->_slider = $slider;
                                break;
                            }
                        }
                    }
                }
            }
        }
        return $this->_slider;
    }

    public function getStyleName()
    {
        return $this->getSlider() ? $this->getSlider()->getStyle() : false;
    }

    public function getUseSize()
    {
        return $this->getSlider()->getUseSize();
    }

    public function getWidth()
    {
        return $this->getSlider()->getWidth() ? $this->getSlider()->getWidth() : self::DEFAULT_WIDTH;
    }

    public function getHeight()
    {
        return $this->getSlider()->getHeight() ? $this->getSlider()->getHeight() : self::DEFAULT_HEIGHT;
    }

    public function getWidthType()
    {
        return $this->getSlider()->getWidthType() ? $this->getSlider()->getWidthType() : self::DEFAULT_SIZE_TYPE;
    }

    public function getHeightType()
    {
        return $this->getSlider()->getHeightType() ? $this->getSlider()->getHeightType() : self::DEFAULT_SIZE_TYPE;
    }

    /**
     * Not every easing function could be defined through CSS3
     *
     * @return string
     */
    public function getTimingFunction()
    {
        /** @var Magpleasure_Activecontent_Model_Block_Easing $easing */
        $easing = Mage::getSingleton('activecontent/block_easing');
        $timing = $easing->getTimingFunctionByEasing($this->getSliderData('easing'));
        return $timing ? "'".$timing."'" : 'false';
    }

    public function getSizeCSS()
    {
        $css = "";
        if (
            $this->getHeightType() !==
            Magpleasure_Activecontent_Block_Adminhtml_System_Config_Form_Element_Size::TYPE_NONE
        ){
            $css .= sprintf("height: %s%s; ", $this->getHeight(), $this->getHeightType());
        }

        if (
            $this->getWidthType() !==
            Magpleasure_Activecontent_Block_Adminhtml_System_Config_Form_Element_Size::TYPE_NONE
        ){
            $css .= sprintf("width: %s%s; ", $this->getWidth(), $this->getWidthType());
        }

        return $css;
    }

    /**
     * Slides
     *
     * @return array
     */
    public function getSlideCollection()
    {
        if (!$this->_slides){

            if ($this->getSlider()){
                /** @var Magpleasure_Activecontent_Model_Mysql4_Slide_Collection $collection */
                $collection = $this->getSlider()->getSlideCollection();
                if ($collection){

                    $collection->addVisibilityFilter();
                    $collection->getSelect()->order('position ASC');
                }

                $this->_slides = $collection;
            } else {
                $this->_slides = array();
            }
        }
        return $this->_slides;
    }

    /**
     * Display controls
     *
     * @return bool
     */
    public function getDisplayWithControls()
    {
        return (count($this->getSlideCollection()) > 1);
    }

    public function getIsEnabled()
    {
        return $this->getSlider() && $this->getSlider()->isEnabled();
    }

    public function getStyleCss()
    {
        if ($slider = $this->getSlider()){

            if ($style = $slider->getStyle()){

                return Mage::getBaseUrl('js')."mp_activecontent/frontend/styles/{$style}/style.css";
            }
        }

        return 'default';
    }

    public function getContent($slider)
    {
        return $this->_helper()->prepareCmsContent($slider->getSlideContent());
    }

    public function getSliderData($key)
    {
        return $this->getSlider()->getData($key);
    }

    public function getSliderBoolData($key)
    {
        return ($this->getSlider()->getData($key) && $this->getDisplayWithControls()) ? 'true' : 'false';
    }

    public function getBlockId()
    {
        if (!$this->_blockId){
            $this->_blockId = $this->getSlider()->getCode().md5(rand());
        }
        return $this->_blockId;
    }

    public function getCacheKey()
    {
        $params = array();
        if ($sliderId = $this->_getData('slider_id')){

            $params[] = $sliderId;

        } elseif ($code = $this->_getData('code')){

            $params[] = $code;
        }
        $params[] = Mage::app()->getStore()->getId();

        return self::CACHE_PREFIX.md5(implode("_", $params));
    }

    protected function _beforeToHtml()
    {
        $this->addData(array(
            'cache_lifetime'    => 60,
            'cache_tags'        => array(
                Magpleasure_Common_Helper_Cache::MAGPLEASURE_CACHE_KEY,
                'CONFIG',
                'ACTIVE_CONTENT',
            ),
            'cache_key'         => $this->getCacheKey(),
        ));

        parent::_beforeToHtml();
    }
}