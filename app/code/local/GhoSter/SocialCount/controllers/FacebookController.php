<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/17/16
 * Time: 5:21 PM
 */

class GhoSter_SocialCount_FacebookController extends Mage_Core_Controller_Front_Action {

    public function indexAction()
    {

        $this->loadLayout();

        $this->renderLayout();

    }
}
