<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   Trigger Email Suite
 * @version   1.0.1
 * @revision  156
 * @copyright Copyright (C) 2014 Mirasvit (http://mirasvit.com/)
 */


$designPath   = Mage::getSingleton('emaildesign/config')->getDesignPath();
$templatePath = Mage::getSingleton('emaildesign/config')->getTemplatePath();

$ioFile = new Varien_Io_File();
$ioFile->open();
$ioFile->cd($designPath);

foreach ($ioFile->ls(Varien_Io_File::GREP_FILES) as $fl) {
    if ($fl['filetype'] == 'xml') {
        $design = Mage::getModel('emaildesign/design');
        $design->import($designPath.DS.$fl['text']);
    }
}

$ioFile->cd($templatePath);

foreach ($ioFile->ls(Varien_Io_File::GREP_FILES) as $fl) {
    if ($fl['filetype'] == 'xml') {
        $template = Mage::getModel('emaildesign/template');
        $template->import($templatePath.DS.$fl['text']);
    }
}