<?php
    class Hil_Downloader_Model_Mysql4_Downloader_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
    {

        public function _construct()
        {
            $this->_init("downloader/downloader");
        }

    }