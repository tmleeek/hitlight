<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Helper_Data extends Mage_Core_Helper_Abstract
{
     const XML_PATH_COLUMN_COUNT = 'unitech_landingpage/frontend/column_count';
     const XML_PATH_DEFAULT_ROUTER = 'unitech_landingpage/frontend/default_router';
     const XML_PATH_DEFAULT_IMAGE = 'unitech_landingpage/frontend/image';
     const XML_PATH_DEFAULT_META_TITLE = 'unitech_landingpage/frontend/meta_title';
     const XML_PATH_DEFAULT_META_KEYWORDS = 'unitech_landingpage/frontend/meta_keywords';
     const XML_PATH_DEFAULT_META_DESCRIPTION = 'unitech_landingpage/frontend/meta_description';

     /**
     * Retrieve default title for landing page
     *
     * @return string
     */
    public function getDefaultTitle()
    {
        return Mage::getStoreConfig(self::XML_PATH_DEFAULT_META_TITLE);
    }

     /**
     * Retrieve default meta keywords for landing page
     *
     * @return string
     */
    public function getDefaultMetaKeywords()
    {
        return Mage::getStoreConfig(self::XML_PATH_DEFAULT_META_KEYWORDS);
    }

     /**
     * Retrieve default meta description for landing page
     *
     * @return string
     */
    public function getDefaultMetaDescription()
    {
        return Mage::getStoreConfig(self::XML_PATH_DEFAULT_META_DESCRIPTION);
    }

     /**
     * Retrieve default banner for landing page
     *
     * @return string
     */
    public function getDefaultImage()
    {
        $file = Mage::getStoreConfig(self::XML_PATH_DEFAULT_IMAGE);
        if (($file) && (0 !== strpos($file, '/', 0))) {
            $file = $this->getBaseMediaUrl().'/' . $file;
        }
        return $file;
    }

    public function getBaseMediaUrl()
    {
        return Mage::getBaseUrl('media') . 'landingpage';
    }

    public function getDefaultRouter()
    {
        return Mage::getStoreConfig(self::XML_PATH_DEFAULT_ROUTER);
    }

    public function getColumnCount()
    {
        return Mage::getStoreConfig(self::XML_PATH_COLUMN_COUNT);
    }

    /**
     * Create landing page url
     *
     * @param   mixed $landingPage
     * @return  string
     */
    public function getLandingPageUrl($landingPage)
    {
        if ($landingPage instanceof Unitech_LandingPage_Model_LandingPage) {
            return Mage::getUrl($this->getDefaultRouter().'/'.$landingPage->getIdentifier());
        } elseif (is_numeric($landingPage)) {
            $identifier = Mage::getModel('unitech_landingpage/landingPage')->load($landingPage)->getIdentifier();
            return Mage::getUrl($this->getDefaultRouter().'/'.$identifier);
        }
        return false;
    }
    
    /**
     * Retrieve Template processor for Block Content
     *
     * @return Varien_Filter_Template
     */
    public function getBlockTemplateProcessor()
    {
        return Mage::getModel('unitech_landingpage/template_filter');
    }
}