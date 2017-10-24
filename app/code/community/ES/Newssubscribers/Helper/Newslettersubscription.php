	<?php

class ES_Newssubscribers_Helper_Newslettersubscription extends Mage_Core_Helper_Abstract
{
	public function getCookieName()
    {
        return Mage::getStoreConfig('newsletter/general/cookiename');
    }

    public function getCookieLifeTime()
    {
        return Mage::getStoreConfig('newsletter/general/cookielifetime');
    }

    public function isActivePopUp()
    {
        return Mage::getStoreConfig('newsletter/general/isactive');
    }

    public function getTheme()
    {
        return Mage::getStoreConfig('newsletter/general/theme');
    }

    public function getFirstTitle()
    {
        return Mage::getStoreConfig('newsletter/general/firsttitle');
    }

    public function getSecondTitle()
    {
        return Mage::getStoreConfig('newsletter/general/secondtitle');
    }

    public function getText()
    {
        return Mage::getStoreConfig('newsletter/general/message');
    }
	public function sendEmailCoupon($data){
					$subscriber = Mage::getModel('newsletter/subscriber')
                    ->loadByEmail($data);
					
		$customerEmail = $data;
		$emailVar = array();
		if($subscriber->getCustomerId()) {
		$customer = Mage::getModel("customer/customer"); 
		$customer->load($subscriber->getCustomerId());
		$emailVar['name']=$customer->getName();
		$emailVar['firstname']=$customer->getFirstname();
		$emailVar['lastname']=$customer->getLastname();
		$emailVar['middlename']=$customer->getMiddlename();
		}
		$localeCode = Mage::getStoreConfig('general/locale/code');
		$emailTemplate = Mage::getModel('core/email_template')->load(4);

		$senderName = Mage::getStoreConfig('trans_email/ident_general/name');
		
		$senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');
		
		$emailVar['email'] = $customerEmail;
		$emailVar['isObjectNew'] = true;
		$emailVar['couponCode'] = Mage::getModel('newssubscribers/subscriber')->getCouponCode();
		
		$processedTemplate = $emailTemplate->getProcessedTemplate($emailVar);
		
		$mail = Mage::getModel('core/email')
		->setToName($senderName)
		->setToEmail($customerEmail)
		->setBody($processedTemplate)
		->setSubject('10% Discount Code')
		->setFromEmail($senderEmail)
		->setFromName($senderName)
		->setType('html');
		try{			
			// $mail->send();
				$mail->send();
		}
		catch(Exception $error)
		{
		Mage::getSingleton('core/session')->addError($error->getMessage());
		return false;
		}
	}
}