<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Block_List extends Mage_Core_Block_Template
{
     /**
     * Default toolbar block name
     *
     * @var string
     */
    protected $_defaultToolbarBlock = 'unitech_landingpage/list_toolbar';

    protected $_landingPageCollection;

    /**
     * Retrieve landingpage collection
     *
     * @return Unitech_LandingPage_Model_Resource_LandingPage_Collection
     */
    protected function _getLandingPageCollection()
    {
        if (is_null($this->_landingPageCollection)) {
            $this->_landingPageCollection = Mage::getResourceModel('unitech_landingpage/landingPage_collection')
                                    ->distinct(true)
                                    ->addStoreFilter(Mage::app()->getStore()->getId())
                                    ->addFieldToFilter('status', Unitech_LandingPage_Model_Status::STATUS_ENABLED);
        }

        return $this->_landingPageCollection;
    }

    /**
     * Retrieve loaded landingpage collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getLandingPageCollection()
    {
        return $this->_getLandingPageCollection();
    }

    /**
     * Prepare global layout
     *
     * @return Unitech_LandingPage_Block_List
     */
    protected function _prepareLayout()
    {
        $helper = Mage::helper('unitech_landingpage');
        $title = $helper->getDefaultTitle() ? $helper->getDefaultTitle() : $helper->__('Bestsellers');
        // show breadcrumbs
        if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbs->addCrumb(
                'home', 
                array(
                    'label'=>$helper->__('Home'), 
                    'title'=>$helper->__('Go to Home Page'),
                    'link'=>Mage::getBaseUrl()
                )
            );
            $breadcrumbs->addCrumb(
                'landingpage_list', 
                array('label'=>$title, 'title'=>$title)
            );
        }

        $head = $this->getLayout()->getBlock('head');
        if ($head) {
            $head->setTitle($title);
            $head->setKeywords($helper->getDefaultMetaKeywords());
            $head->setDescription($helper->getDefaultMetaDescription());
        }

        return parent::_prepareLayout();
    }

    /**
     * Set collection to toolbar.
     *
     * return Unitech_LandingPage_Block_List
     */
    protected function _beforeToHtml()
    {
        $toolbar = $this->getToolbarBlock();

        // called prepare sortable parameters
        $collection = $this->_getLandingPageCollection();

        // use sortable parameters
        if ($orders = $this->getAvailableOrders()) {
            $toolbar->setAvailableOrders($orders);
        }
        if ($sort = $this->getSortBy()) {
            $toolbar->setDefaultOrder($sort);
        }
        if ($dir = $this->getDefaultDirection()) {
            $toolbar->setDefaultDirection($dir);
        }
        if ($modes = $this->getModes()) {
            $toolbar->setModes($modes);
        }

        // set collection to toolbar and apply sort
        $toolbar->setCollection($collection);

        $this->setChild('toolbar', $toolbar);

        return parent::_beforeToHtml();
    }

     /**
     * Retrieve Toolbar block
     *
     * @return Unitech_Landingpage_Block_List_Toolbar
     */
    public function getToolbarBlock()
    {
        if ($blockName = $this->getToolbarBlockName()) {
            if ($block = $this->getLayout()->getBlock($blockName)) {
                return $block;
            }
        }
        $block = $this->getLayout()->createBlock($this->_defaultToolbarBlock, microtime());
        return $block;
    }

    /**
     * Retrieve list toolbar HTML
     *
     * @return string
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('toolbar');
    }

    public function setCollection($collection)
    {
        $this->_landingPageCollection = $collection;
        return $this;
    }

    /**
     * Get landing page URL
     *
     * @param Unitech_LandingPage_Model_LandingPage $landingPage
     * @return string
     */
    public function getItemUrl($landingPage)
    {
        $helper = Mage::helper('unitech_landingpage');
        /* @var $helper Unitech_LandingPage_Helper_Data */
        return $helper->getLandingPageUrl($landingPage);
    }
}