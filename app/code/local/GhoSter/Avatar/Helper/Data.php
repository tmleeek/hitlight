<?php

class GhoSter_Avatar_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_PATH_UPLOAD_WIDGET_ENABLED = 'customer_avatar/avatar_widget/enabled';


    public function _getAvatar()
    {
        return Mage::getSingleton('ghoster_avatar/avatar');
    }

    public function isShowUploadWidget()
    {
        return Mage::app()->getStore()->getConfig(self::XML_PATH_UPLOAD_WIDGET_ENABLED);
    }


    /**
     * Get Avatar Image Path Resized
     *
     * @param $customerId
     * @return GhoSter_Common_Helper_Resizer
     */
    public function getAvatarPath($customerId)
    {

        $_subdir = 'customer';
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $imagePath = $_subdir . $customer->getData(GhoSter_Avatar_Model_Config::AVATAR_ATTR_CODE);

        $resizedImage = Mage::helper('ghoster_common/resizer')->init($imagePath)->adaptiveResize(120, 120);

        return $resizedImage;

    }

    public function getAdditionAddressJson($_pAddsses){
        $result = array();
        foreach($_pAddsses as $key=>$address){
            $data = $address->getData();
            $data['street1'] = $address->getStreet(1);
            $data['street2'] = $address->getStreet(2);
            $result[$key] = $data;
        }
        return Mage::helper('core')->jsonEncode($result);
    }
}
