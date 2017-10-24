<?php

class Cyberfision_Custom_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getStoreConfig()
    {
        $config = [];

        $config['enabled'] = Mage::getStoreConfig('cyberfision_custom/homepage/enable_banner');
        $config['banner_type'] = Mage::getStoreConfig('cyberfision_custom/homepage/banner_type');
        $config['banner_background'] = Mage::getStoreConfig('cyberfision_custom/homepage/banner_background');
        $config['banner_heading_1'] = Mage::getStoreConfig('cyberfision_custom/homepage/banner_heading_1');
        $config['banner_content_1'] = Mage::getStoreConfig('cyberfision_custom/homepage/banner_content_1');
        $config['banner_link_1'] = Mage::getStoreConfig('cyberfision_custom/homepage/banner_link_1');
        $config['banner_buying_guide_link_1'] = Mage::getStoreConfig('cyberfision_custom/homepage/banner_buying_guide_link_1');
        $config['banner_heading_2'] = Mage::getStoreConfig('cyberfision_custom/homepage/banner_heading_2');
        $config['banner_content_2'] = Mage::getStoreConfig('cyberfision_custom/homepage/banner_content_2');
        $config['banner_link_2'] = Mage::getStoreConfig('cyberfision_custom/homepage/banner_link_2');
        $config['banner_buying_guide_link_2'] = Mage::getStoreConfig('cyberfision_custom/homepage/banner_buying_guide_link_2');

        $config['header']['logo'] = Mage::getStoreConfig('cyberfision_custom/header/logo');
        $config['header']['site_desc'] = Mage::getStoreConfig('cyberfision_custom/header/site_desc');

        $config['footer']['enable_links'] = Mage::getStoreConfig('cyberfision_custom/footer/enable_links');
        $config['footer']['heading'][1] = Mage::getStoreConfig('cyberfision_custom/footer/footer_heading_1');
        $config['footer']['heading'][2] = Mage::getStoreConfig('cyberfision_custom/footer/footer_heading_2');
        $config['footer']['heading'][3] = Mage::getStoreConfig('cyberfision_custom/footer/footer_heading_3');
        $config['footer']['heading'][4] = Mage::getStoreConfig('cyberfision_custom/footer/footer_heading_4');
        $config['footer']['heading'][5] = Mage::getStoreConfig('cyberfision_custom/footer/footer_heading_5');
        $config['footer']['heading'][6] = Mage::getStoreConfig('cyberfision_custom/footer/footer_heading_6');
        $config['footer']['heading'][7] = Mage::getStoreConfig('cyberfision_custom/footer/footer_heading_7');
        $config['footer']['heading'][8] = Mage::getStoreConfig('cyberfision_custom/footer/footer_heading_8');

        $config['footer']['link'][1] = Mage::getStoreConfig('cyberfision_custom/footer/footer_link_1');
        $config['footer']['link'][2] = Mage::getStoreConfig('cyberfision_custom/footer/footer_link_2');
        $config['footer']['link'][3] = Mage::getStoreConfig('cyberfision_custom/footer/footer_link_3');
        $config['footer']['link'][4] = Mage::getStoreConfig('cyberfision_custom/footer/footer_link_4');
        $config['footer']['link'][5] = Mage::getStoreConfig('cyberfision_custom/footer/footer_link_5');
        $config['footer']['link'][6] = Mage::getStoreConfig('cyberfision_custom/footer/footer_link_6');
        $config['footer']['link'][7] = Mage::getStoreConfig('cyberfision_custom/footer/footer_link_7');
        $config['footer']['link'][8] = Mage::getStoreConfig('cyberfision_custom/footer/footer_link_8');


        $config['footer']['enable_contact'] = Mage::getStoreConfig('cyberfision_custom/footer/enable_contact');
        $config['footer']['contact']['store_name'] = Mage::getStoreConfig('general/store_information/name');
        $config['footer']['contact']['store_phone'] = Mage::getStoreConfig('general/store_information/phone');
        $config['footer']['contact']['store_email'] = Mage::getStoreConfig('trans_email/ident_support/email');
        $config['footer']['contact']['store_address'] = Mage::getStoreConfig('general/store_information/address');


        $config['footer']['enable_social'] = Mage::getStoreConfig('cyberfision_custom/footer/enable_social');
        $config['footer']['social']['facebook'] = Mage::getStoreConfig('cyberfision_custom/footer/facebook');
        $config['footer']['social']['twitter'] = Mage::getStoreConfig('cyberfision_custom/footer/twitter');
        $config['footer']['social']['youtube-play'] = Mage::getStoreConfig('cyberfision_custom/footer/youtube');
        $config['footer']['social']['pinterest-p'] = Mage::getStoreConfig('cyberfision_custom/footer/pinterest');
        $config['footer']['social']['linkedin'] = Mage::getStoreConfig('cyberfision_custom/footer/linkedin');
        $config['footer']['social']['wordpress'] = Mage::getStoreConfig('cyberfision_custom/footer/wordpress');
        $config['footer']['social']['instagram'] = Mage::getStoreConfig('cyberfision_custom/footer/instagram');


        return $config;
    }

    public function getStoreLogo($config)
    {
        return Mage::getBaseUrl('media') . 'hitlights/' . $config;
    }


    /**
     * Detect Controller Action Route
     *
     * @return array
     */
    public function accountCurrentPosition()
    {
        $data = [];

        $data['controler'] = Mage::app()->getRequest()->getControllerName(); // return controller name

        $data['action'] = Mage::app()->getRequest()->getActionName(); // return action name

        $data['route'] = Mage::app()->getRequest()->getRouteName(); // return routes name

        return Mage::app()->getFrontController()->getAction()->getFullActionName();
    }

    /**
     * Get Account Menu Title
     *
     * @return null|string
     */
    public function getAccountLabel()
    {


        $actionName = Mage::app()->getFrontController()->getAction()->getFullActionName();


        switch ($actionName) {
            case 'customer_account_index':
                return $this->__('Account Dashboard');
                break;

            case 'customer_account_edit':
                return $this->__('Account Information');

            case 'sales_order_history':
                return $this->__('My Orders');
                break;

            case 'review_customer_index':
                return $this->__('My Product Reviews');

            case 'monkey_customer_account_index':
                return $this->__('Newsletter Subscriptions');

            default:

                return null;

        }

    }

}
