<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */
class Unitech_LandingPage_Block_View extends Mage_Core_Block_Template
{
    /**
     * Retrieve landing page instance
     *
     * @return Unitech_LandingPage_Model_LandingPage
     */
    public function getLandingPage()
    {
        $landingPageId = $this->getRequest()->getParam('landingpage_id', false);
        if (!Mage::registry('landingpage') && $landingPageId) {
            $landingPage = Mage::getModel('unitech_landingpage/landingPage')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($landingPageId);
            Mage::register('landingpage', $landingPage);
        }
        return Mage::registry('landingpage');
    }

    /**
     * Prepare global layout
     *
     * @return Unitech_LandingPage_Block_View
     */
    protected function _prepareLayout()
    {
        $landingPage = $this->getLandingPage();
        $helper = Mage::helper('unitech_landingpage');
        // show breadcrumbs
        if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
            $title = $helper->getDefaultTitle() ? $helper->getDefaultTitle() : $helper->__('Bestsellers');
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
                array(
                    'label'=>$title, 
                    'title'=>$title,
                    'link'=>$this->getUrl($helper->getDefaultRouter())
                )
            );
            $breadcrumbs->addCrumb(
                'landingpage_view', 
                array(
                    'label'=>$landingPage->getTitle(), 
                    'title'=>$landingPage->getTitle()
                )
            );
        }

        $head = $this->getLayout()->getBlock('head');
        if ($head) {
            $head->setTitle($landingPage->getTitle());
            $head->setKeywords(
                $landingPage->getMetaKeywords() ? $landingPage->getMetaKeywords() : $helper->getDefaultMetaKeywords()
            );
            $head->setDescription(
                $landingPage->getMetaDescription() ? 
                $landingPage->getMetaDescription() : $helper->getDefaultMetaDescription()
            );
        }

        return parent::_prepareLayout();
    }
}