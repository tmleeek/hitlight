<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/18/16
 * Time: 10:56 AM
 */
class GhoSter_SocialCount_TwitterController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {

        $this->loadLayout();

        $this->renderLayout();

    }
}
