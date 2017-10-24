<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Model_LandingPage extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('unitech_landingpage/landingPage');
    }

    /**
     * Check if landing page identifier exist for specific store
     * return landing page id if landing page exists
     *
     * @param string $identifier
     * @param int $storeId
     * @return int
     */
    public function checkIdentifier($identifier, $storeId)
    {
        return $this->_getResource()->checkIdentifier($identifier, $storeId);
    }

    /**
     * Save landing page store, after landing page save
     *
     * @return Unitech_LandingPage_Model_LandingPage
     */
    protected function _afterSave()
    {
        if ($this->hasStoreIds()) {
            $this->_getResource()->saveLandingPageStore($this);
        }
        return parent::_afterSave();
    }

    public function addStoreId($storeId)
    {
        $ids = $this->getStoreIds();
        if (!in_array($storeId, $ids)) {
            $ids[] = $storeId;
        }
        $this->setStoreIds($ids);
        return $this;
    }

    public function getStoreIds()
    {
        $ids = $this->_getData('store_ids');
        if (is_null($ids)) {
            $this->loadStoreIds();
            $ids = $this->getData('store_ids');
        }
        return $ids;
    }

    public function loadStoreIds()
    {
        $this->_getResource()->loadStoreIds($this);
    }

    public function validate()
    {
        $errors = array();
        $helper = Mage::helper('unitech_landingpage');

        if (!Zend_Validate::is($this->getTitle(), 'NotEmpty')) {
            $errors[] = $helper->__('Title can\'t be empty');
        }

        if (!Zend_Validate::is($this->getShortDescription(), 'NotEmpty')) {
            $errors[] = $helper->__('Short Description cannot be empty');
        }

        if (!Zend_Validate::is($this->getDescription(), 'NotEmpty')) {
            $errors[] = $helper->__('Description cannot be empty');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    function addError($error)
    {
        $this->_errors[] = $error;
    }

    function getErrors()
    {
        return $this->_errors;
    }

    function resetErrors()
    {
        $this->_errors = array();
    }

    function printError($error, $line = null)
    {
        if ($error == null) return false;
        $img = 'error_msg_icon.gif';
        $liStyle = 'background-color:#FDD; ';
        echo '<li style="'.$liStyle.'">';
        echo '<img src="'.Mage::getDesign()->getSkinUrl('images/'.$img).'" class="v-middle"/>';
        echo $error;
        if ($line) {
            echo '<small>, Line: <b>'.$line.'</b></small>';
        }
        echo "</li>";
    }
    /**
     * Check if landing id exist in database
     *
     */
    function isLandingpageIdExist($id)
    {
        $pages = $this->getCollection()->getData();
        $ids='';
        foreach ($pages as $page) {
            $ids[] = $page['landingpage_id'];
        }
        if (!in_array($id, $ids)) {
            Mage::throwException(
                Mage::helper('unitech_landingpage')->__(
                    'Error: "Landing Page ID" does not match with the database! Please check. If you want '
                    .'to insert the record, please leave the "Landing Page ID" Blank!'
                )
            );
        }
    }
    /*
     * It will call resource method "validateImportData()" to validate data
     */
    function validateImportData($data)
    {

        /* If "Landing Page id" does not exist in database dont process, otherwisw it will throw error
           becase of foriegn key constraint
        */
        if ($data[0]!='') {
            $this->isLandingpageIdExist($data[0]);
        }
        $helper = Mage::helper('adminhtml');
        $urlModel = Mage::getModel('unitech_landingpage/url');

        $landingPage  = array(
            'title'             => $helper->stripTags($data[1]),
            'identifier'        => $data[2] ? $urlModel->formatUrlKey($data[2]) : $urlModel->formatUrlKey($data[1]),
            'status'            => $data[3],
            'keywords'          => $data[4],
            'part_numbers'      => $data[5],
            'short_description' => $data[6],
            'description'       => $data[7],
            'meta_keywords'     => $data[8],
            'meta_description'  => $data[9],
            'sort_order'        => $data[10],
            'store_ids'         => array($data[11])
        );
        $this->setData($landingPage);
        if ($data[0]) {
            $this->setId($data[0]);
        }
        $this->_getResource()->validateImportData($this);

    }
}