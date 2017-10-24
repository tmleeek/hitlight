<?php

class Magegiant_Onestepcheckout_Helper_Generator_Css extends Mage_Core_Helper_Abstract
{
    /**
     * Path and directory of the automatically generated CSS
     *
     * @var string
     */
    protected $_generatedCssFolder;
    protected $_generatedCssPath;
    protected $_generatedCssDir;
    protected $_templatePath;

    public function __construct()
    {
        //Create paths
        $this->_generatedCssFolder = 'css/magegiant/onestepcheckout/css/_config/';
        $this->_generatedCssPath   = 'frontend/base/default/' . $this->_generatedCssFolder;
        $this->_generatedCssDir    = Mage::getBaseDir('skin') . '/' . $this->_generatedCssPath;
        $this->_templatePath       = 'magegiant/onestepcheckout/generator/css/';
    }

    /**
     * Get directory of automatically generated CSS
     *
     * @return string
     */
    public function getGeneratedCssDir()
    {
        return $this->_generatedCssDir;
    }

    /**
     * Get path to CSS template
     *
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->_templatePath;
    }

    /**
     * Get file path: CSS design
     *
     * @return string
     */
    public function getDesignFile()
    {
        return $this->_generatedCssFolder . 'design_' . Mage::app()->getStore()->getCode() . '.css';
    }
}
