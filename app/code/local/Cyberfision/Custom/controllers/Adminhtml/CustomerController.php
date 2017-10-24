<?php
require_once ('Mage/Adminhtml/controllers/CustomerController.php');

class Cyberfision_Custom_Adminhtml_CustomerController extends Mage_Adminhtml_CustomerController{
    public function importAction(){
        if($postData = $this->getRequest()->getPost()){
            $mappingField = array();
            foreach ($postData['mapping'] as $key=>$value){
                $items = explode(':', $value);
                $mappingField[$items[0]][$items[1]] = $key;
            }
            if($mappingField['customer']['email']){
                if (($handle = fopen($_FILES["file_import"]["tmp_name"], "r")) !== FALSE) {
                    $k = 1;
                    while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {
                        if ( $k > 1) {
                            $customer = $this->_getCustomer($mappingField['customer'], $row);
                            $billingAddress = $customer->getDefaultBillingAddress();
                            $this->_updateAddress($customer, $billingAddress, 1, 0, $row[$mappingField['customer']['name']], $mappingField['billing'], $row);

                            $shippingAddress = $customer->getDefaultShippingAddress();
                            $this->_updateAddress($customer, $shippingAddress, 0, 1, $row[$mappingField['customer']['name']], $mappingField['shipping'], $row);
                        }
                        $k++;
                    }

                }
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('The customers has been imported.')
            );
            $this->_redirect('adminhtml/customer');
        } else {
            $this->_title($this->__('Customers'))->_title($this->__('Import Customers'));
            $this->loadLayout();
            $this->_setActiveMenu('customer');
            $this->renderLayout();
        }

    }

    protected function _updateAddress($customer,$address, $defaultBilling, $defaultShipping, $name, $mappingField, $data){
        if(!$address){
            $address = Mage::getModel('customer/address');
            $address->setCustomerId($customer->getId());
            $address->setIsDefaultBilling($defaultBilling)
                ->setIsDefaultShipping($defaultShipping)
                ->setCountryId('US');
        } else {
            $address = Mage::getModel('customer/address')->load($address->getId());
        }

        if($name){
            $pos = strpos($name, ' ');
            $address->setFirstname(substr($name, 0, $pos));
            $address->setLastname(substr($name, $pos));
        }

        if($mappingField['city']){
            $address->setCity($data[$mappingField['city']]);
        }
        if($mappingField['region']){
            $regionModel = Mage::getModel('directory/region')->loadByCode(strtoupper($data[$mappingField['region']]), 'US');
            if($regionId = $regionModel->getId()){
                $address->setRegionId($regionId);
            }else{
                $address->setRegion($data[$mappingField['region']]);
            }
        }
        if($mappingField['postcode']){
            $address->setPostcode($data[$mappingField['postcode']]);
        }

        if($mappingField['telephone']){
            $address->setTelephone($data[$mappingField['telephone']]);
        }
        $street = array();

        if($mappingField['street1']){
            $street[] = $data[$mappingField['street1']];
        }

        if($mappingField['street2']){
            $street[] = $data[$mappingField['street2']];
        }
        if(count($street)){
            $address->setStreet($street);
        }
        $address->save();
    }

    protected function _getCustomer($mappingField, $data){
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $email = $data[$mappingField['email']];
        if($customerId = $read->fetchOne('select entity_id from customer_entity where email=?',array($email))){
            $customer = Mage::getModel("customer/customer")->load($customerId);
        }else{
            $customer = Mage::getModel("customer/customer");
            $customer->setWebsiteId(1);
        }
        // set name
        if($name = $data[$mappingField['name']]){
            $pos = strpos($data[$mappingField['name']], ' ');
            $customer->setFirstname(substr($data[$mappingField['name']], 0, $pos));
            $customer->setLastname(substr($data[$mappingField['name']], $pos));
        }
        // set group
        if($mappingField['group']){
            if($groupId = $read->fetchOne('select customer_group_id from customer_group where customer_group_code LIKE ?',array('%'.$data[$mappingField['group']].'%'))){
                $customer->setGroupId($groupId);
            }
        }
        if(!$customer->getId()){
            $customer->setEmail($email);
            if($mappingField['password']){
                $customer->setPassword($data[$mappingField['password']]);
                $customer->setPasswordConfirmation($data[$mappingField['password']]);
            }else{
                $customer->setPassword('admin123');
                $customer->setPasswordConfirmation('admin123');
            }
        }

        $customer->save();
        return $customer;
    }

    public function mappingAction(){
        if($data = $this->getRequest()->getPost()){
            if(isset($_FILES['file_import'])){
                $allowedExts = array("csv");
                $temp = explode(".", $_FILES["file_import"]["name"]);
                $extension = end($temp);
                $k = 1;
                $result = array();
                $maps = false;
                if(in_array($extension,$allowedExts)){

                    if (($handle = fopen($_FILES["file_import"]["tmp_name"], "r")) !== FALSE) {
                        while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {
                            if ( $k == 1) {
                                $maps = $row;
                            }
                            $k++;
                        }

                        $block = $this->getLayout()->createBlock('cyberfision_custom/adminhtml_customer_mapping')
                            ->setTemplate('cyberfision/custom/customer/mapping.phtml')->setDataCsv($maps);
                        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('content'=>$block->toHtml())));
                    }
                }else{
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('error'=>'Invalid file type')));
                }

            }

        }
    }
}