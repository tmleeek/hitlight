<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */
class Unitech_LandingPage_Block_Send extends Mage_Core_Block_Template
{
    /**
     * Retrieve username for form field
     *
     * @return string
     */
    public function getUserName()
    {
        $name = $this->getFormData()->getData('sender/name');
        if (!empty($name)) {
            return trim($name);
        }

        /* @var $session Mage_Customer_Model_Session */
        $session = Mage::getSingleton('customer/session');

        if ($session->isLoggedIn()) {
            return $session->getCustomer()->getName();
        }

        return '';
    }

    /**
     * Retrieve sender email address
     *
     * @return string
     */
    public function getEmail()
    {
        $email = $this->getFormData()->getData('sender/email');
        if (!empty($email)) {
            return trim($email);
        }

        /* @var $session Mage_Customer_Model_Session */
        $session = Mage::getSingleton('customer/session');

        if ($session->isLoggedIn()) {
            return $session->getCustomer()->getEmail();
        }

        return '';
    }

    /**
     * Retrieve Message text
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->getFormData()->getData('sender/message');
    }

    /**
     * Retrieve Form data or empty Varien_Object
     *
     * @return Varien_Object
     */
    public function getFormData()
    {
        $data = $this->getData('form_data');
        if (!$data instanceof Varien_Object) {
            $data = new Varien_Object();
            $this->setData('form_data', $data);
        }

        return $data;
    }

    /**
     * Set Form data array
     *
     * @param array $data
     * @return Mage_Sendfriend_Block_Send
     */
    public function setFormData($data)
    {
        if (is_array($data)) {
            $this->setData('form_data', new Varien_Object($data));
        }

        return $this;
    }

    /**
     * Retrieve Current Product Id
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->getRequest()->getParam('id', null);
    }

    /**
     * Retrieve current category id for product
     *
     * @return int
     */
    public function getCategoryId()
    {
        return $this->getRequest()->getParam('cat_id', null);
    }

    /**
     * Retrieve Max Recipients
     *
     * @return int
     */
    public function getMaxRecipients()
    {
        return Mage::helper('sendfriend')->getMaxRecipients();
    }

    /**
     * Retrieve Send URL for Form Action
     *
     * @return string
     */
    public function getSendUrl()
    {
        return Mage::getUrl('*/*/sendmail', array(
            'id'     => $this->getProductId(),
            'cat_id' => $this->getCategoryId()
			//, '_secure' => $this->_isSecure()
        ));
    }

    /**
     * Return send friend model
     *
     * @return Mage_Sendfriend_Model_Sendfriend
     */
    protected function _getSendfriendModel()
    {
        $model  = Mage::getModel('sendfriend/sendfriend');
        $model->setRemoteAddr(Mage::helper('core/http')->getRemoteAddr(true));
        $model->setCookie(Mage::app()->getCookie());
        $model->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
		return $model;
    }

    /**
     * Check if user is allowed to send
     *
     * @return boolean
     */
    public function canSend()
    {
        return !$this->_getSendfriendModel()->isExceedLimit();
    }
}
