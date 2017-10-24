<?php
ini_set('display_errors', 1);
require_once 'app/Mage.php';
Mage::app();

$resource = Mage::getSingleton('core/resource');
$read = $resource->getConnection('core_read');
$write = $resource->getConnection('core_write');

//mega menu
$script0 ="SET FOREIGN_KEY_CHECKS = 0;TRUNCATE TABLE megamenu";
$script1 = "
INSERT INTO `megamenu` (`megamenu_id`, `name_menu`, `status`, `colum`, `style_show`, `categories`, `size_megamenu`, `size_colum`, `sort_order`, `stores`, `link`, `colum_category`, `size_category`, `code_template`, `created_time`, `update_time`, `position`, `menu_type`, `template_id`, `products`, `products_box_title`, `categories_box_title`, `header`, `footer`, `featured_type`, `featured_products`, `featured_products_box_title`, `featured_categories`, `featured_categories_box_title`, `number_column`, `size_bar`, `border_size`, `background_color`, `border_color`, `title_color`, `title_background_color`, `title_font`, `title_font_size`, `subtitle_color`, `subtitle_font`, `subtitle_font_size`, `link_color`, `hover_color`, `link_font`, `link_font_size`, `text_color`, `text_font`, `text_font_size`, `item_icon`, `featured_width`, `submenu_width`, `submenu_align`, `leftsubmenu_align`, `megamenu_type`, `category_type`, `featured_content`, `main_content`, `featured_column`, `category_show_type`, `category_image`) VALUES
(1, 'Browse products', 1, 2, NULL, '48, 153, 62, 64, 152, 61, 127, 134, 133, 135, 136, 130, 137, 138, 140, 139, 128, 131, 143, 142, 146, 144, 59, 69, 81, 71, 51, 129, 124, 108', NULL, NULL, 0, '0', '/led-light-strips/multicolor.html', NULL, NULL, NULL, '2016-08-29 09:41:03', '2016-08-29 09:41:03', NULL, 3, 0, NULL, 'Products', 'Categories', NULL, NULL, 1, '48, 51, 66', 'FEATURED PRODUCTS', '48', 'Featured Categories', NULL, NULL, NULL, NULL, NULL, '', '', '', 0, '', '', 0, '', '', '', 0, 'FFFFFF', '', 0, NULL, 30, 20, 2, 0, 0, 0, NULL, NULL, 2, 0, 0),
(2, 'Shop by projects', 1, 4, NULL, '152, 153, 224, 61', NULL, NULL, 1, '0', '#', NULL, NULL, NULL, '2016-08-15 03:43:58', '2016-08-15 03:43:58', NULL, 1, 0, NULL, 'Products', 'Categories', NULL, NULL, 0, NULL, 'Featured Products', NULL, 'Featured Categories', NULL, NULL, NULL, NULL, NULL, '', '', '', 0, '', '', 0, '', '', '', 0, 'FFFFFF', '', 0, NULL, 30, 20, 2, 0, 0, 0, NULL, '<div class=\"sub_menu_custom\">\r\n<ul>\r\n<li>\r\n<div class=\"col_menu\"><a href=\"/shopbyproject/project/#project_tab_1\"><span class=\"name_menu_project\">Kitchen</span><span class=\"image_menu_project\"><img alt=\"Kitchen\" src=\"/media/wysiwyg/projects/kitchen.jpg\" /></span></a></div>\r\n</li>\r\n<li>\r\n<div class=\"col_menu\"><a href=\"/shopbyproject/project/#project_tab_2\"><span class=\"name_menu_project\">Living Room</span><span class=\"image_menu_project\"><img alt=\"living room\" src=\"/media/wysiwyg/projects/living_room.gif\" /></span></a></div>\r\n</li>\r\n<li>\r\n<div class=\"col_menu\"><a href=\"/shopbyproject/project/#project_tab_3\"><span class=\"name_menu_project\">bathroom</span><span class=\"image_menu_project\"><img alt=\"Bathroom\" src=\"/media/wysiwyg/projects/bathroom.gif\" /></span></a></div>\r\n</li>\r\n<li>\r\n<div class=\"col_menu\"><a href=\"/shopbyproject/project/#project_tab_4\"><span class=\"name_menu_project\">Home Theater</span><span class=\"image_menu_project\"><img alt=\"Home Theater\" src=\"/media/wysiwyg/projects/home_threater.gif\" /></span></a></div>\r\n</li>\r\n<li>\r\n<div class=\"col_menu\"><a href=\"/shopbyproject/project/#project_tab_5\"><span class=\"name_menu_project\">Retail</span><span class=\"image_menu_project\"><img alt=\"Retail\" src=\"/media/wysiwyg/projects/retail_.gif\" /></span></a></div>\r\n</li>\r\n</ul>\r\n</div>', 0, 0, 1),
(3, 'Catalogues', 1, 4, NULL, '2, 14, 22, 23, 25, 26, 27, 28, 32, 48, 51, 59, 61, 62, 63, 64, 68, 69, 70, 71, 81, 82, 88, 89, 93, 95, 96, 108, 109, 110, 113, 114, 116, 117, 120, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 164, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222, 223, 224, 225, 226', NULL, NULL, 2, '0', '/specials-and-deals.html', NULL, NULL, NULL, '2016-07-29 06:53:05', '2016-07-29 06:53:05', NULL, 6, 0, NULL, 'Products', 'Categories', NULL, NULL, 0, NULL, 'Featured Products', NULL, 'Featured Categories', NULL, NULL, NULL, NULL, NULL, '', '', '', 0, '', '', 0, '', '', '', 0, 'FFFFFF', '', 0, NULL, 30, 20, 2, 0, 0, 0, NULL, NULL, 0, 0, 0),
(4, 'Resources', 1, 4, NULL, '2, 14, 22, 23, 25, 26, 27, 28, 32, 48, 51, 59, 61, 62, 63, 64, 68, 69, 70, 71, 81, 82, 88, 89, 93, 95, 96, 108, 109, 110, 113, 114, 116, 117, 120, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 164, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222, 223, 224, 225, 226', NULL, NULL, 3, '0', '#', NULL, NULL, NULL, '2016-10-03 04:59:26', '2016-10-03 04:59:26', NULL, 1, 0, NULL, 'Products', 'Categories', NULL, NULL, 0, NULL, 'Featured Products', NULL, 'Featured Categories', NULL, NULL, NULL, NULL, NULL, '', '', '', 0, '', '', 0, '', '', '', 0, 'FFFFFF', '', 0, NULL, 30, 100, 1, 0, 0, 0, NULL, '<ul>\r\n<li><a href=\"/downloads/instruction/\" target=\"_self\">Instruction&nbsp;</a></li>\r\n<li><a href=\"/blog/hitlights-how-tos/\">Tips</a></li>\r\n<li><a href=\"/faq.html\">FAQs</a></li>\r\n<li><a href=\"/about.html\">About Us</a></li>\r\n<li><a href=\"https://www.youtube.com/user/HitLightsLED\">Youtube</a></li>\r\n<li><a href=\"/blog\">Blog</a></li>\r\n<li><a href=\"/warranty.html\">Warranty</a></li>\r\n</ul>', 0, 0, 0);
";

$write->query($script0);
$write->query($script1);

// homepage cms
$homescript0 ="DELETE FROM cms_page WHERE page_id='2832'";
$homescript1 ="
INSERT INTO `cms_page` (`page_id`, `title`, `root_template`, `meta_keywords`, `meta_description`, `identifier`, `content_heading`, `content`, `creation_time`, `update_time`, `is_active`, `sort_order`, `layout_update_xml`, `custom_theme`, `custom_root_template`, `custom_layout_update_xml`, `custom_theme_from`, `custom_theme_to`, `meta_title`, `mageworx_hreflang_identifier`, `exclude_from_sitemap`, `meta_robots`) VALUES
(2832, 'LED Strip Lighting | LED Light Strips &amp; Tape Light Acessories | HitLights', 'one_column', 'LED lights, LED lighting, LED light strips, LED light bulbs, LED light strip accessories, LED, LED light bulb accessories, LED business solutions', 'HitLights is a leading LED lighting supplier in the U.S. We sell LED light strips, LED light bulbs and LED light accessories. We experience, not just product.', 'home', NULL, NULL, '2014-09-23 21:07:58', '2016-09-27 00:07:20', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 0, '');
";
 $write->query($homescript0);
 $write->query($homescript1);

// homepage config core
$s1 = "
UPDATE  core_config_data  SET  value =  '/?___store=default&___from_store=wholesale' WHERE  core_config_data.path ='cyberfision_custom/homepage/banner_link_1';
UPDATE  core_config_data  SET  value =  'Praesent tincidunt convallis quam quis commodo. Maecenas libero quam, dapibus nec tempus vel, sodales ac sapien' WHERE  core_config_data.path ='cyberfision_custom/homepage/banner_content_1';
UPDATE  core_config_data  SET  value =  'FOR RESIDENTIALS' WHERE  core_config_data.path ='cyberfision_custom/homepage/banner_heading_1';
UPDATE  core_config_data  SET  value =  'buyguide' WHERE  core_config_data.path ='cyberfision_custom/homepage/banner_buying_guide_link_1';
UPDATE  core_config_data  SET  value =  'FOR COMMERCIALS' WHERE  core_config_data.path ='cyberfision_custom/homepage/banner_heading_2';
UPDATE  core_config_data  SET  value =  'Praesent tincidunt convallis quam quis commodo. Maecenas libero quam, dapibus nec tempus vel, sodales ac sapien' WHERE  core_config_data.path ='cyberfision_custom/homepage/banner_content_2';
UPDATE  core_config_data  SET  value =  '/?___store=wholesale&___from_store=default' WHERE  core_config_data.path ='cyberfision_custom/homepage/banner_link_2';
UPDATE  core_config_data  SET  value =  'buyguide' WHERE  core_config_data.path ='cyberfision_custom/homepage/banner_buying_guide_link_2';
";
$write->query($s1);

$s2 = "
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'category_slider/general/categories',
value =  '48,51,59,127,128,130,131' ON DUPLICATE KEY UPDATE value =  '48,51,59,127,128,130,131';

INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'shop_by_project/general/active',
value =  '1' ON DUPLICATE KEY UPDATE value =  '1';

";
$write->query($s2);

$logo = "
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'cyberfision_custom/header/logo',
value =  'default/logo_2.png' ON DUPLICATE KEY UPDATE value =  'default/logo_2.png'; ";
$write->query($logo);

$s3 ="
TRUNCATE TABLE ghoster_shop_by_project;
TRUNCATE TABLE ghoster_shop_by_project_category;
TRUNCATE TABLE ghoster_shop_by_project_common_product;
TRUNCATE TABLE ghoster_shop_by_project_product;
TRUNCATE TABLE ghoster_shop_by_project_slide;
";
$s4 ="
INSERT INTO `ghoster_shop_by_project` VALUES (1,'Kitchen','2016-08-16 09:26:54','/media/wysiwyg/projects/modern-kitchen-design_black-kitchen-countertop_triple-wood-bar-stool_white-kitchen-island_double-kitchen-pendant-lamp_white-kitchen-cabinet_white-wall-paint.jpg',1),(2,'Living Room','2016-07-29 11:31:15','/media/wysiwyg/projects/modest-interior-design-ideas-for-kitchen-and-living-room-ideas-for-you.jpg',1),(3,'Bathroom','2016-07-29 10:06:47','/media/wysiwyg/projects/Recessed-ceiling-lights-in-a-modern-bathroom.jpg',1),(4,'Home Theater','2016-07-29 11:32:02','/media/wysiwyg/projects/lithonia-lighting-led-Home-Theater-Eclectic-with-blue-light-conference-room-audio-video-cove-lighting-Crestron.jpg',1),(5,'Retails','2016-07-29 10:04:34','/media/wysiwyg/projects/merge-app-3.jpg',1);
INSERT INTO `ghoster_shop_by_project_category` VALUES (100,5,48,NULL,NULL,NULL),(101,5,173,NULL,NULL,NULL),(102,5,174,NULL,NULL,NULL),(103,3,25,NULL,NULL,NULL),(104,3,110,NULL,NULL,NULL),(116,2,14,NULL,0,NULL),(117,2,172,NULL,0,NULL),(118,2,183,NULL,0,NULL),(119,2,184,NULL,0,NULL),(120,4,22,NULL,0,NULL),(121,4,174,NULL,0,NULL),(134,1,160,'Accentuate your counter tops and add exceptional task lighting with this Under Cabinet lighting project. Simply follow these steps, and your kitchen will look brand new.',128,NULL),(135,1,162,'Highlight your cabinets and add new breadth and depth to your kitchen with this Over Cabinet lighting project. Simply follow these steps, and your kitchen will look brand new.',128,NULL),(136,1,164,'Add an elegant accent to your kitchen with this Toe Kick lighting project.  Simply follow these step by step instructions to install your very own Toe Kick lighting solution.',128,NULL);
INSERT INTO `ghoster_shop_by_project_common_product` VALUES (187,5,101,66),(188,5,101,153),(189,5,101,204),(190,5,101,272),(191,5,101,283),(192,5,101,314),(193,5,101,415),(194,5,101,431),(195,5,101,436),(196,5,101,438),(197,5,101,466),(198,5,101,655),(199,5,101,700),(200,3,103,132),(201,3,103,150),(223,2,116,127),(224,2,116,128),(225,2,117,283),(226,2,117,415),(227,2,118,350),(228,2,118,436),(229,2,118,438),(230,2,119,292),(231,2,119,431),(232,2,119,655),(233,4,120,139),(234,4,120,265),(235,4,121,66),(236,4,121,283),(237,4,121,314),(238,4,121,431),(239,4,121,474),(272,1,134,654),(273,1,134,655),(274,1,134,656),(275,1,134,657),(276,1,134,658),(277,1,134,680),(278,1,134,681),(279,1,134,700);
INSERT INTO `ghoster_shop_by_project_product` VALUES (95,100,5,'W0012V-XXX-3230-K,W0012V-301-3230-K,L0512V-501-1630-K'),(96,101,5,'CDC-GAME-06,L0512V-501-1630-K'),(97,102,5,'CDC-GAME-06,L0512V-501-1630-K'),(98,103,3,'CDC-GAME-06,L0512V-501-1630-K'),(99,104,3,'CDC-GAME-06,L0512V-501-1630-K'),(111,116,2,'L1012V-502-1630,W0012V-MCS-3230-K,CTR-DCDIMTOUCH,CON-10M-B00A-12PK'),(112,117,2,'L1012V-502-1630,W0012V-MCS-3230-K,CDC-GAME-06,CON-10M-B00A-12PK'),(113,118,2,'L1012V-502-1630,W0012V-MCS-3230-K,CDC-GAME-06,CON-10M-B00A-12PK'),(114,119,2,'L1012V-502-1630,W0012V-MCS-3230-K,CDC-GAME-06,CON-10M-B00A-12PK'),(115,120,4,'CDC-GAME-06,L0512V-501-1630-K'),(116,121,4,'PWR-12V-MAMP, CDC-M00-4PK,LS_T3'),(129,134,1,'LS_LUMA10STRIPS_PREMIUM,LS_WIRECONNECTORS,LS_INDOORADAPTERS,CTR-WALL1-12V-WH,LS_FOAMTAPE,	CDC-F16M,PWR-12V-SAMP,CDC-WN2216-10PK,MNT-WIRECLIP-10PK'),(130,135,1,'LS_LUMA10STRIPS_PREMIUM,LS_WIRECONNECTORS,LS_INDOORADAPTERS,CTR-WALL1-12V-WH,LS_FOAMTAPE,	CDC-F16M,PWR-12V-SAMP,CDC-WN2216-10PK,MNT-WIRECLIP-10PK'),(131,136,1,'LS_LUMA10STRIPS_PREMIUM,LS_WIRECONNECTORS,LS_INDOORADAPTERS,CTR-WALL1-12V-WH,LS_FOAMTAPE,	CDC-F16M,PWR-12V-SAMP,CDC-WN2216-10PK,MNT-WIRECLIP-10PK');
INSERT INTO `ghoster_shop_by_project_slide` VALUES (115,5,100,'/media/wysiwyg/instagram.jpg','#'),(116,5,100,'/media/wysiwyg/404.png','#'),(117,3,103,'/media/wysiwyg/LEDLightStripAccessories_1.png','#'),(118,3,103,'/media/wysiwyg/banner1.jpg','#'),(119,3,103,'/media/wysiwyg/black_friday_1.jpg','#'),(120,3,104,'/media/wysiwyg/become_a_distributor_1.jpg','#'),(121,3,104,'/media/wysiwyg/bulewindblogpic.png','#'),(131,2,116,'/media/wysiwyg/StPatricks-deal-banner_Sharpness_1.jpg','#'),(132,2,116,'/media/wysiwyg/Slider01.png','#'),(133,2,117,'/media/wysiwyg/Thanksgiving_Black_Friday_Cyber_Monday_HitLights_Deals_LED_Lighting.png','#'),(134,4,120,'/media/wysiwyg/StPatricks-deal-banner3.jpg','#'),(135,4,120,'/media/wysiwyg/UL_led_strip.jpg','#'),(136,4,121,'/media/wysiwyg/projects/lithonia-lighting-led-Home-Theater-Eclectic-with-blue-light-conference-room-audio-video-cove-lighting-Crestron.jpg','#'),(173,1,134,'/media/wysiwyg/projects/under-cabinet/undercabinet7_e_1_.jpg','#'),(174,1,134,'/media/wysiwyg/projects/under-cabinet/undercabinet8_e.jpg','#'),(175,1,134,'/media/wysiwyg/projects/under-cabinet/undercabinet7_e.jpg','#'),(176,1,134,'/media/wysiwyg/projects/under-cabinet/undercabinet5_e.jpg','#'),(177,1,134,'/media/wysiwyg/projects/under-cabinet/undercabinet4_e.jpg','#'),(178,1,134,'/media/wysiwyg/projects/under-cabinet/undercabinet2e.jpg','#'),(179,1,135,'/media/wysiwyg/projects/Over-cabinet/OverCabinet1_e.jpg','#'),(180,1,135,'/media/wysiwyg/projects/Over-cabinet/OverCabinet2_e.jpg','#'),(181,1,136,'/media/wysiwyg/projects/Toe-kick/ToeKick1e.jpg','#');
";
$write->query($s3);
$write->query($s4);

// footer
$sf2 = "
INSERT INTO cms_block
SET title =  'Footer Links',
identifier =  'footer_link_add_top',
content =  '<div class=\"col-sm-12\">
<div class=\"qs-info-list\">
<ul class=\"list_menu\">
<li><a href=\"/about.html\">About HitLights</a></li>
<li><a href=\"/press.html\">Press Releases</a></li>
<li><a href=\"/business_solutions.html\">Business Solutions</a></li>
<li><a href=\"/return.html\">Return Policy</a></li>
<li><a href=\"/Shipping.html\">Shipping Policies</a></li>
<li><a href=\"/career.html\">Careers</a></li>
</ul>
</div>
</div>
',
creation_time = 'NOW()',
update_time = 'NOW()',
is_active = '1',
use_instruction = '0'
ON DUPLICATE KEY UPDATE content =  '<div class=\"col-sm-12\">
<div class=\"qs-info-list\">
<ul class=\"list_menu\">
<li><a href=\"/about.html\">About HitLights</a></li>
<li><a href=\"/press.html\">Press Releases</a></li>
<li><a href=\"/business_solutions.html\">Business Solutions</a></li>
<li><a href=\"/return.html\">Return Policy</a></li>
<li><a href=\"/Shipping.html\">Shipping Policies</a></li>
<li><a href=\"/career.html\">Careers</a></li>
</ul>
</div>
</div>';

INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'shop_by_project/general/active',
value =  '1' ON DUPLICATE KEY UPDATE value =  '1';

";
$write->query($sf2); // + set store view in backend to all: 0

$sf3 = "
INSERT INTO cms_block
SET title =  'Footer Links bottom',
identifier =  'footer_link_add_bottom',
content =  '<li><a class=\"top-link-blog\" title=\"Blog\" href=\"/blog/\">Blog</a></li>
<li><a title=\"Site Map\" href=\"/sitemap/\">Site Map</a></li>
<li><a title=\"Terms of Use\" href=\"/termofuse.html/\">Terms of Use</a></li>
<li><a title=\"Policy\" href=\"/privacy-policy.html/\">Policy</a></li>
',
creation_time = 'NOW()',
update_time = 'NOW()',
is_active = '1',
use_instruction = '0'
ON DUPLICATE KEY UPDATE content =  '<li><a class=\"top-link-blog\" title=\"Blog\" href=\"/blog/\">Blog</a></li>
<li><a title=\"Site Map\" href=\"/sitemap/\">Site Map</a></li>
<li><a title=\"Terms of Use\" href=\"/termofuse.html/\">Terms of Use</a></li>
<li><a title=\"Policy\" href=\"/privacy-policy.html/\">Policy</a></li>';

INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'shop_by_project/general/active',
value =  '1' ON DUPLICATE KEY UPDATE value =  '1';
2
";
$write->query($sf3); // + set store view in backend to all: 0

$upsf3 = "
UPDATE  cms_block SET  content =  '<li><a class=\"top-link-blog\" title=\"Blog\" href=\"/blog/\">Blog</a></li>
<li><a title=\"Site Map\" href=\"/sitemap/\">Site Map</a></li>
<li><a title=\"Terms of Use\" href=\"/termofuse.html/\">Terms of Use</a></li>
<li><a title=\"Policy\" href=\"/privacy-policy.html/\">Policy</a></li>' WHERE  cms_block.identifier ='footer_link_add_bottom';
";
$write->query($upsf3);

$s = "
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'design/footer/copyright',
value =  '&copy; 2016 <b>HitLights LED</b>. All Rights Reserved.' ON DUPLICATE KEY UPDATE value =  '&copy; 2016 <b>HitLights LED</b>. All Rights Reserved.';

INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'general/store_information/address',
value =  '8000 Innovation Park Dr.</br>Baton Rouge, LA 70820' ON DUPLICATE KEY UPDATE value =  '8000 Innovation Park Dr.</br>Baton Rouge, LA 70820';

";
$write->query($s);

// disable Miscellaneous HTML feedback addons backend //api.usersnap.com/load/'

// update category shopbyproject id 113 - attri_id shopby = 379 and include menu attir_id =61
$up = "
INSERT INTO catalog_category_entity_int
SET entity_type_id =  '3',
attribute_id =  '379',
store_id =  '0',
entity_id = '113',
value =  '1' ON DUPLICATE KEY UPDATE value =  '1';

INSERT INTO catalog_category_entity_int
SET entity_type_id =  '3',
attribute_id =  '61',
store_id =  '0',
entity_id = '113',
value =  '1' ON DUPLICATE KEY UPDATE value =  '1';
";
$write->query($up);

// instruction step guide shopbyproject
$pro = "
CREATE TABLE IF NOT EXISTS `ghoster_shop_by_project_instruction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(6) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `SHOPBYPROJECT_INSTRUCTION_ENTITY` (`entity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Shop By Project Instruction Block Generator';

INSERT INTO `ghoster_shop_by_project_instruction` (`id`, `entity_id`, `title`, `identifier`, `data`) VALUES
(1, 128, 'Instruction Manuals', 'contact-us', '[\"<p>The standard product types in Magento are Simple, Configurable, Grouped, Virtual, Bundle, and Downloadable. Have you ever wanted to change the look and feel of a product based on the product type?&nbsp;Or, maybe custom code a logic based on the product type? The following code will help you identify the the given product&rsquo;s type.<\\/p>\",\"<p>The standard product types in Magento are Simple, Configurable, Grouped, Virtual, Bundle, and Downloadable. Have you ever wanted to change the look and feel of a product based on the product type?&nbsp;Or, maybe custom code a logic based on the product type? The following code will help you identify the the given product&rsquo;s type.<\\/p>\",\"<p>The standard product types in Magento are Simple, Configurable, Grouped, Virtual, Bundle, and Downloadable. Have you ever wanted to change the look and feel of a product based on the product type?&nbsp;Or, maybe custom code a logic based on the product type? The following code will help you identify the the given product&rsquo;s type.<\\/p>\"]');
";
$write->query($pro);

// create view steps  in shopbyproject => create in backend Instruction CMS Blocks Generator +  Manager project => Select Instruction Block: set

// customer group
$gr = "
UPDATE  customer_group SET  customer_group_code =  'Architectural' WHERE  customer_group.customer_group_id =6;
UPDATE  customer_group SET  customer_group_code =  'Display and Signage' WHERE  customer_group.customer_group_id =7;
UPDATE  customer_group SET  customer_group_code =  'Engineering' WHERE  customer_group.customer_group_id =8;
UPDATE  customer_group SET  customer_group_code =  'Event Marketing' WHERE  customer_group.customer_group_id =9;
INSERT INTO `customer_group` (`customer_group_code`, `tax_class_id`) VALUES ('Fabrication and Manufacturing', '3');
INSERT INTO `customer_group` (`customer_group_code`, `tax_class_id`) VALUES ('General or Electrical Contractor', '3');
INSERT INTO `customer_group` (`customer_group_code`, `tax_class_id`) VALUES ('Property Management', '3');
INSERT INTO `customer_group` (`customer_group_code`, `tax_class_id`) VALUES ('Residential', '3');
INSERT INTO `customer_group` (`customer_group_code`, `tax_class_id`) VALUES ('Small Business', '3');
";
$write->query($gr);

// category parent => slider param image => input by user
// http://i.prntscr.com/15f5a6b8659d48b5af568aeaa82bcf34.png
// set product view: http://i.prntscr.com/f00ea10c076f47f5b047603e18a84809.png
// update all category parent id to product type view => attribute_id 43 and  entity_id = category id

$cateP ="
UPDATE  `catalog_category_entity_varchar` SET  `value` =  'PRODUCTS' WHERE  `catalog_category_entity_varchar`.`attribute_id` =43 and `catalog_category_entity_varchar`.`entity_id` = 48;
UPDATE  `catalog_category_entity_varchar` SET  `value` =  'PRODUCTS' WHERE  `catalog_category_entity_varchar`.`attribute_id` =43 and `catalog_category_entity_varchar`.`entity_id` = 127;
UPDATE  `catalog_category_entity_varchar` SET  `value` =  'PRODUCTS' WHERE  `catalog_category_entity_varchar`.`attribute_id` =43 and `catalog_category_entity_varchar`.`entity_id` = 130;
UPDATE  `catalog_category_entity_varchar` SET  `value` =  'PRODUCTS' WHERE  `catalog_category_entity_varchar`.`attribute_id` =43 and `catalog_category_entity_varchar`.`entity_id` = 59;
";
$write->query($cateP);


// buy guide from test site 52.
$contentRow1 = <<<LOL
["<p><span>LED LIGHT STRIP LED light strips typically come in reels of 16.4ft. You\u2019ll need to measure what you want to light before making a purchase to make sure you get enough.<\/span><\/p><p><span><img alt=\"Led light strip luma5 hd curled 780\" src=\"https:\/\/preview.3.basecamp.com\/3518255\/blobs\/37ab8c235d75bfc55fc7161274d980c90010\/previews\/full\/led-light-strip-luma5-hd-curled-780.jpg\" \/><\/span><\/p>","<p><span>POWER SUPPLY Our LED strips run off of 12V DC power. That means you\u2019re going to need a power supply to make your lights work. The more lights you\u2019ll be using, the bigger the power supply will be. Check out this article to see how many watts you\u2019ll need.<\/span><\/p><p><span><img alt=\"Strip 101 pwr 12v 024 30 lights on 780\" src=\"https:\/\/preview.3.basecamp.com\/3518255\/blobs\/87ab87f3ecc50626d4f22128290c3b390010\/previews\/full\/strip-101-PWR-12V-024-30-lights-on-780.jpg\" \/><\/span><\/p>","<p><span>CONTROLLER or DIMMER You probably want to control your lights somehow. We have dimmers that will let you adjust the brightness of your lights. For multicolored strips, we have remotes that can set your colors or animations.<\/span><\/p><p><span><img alt=\"Strip 101 44 key controller lights on 780\" src=\"https:\/\/preview.3.basecamp.com\/3518255\/blobs\/5d00dffb37f271e72c11e1cb789b48460010\/previews\/full\/strip-101-44-key-controller-lights-on-780.jpg\" \/><\/span><\/p>","<p><span>CONNECTORS We have a lot of connectors for different situations, but they\u2019re made to connect one strip to another. This is especially helpful if you need to cut your LED light strips.<\/span><\/p><p><span><img alt=\"Strip 101 con 08s b00a 4pk single extremem close inserted 780\" src=\"https:\/\/preview.3.basecamp.com\/3518255\/blobs\/b2562f58c93f6bc8e051c478fc76703b0010\/previews\/full\/strip-101-CON-08S-B00A-4PK-single-extremem-close-inserted-780.jpg\" \/><\/span><\/p>"]
LOL;

$contentRow2 = <<<TOANLM
["<p>The standard product types in Magento are Simple, Configurable, Grouped, Virtual, Bundle, and Downloadable. Have you ever wanted to change the look and feel of a product based on the product type?\u00a0Or, maybe custom code a logic based on the product type? The following code will help you identify the the given product\u2019s type.<\/p><p><img alt=\"\" src=\"http:\/\/52.90.160.97\/media\/wysiwyg\/33_1475980068.jpg\" height=\"350\" width=\"1170\" \/><\/p>","<p>The standard product types in Magento are Simple, Configurable, Grouped, Virtual, Bundle, and Downloadable. Have you ever wanted to change the look and feel of a product based on the product type?\u00a0Or, maybe custom code a logic based on the product type? The following code will help you identify the the given product\u2019s type.<\/p><p><img alt=\"\" src=\"\/media\/wysiwyg\/31_1475980032.jpg\" height=\"350\" width=\"1170\" \/><\/p>","<p>The standard product types in Magento are Simple, Configurable, Grouped, Virtual, Bundle, and Downloadable. Have you ever wanted to change the look and feel of a product based on the product type?\u00a0Or, maybe custom code a logic based on the product type? The following code will help you identify the the given product\u2019s type.<\/p><p><img alt=\"\" src=\"http:\/\/52.90.160.97\/media\/wysiwyg\/31_1475980032.jpg\" height=\"350\" width=\"1170\" \/><\/p>","<p>The standard product types in Magento are Simple, Configurable, Grouped, Virtual, Bundle, and Downloadable. Have you ever wanted to change the look and feel of a product based on the product<\/p><p><img alt=\"\" src=\"http:\/\/52.90.160.97\/media\/wysiwyg\/32_1475980083.jpg\" height=\"350\" width=\"1170\" \/><\/p>"]
TOANLM;

$contentRow3 = <<<TOANLM
["<p><span>LED LIGHT STRIPS - LED light Strips are flexible circuit boards with light emitting diodes (LEDs) mounted to them. LEDs are very small and produce a lot of light while only using a small amount of power.&nbsp;<\/span><\/p>\r\n<p><img alt=\"Diode on strip\" src=\"https:\/\/preview.3.basecamp.com\/3518255\/blobs\/a49f375a8e7cb134731317f3a86dc2450010\/previews\/full\/diode-on-strip.jpg\" height=\"350\" width=\"900\" \/><\/p>\r\n<p>&nbsp;<\/p>\r\n<p>&nbsp;<\/p>","<p><span>FLEXIBILITY - These lights are a lot different than a bulb or even an old T8 fluorescent because they can bend to whatever you stick them.<\/span><\/p>\r\n<p><span><img alt=\"Flexible leds\" src=\"https:\/\/preview.3.basecamp.com\/3518255\/blobs\/69f4905ce1b85a6f059a4de7a0d5614a0010\/previews\/full\/flexible-leds.jpg\" \/><\/span><\/p>","<p><span>SUPER STICKY - Most LED light strips have an adhesive strip of glue on the back. All you have to do is peel off the back and stick them right where you want them.<\/span><\/p>\r\n<p><span><img alt=\"Tape backing 3\" src=\"https:\/\/preview.3.basecamp.com\/3518255\/blobs\/af49e1e4ae6ef0a4c1f4d5cdc983a2b00010\/previews\/full\/tape-backing-3.jpg\" \/><\/span><\/p>","<p><span>LIGHT ANYWHERE - You can light almost anything from kitchen cabinets to a Halloween costume. They can go anywhere and light anything.<\/span><\/p>\r\n<p><span><img alt=\"Sink side after\" src=\"https:\/\/preview.3.basecamp.com\/3518255\/blobs\/157724c8be10586526ed4826292366b50010\/previews\/full\/sink-side-after.jpg\" \/><\/span><\/p>","<p><span>EXTREME BRIGHTNESS - HitLights&rsquo; LED light strips are extremely bright. One light strip reel is as bright as up to 18 60 Watt light bulbs.<\/span><\/p>\r\n<p><span><img alt=\"L5 hd cool wide 780\" src=\"https:\/\/preview.3.basecamp.com\/3518255\/blobs\/85772d293ac0df0bf35cdabde8f07a010010\/previews\/full\/l5-hd-cool-wide-780.jpg\" \/><\/span><\/p>"]
TOANLM;


$bgtrun = "TRUNCATE TABLE cyberfision_brand_brand";
$bguide = "
INSERT INTO `cyberfision_brand_brand` (`entity_id`, `created_at`, `updated_at`, `name`, `description`, `image`, `ordert`, `banner`) VALUES
(1, '2016-09-27 04:10:00', '2016-11-01 02:40:54', 'What do i need?', '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.</p>', ?, '2', '33_1475980068.jpg'),
(2, '2016-09-27 07:42:39', '2016-11-01 02:40:23', 'Are you ok now?', '<p>ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32. On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.</p>', ?, '3', '31_1475980032.jpg'),
(3, '2016-10-27 10:33:08', '2016-11-01 02:34:54', 'Lorem ipsum dolor sit amet, consectetur amet', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In euismod viverra purus, sed porttitor nulla dignissim eu. In hac habitasse platea dictumst. In a libero dui. Ut porta libero auctor rutrum imperdiet. Donec enim neque, malesuada vel metus ac, dignissim blandit nunc. Aenean sollicitudin, erat a varius varius, lectus mi venenatis est, sed tincidunt nulla nulla egestas erat. Suspendisse interdum mauris eget metus consequat ornare. Phasellus in facilisis magna. In mattis porttitor lacinia. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In hac habitasse platea dictumst. Sed ante risus, consectetur ac dignissim ac, accumsan id nulla. In a ipsum in mauris imperdiet facilisis. Ut laoreet, ipsum sed convallis rhoncus, est leo consequat sem, vel vestibulum lorem quam tempus risus. Cras velit ex, tempor nec pulvinar ac, malesuada eu urna. Integer a sodales justo.</p>\r\n<p>Ut sit amet enim dapibus lectus scelerisque venenatis. Ut id sapien eleifend, convallis ante eu, convallis risus. Ut maximus quam vitae ultricies pretium. Integer id sollicitudin tellus. Etiam sollicitudin tellus quam, a suscipit orci lobortis vel. Vivamus non velit condimentum, ullamcorper ligula et, tincidunt leo. Nullam metus velit, placerat et risus et, sollicitudin pellentesque enim. Sed porttitor ipsum velit, nec rhoncus felis tempus et. Donec posuere elit sagittis lacus maximus, quis placerat purus lobortis. Maecenas augue lacus, dapibus at erat quis, tristique viverra enim. Curabitur sit amet imperdiet quam. Nam vel vestibulum massa. Morbi tempus eleifend libero eget venenatis. Donec imperdiet sodales urna sed tristique. Etiam vel massa nec velit bibendum rutrum. Integer consequat sollicitudin turpis quis ultrices. Cras vestibulum risus eget lectus tincidunt, sed facilisis felis mattis. Nulla in tempor lectus, et consequat mi. Aliquam finibus ipsum sed lacus bibendum, at dapibus risus scelerisque. In hac habitasse platea dictumst. Donec nec eros et tellus lacinia ultricies. Nulla eu ipsum dictum, iaculis ligula et, consequat erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>', ?, '1', '32_1475980083.jpg');
";
$write->query($bgtrun);
$write->query($bguide, array($contentRow1, $contentRow2, $contentRow3));
$cfguide = "
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'tbuys/general/main_title',
value =  'Light strips 101' ON DUPLICATE KEY UPDATE value =  'Light strips 101';

INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'tbuys/general/can_light_title',
value =  'What can i light?' ON DUPLICATE KEY UPDATE value =  'What can i light?';
";
$write->query($cfguide);

//category image home
$chome = "
INSERT INTO catalog_category_entity_varchar
SET entity_type_id =  '3',
attribute_id =  '39',
store_id =  '0',
entity_id = '48',
value =  'strip_kits.jpg' ON DUPLICATE KEY UPDATE value =  'strip_kits.jpg';

INSERT INTO catalog_category_entity_varchar
SET entity_type_id =  '3',
attribute_id =  '39',
store_id =  '0',
entity_id = '131',
value =  '44-key-controller-600.jpg' ON DUPLICATE KEY UPDATE value =  '44-key-controller-600.jpg';

INSERT INTO catalog_category_entity_varchar
SET entity_type_id =  '3',
attribute_id =  '39',
store_id =  '0',
entity_id = '51',
value =  'bulb.jpg' ON DUPLICATE KEY UPDATE value =  'bulb.jpg';

INSERT INTO catalog_category_entity_varchar
SET entity_type_id =  '3',
attribute_id =  '39',
store_id =  '0',
entity_id = '59',
value =  'accessories.jpg' ON DUPLICATE KEY UPDATE value =  'accessories.jpg';

INSERT INTO catalog_category_entity_varchar
SET entity_type_id =  '3',
attribute_id =  '39',
store_id =  '0',
entity_id = '127',
value =  'HIL588_categories_strip_kits.jpg' ON DUPLICATE KEY UPDATE value =  'HIL588_categories_strip_kits.jpg';

INSERT INTO catalog_category_entity_varchar
SET entity_type_id =  '3',
attribute_id =  '39',
store_id =  '0',
entity_id = '128',
value =  'bar_and_accent_strips.jpg' ON DUPLICATE KEY UPDATE value =  'bar_and_accent_strips.jpg';

INSERT INTO catalog_category_entity_varchar
SET entity_type_id =  '3',
attribute_id =  '39',
store_id =  '0',
entity_id = '130',
value =  'categories_power_suppliers.jpg' ON DUPLICATE KEY UPDATE value =  'categories_power_suppliers.jpg';
";
$write->query($chome);

// blog + static page + checkout + ajax cart pro
$blog ="
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'wordpress/module/enabled',
value =  '1' ON DUPLICATE KEY UPDATE value =  '1';

INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'wordpress/database/is_shared',
value =  '1' ON DUPLICATE KEY UPDATE value =  '1';

INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'wordpress/database/table_prefix',
value =  'wp_' ON DUPLICATE KEY UPDATE value =  'wp_';

INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'wordpress/integration/full',
value =  '1' ON DUPLICATE KEY UPDATE value =  '1';

INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'wordpress/integration/route',
value =  'blog' ON DUPLICATE KEY UPDATE value =  'blog';

INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'wordpress/integration/path',
value =  'wordpress/' ON DUPLICATE KEY UPDATE value =  'wordpress/';

INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'wordpress/integration/path',
value =  'wordpress/' ON DUPLICATE KEY UPDATE value =  'wordpress/';

";
// auto login account => info admin magento login
$write->query($blog);

$cms = "
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='1';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='8';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='9';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='10';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='11';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='2815';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='2825';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='2831';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='2833';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='2837';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='2838';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='2841';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='2847';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='2849';
UPDATE  cms_page  SET  root_template =  'one_column_content' WHERE  cms_page.page_id ='2859';
";
$write->query($cms);

$checkout = "
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'onestepcheckout/design_configuration/page_layout',
value =  '1column' ON DUPLICATE KEY UPDATE value =  '1column';
  
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'onestepcheckout/display_configuration/is_enabled_coupon',
value =  '1' ON DUPLICATE KEY UPDATE value =  '1';
 
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'onestepcheckout/display_configuration/display_apply_coupon_button',
value =  '1' ON DUPLICATE KEY UPDATE value =  '1';
 
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'onestepcheckout/display_configuration/is_enabled_comments',
value =  '0' ON DUPLICATE KEY UPDATE value =  '0';
 
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'onestepcheckout/display_configuration/is_enabled_giftmessage',
value =  '0' ON DUPLICATE KEY UPDATE value =  '0';
 
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'onestepcheckout/display_configuration/is_enabled_giftwrap',
value =  '0' ON DUPLICATE KEY UPDATE value =  '0';
 
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'onestepcheckout/display_configuration/is_enabled_delivery',
value =  '0' ON DUPLICATE KEY UPDATE value =  '0';
 
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'onestepcheckout/display_configuration/is_checked_newsletter',
value =  '0' ON DUPLICATE KEY UPDATE value =  '0';
 
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'onestepcheckout/display_configuration/is_enabled_related_products',
value =  '0' ON DUPLICATE KEY UPDATE value =  '0';
";
$write->query($checkout);

// + approve version Cyberfision_Custom => 1.0.1
$cartBlock = <<<LOL
<p style="margin: 0;">You've just added this product to the cart:</p>
<p style="color: green;margin: 0;"><b>{{var product.name}}</b></p>
<div>{{block type="ajaxcartpro/confirmation_items_productimage" product="\$product" resize="135" }}</div>
{{block type="ajaxcartpro/confirmation_items_continue"}}
or
{{block type="ajaxcartpro/confirmation_items_gotocheckout"}}

LOL;

$ajaxcart = "
SET FOREIGN_KEY_CHECKS = 1;
INSERT INTO core_config_data
SET scope =  'default',
scope_id =  '0',
path =  'ajaxcartpro/addproductconfirmation/content',
value =  ?          
";
$write->query($ajaxcart, array($cartBlock));
?>
