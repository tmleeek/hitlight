<?php
/**
 * GhoSter Avatar Customer Installer
 *
 * @category    GhoSter
 * @package     GhoSter_Avatar
 * @author      opensource
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * install avatar widget
 */

$widgetType = 'avatar/widget_upload';
$template = 'ghoster/avatar/widget/account.phtml';
$widgetLabel = 'title';
$widgetLabelValue = 'Avatar';

$handle = '<reference name="content">'
    . '<block type="' . $widgetType . '" name="avatar.fieldset" template="' . $template . '">'
    . '<action method="setData">'
    . '<name>' . $widgetLabel . '</name>'
    . '<value>' . $widgetLabelValue . '</value>'
    . '</action>'
    . '</block>'
    . '</reference>';

$layoutUpdate = array(
    array(
        'handle' => 'customer_account_create',
        'xml' => $handle,
        'sort_order' => 0
    )
);

$installer->getConnection()->insertMultiple($installer->getTable('core/layout_update'), $layoutUpdate);
$lastLayoutUpdateId = $installer->getConnection()->lastInsertId($installer->getTable('core/layout_update'));


$layoutLink = array(
    array(
        'store_id' => 0,
        'area' => 'frontend',
        'package' => 'default',
        'theme' => 'default',
        'layout_update_id' => $lastLayoutUpdateId
    )
);

$installer->getConnection()->insertMultiple($installer->getTable('core/layout_link'), $layoutLink);

$widgetParams = array(
    'title' => 'Choose Avatar'
);

$data = array(
    array(
        'instance_type' => $widgetType,
        'package_theme' => 'default/default',
        'title' => 'Upload Avatar Form Fieldset',
        'store_ids' => 0,
        'widget_parameters' => serialize($widgetParams),
    )
);

$installer->getConnection()->insertMultiple($installer->getTable('widget/widget_instance'), $data);

$widgetPage = array(
    array(
        'instance_id' => $installer->getConnection()->lastInsertId($installer->getTable('widget/widget_instance')),
        'page_group' => 'pages',
        'layout_handle' => 'customer_account_create',
        'block_reference' => 'content',
        'page_for' => 'all',
        'entities' => '',
        'page_template' => $template
    )
);

$installer->getConnection()->insertMultiple($installer->getTable('widget/widget_instance_page'), $widgetPage);

$widgetPageLayout = array(
    array(
        'page_id' => $installer->getConnection()->lastInsertId($installer->getTable('widget/widget_instance_page')),
        'layout_update_id' => $lastLayoutUpdateId
    )
);

$installer->getConnection()->insertMultiple($installer->getTable('widget/widget_instance_page_layout'), $widgetPageLayout);


$installer->endSetup(); 
