<?php

class GhoSter_Avatar_Model_Observer extends Varien_Object
{

    public function saveCustomerAvatar($observer)
    {

        $fileName = null;
        $customer = $observer->getEvent()->getCustomer();
        /* @var $customer Mage_Customer_Model_Customer */
        if (isset($_FILES['avatar-file'])) {
            $avatarFile = $_FILES['avatar-file'];
            $avatar = Mage::getModel('ghoster_avatar/avatar');
            $avatar->setAvatarFileData($avatarFile);
            try {
                $fileName = $avatar->saveAvatarFile();
                $customer->setData(GhoSter_Avatar_Model_Config::AVATAR_ATTR_CODE, $fileName);
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }



        return $this;
    }

}
