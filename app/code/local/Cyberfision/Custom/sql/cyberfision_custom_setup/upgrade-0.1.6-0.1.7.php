<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/8/16
 * Time: 2:49 PM
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$connection = $installer->getConnection();
$identifier = Mage_Cms_Model_Page::NOROUTE_PAGE_ID;
$title = '';
$contentCmsPage = <<<EOT
<div class="container"><img alt="" src="{{media url="wysiwyg/404.png"}}" /></div>
EOT;
$cmsPage = Mage::getModel('cms/page')->load($identifier, 'identifier');
if ($cmsPage->isObjectNew()) {
    $cmsPage->setTitle($title)
        ->setContent($contentCmsPage)
        ->setIdentifier($identifier)
        ->setStores(0)
        ->setIsActive(true);
} else {
    $cmsPage->setTitle($title)
        ->setContent($contentCmsPage)
        ->setStores(0)
        ->setIsActive(true);
}
$cmsPage->save();

$installer->endSetup();
