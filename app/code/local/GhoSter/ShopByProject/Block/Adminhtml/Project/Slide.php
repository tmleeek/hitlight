<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/11/16
 * Time: 3:49 PM
 */
class GhoSter_ShopByProject_Block_Adminhtml_Project_Slide extends Mage_Core_Block_Template
{
    /**
     * Get Randomized String
     *
     * @param int $length
     * @return string
     */
    public function getRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    /**
     * Get Project Slide
     *
     * @return array
     */
    public function getSlides()
    {
        $project = Mage::getModel('ghoster_shopbyproject/project')->load(Mage::app()->getRequest()->getParam('project_id'));
        $result = [];

        if ($project->getId()) {
            $project_category_ids = Mage::helper('ghoster_shopbyproject')->getSelectedProjectCategories($project->getId());
            foreach ($project_category_ids as $project_category_id) {
                $project_category = Mage::getModel('ghoster_shopbyproject/category')->load($project_category_id);

                $slide = Mage::getModel('ghoster_shopbyproject/slide')->getCollection()
                    ->addFieldToSelect('*')
                    ->addFieldToFilter('project_id', $project->getId())
                    ->addFieldToFilter('entity_id', $project_category->getId());


                $result[$project_category->getCategoryId()] = $slide;
            }
        }

        return $result;

    }

    /**
     * Get Project Slide JS when editing
     *
     * @return string
     */
    public function getSlideJs(){
        $script = '';
        $slides = $this->getSlides();
        if (count($slides)){
            foreach($slides as $category_id=>$items){
                foreach($items as $item){
                    $script .= 'window.catalogSlider.add('.$category_id.',\'' . $item->getData('slide_image').'\', \'' . $item->getData('slide_url') . '\');';
                }
            }
        }

        return $script;
    }

}
