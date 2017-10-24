<?php

class MageWorx_Downloads_Block_Instruction extends Mage_Core_Block_Template
{
    protected function getInstructionFiles()
    {
        $collection = Mage::getModel('mageworx_downloads/files')->getCollection();
        return $collection;
    }
}
