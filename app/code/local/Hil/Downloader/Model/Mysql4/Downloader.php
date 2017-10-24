<?php
class Hil_Downloader_Model_Mysql4_Downloader extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init("downloader/downloader", "id");
    }
}