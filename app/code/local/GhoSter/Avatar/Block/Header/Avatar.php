<?php

class GhoSter_Avatar_Block_Header_Avatar extends Mage_Core_Block_Template
{
    protected $_avatar = null;

    const DEFAULT_WIDTH = 75;

    const DEFAULT_HEIGHT = 75;


    public function __construct()
    {
        parent::__construct();

        $customer = $this->getCustomerFromSession();

        if ($customer) {
            $customerObj = Mage::getModel('customer/customer')->load($customer->getId());
            if ($avatar = $customerObj->getData(GhoSter_Avatar_Model_Config::AVATAR_ATTR_CODE)) {
                $this->_avatar = $avatar;
            } else {
                $this->_avatar = null;
            }
        }

    }

    protected function getCustomerFromSession()
    {
        return Mage::getSingleton('customer/session')->getCustomer();
    }

    /**
     * Get Width
     *
     * @return int
     */
    protected function getWidth()
    {
        $configWidth = (int)Mage::getStoreConfig(
            'customer/avatar_group/avatar_field_width',
            Mage::app()->getStore()
        );

        if ($configWidth > 0) {
            $width = $configWidth;
        } else {
            $width = self::DEFAULT_WIDTH;
        }

        return $width;
    }

    /**
     * Get Height
     *
     * @return int
     */
    protected function getHeight()
    {
        $configHeight = (int)Mage::getStoreConfig(
            'customer/avatar_group/avatar_field_height',
            Mage::app()->getStore()
        );

        if ($configHeight > 0) {
            $height = $configHeight;
        } else {
            $height = self::DEFAULT_HEIGHT;
        }

        return $height;
    }

    /**
     * Get Avatar
     *
     * @return object
     */
    public function getAvatar()
    {
        return $this->_avatar;
    }

    /**
     * Get Avatar Path
     *
     * @return string
     */
    public function getAvatarPath()
    {
        return $this->getUrl('avatar/customer/viewAvatar');
    }

    /**
     * Get Avatar Html
     *
     * @return string|html
     */
    public function getAvatarHtml()
    {
        $html = "<img src='"
            . $this->getAvatarPath() .
            "' width ='" . $this->getWidth()
            . "' height='" . $this->getHeight()
            . "'/>";
        return $html;
    }

    /**
     * Get Upload Url
     *
     * @return string
     */
    public function getUploadUrl()
    {
        return Mage::getUrl('*/customer/upload');
    }
}
