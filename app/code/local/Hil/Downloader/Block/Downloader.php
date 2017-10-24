<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/15/16
 * Time: 2:53 PM
 */
class Hil_Downloader_Block_Downloader extends Mage_Core_Block_Template
{
    public function __construct(){
        parent::__construct();
    }

    public function getDownloader() {
        $downloader = Mage::getModel('downloader/downloader')->getCollection()
            ->setOrder('id', 'DESC');
//        ->addFieldToFilter('status', '1')

        return $downloader;
    }
}
