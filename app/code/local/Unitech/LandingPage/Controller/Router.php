<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */
class Unitech_LandingPage_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract
{
    /**
     * Initialize Controller Router
     *
     * @param Varien_Event_Observer $observer
     */
    public function initControllerRouters($observer)
    {
        /* @var $front Mage_Core_Controller_Varien_Front */
        $front = $observer->getEvent()->getFront();

        $front->addRouter(Mage::getStoreConfig('unitech_landingpage/frontend/default_router'), $this);
    }

    /**
     * Validate and Match Cms Page and modify request
     *
     * @param Zend_Controller_Request_Http $request
     * @return bool
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        if (!Mage::isInstalled()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();
            exit;
        }
        $router = Mage::getStoreConfig('unitech_landingpage/frontend/default_router');

        $identifier = trim(str_replace("/$router", '', $request->getPathInfo()), '/');

        $condition = new Varien_Object(
            array(
                'identifier' => $identifier,
                'continue'   => true
            )
        );
        Mage::dispatchEvent(
            'landingpage_controller_router_match_before', 
            array(
                'router'    => $this,
                'condition' => $condition
            )
        );
        $identifier = $condition->getIdentifier();
        
        if ($condition->getRedirectUrl()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect($condition->getRedirectUrl())
                ->sendResponse();
            $request->setDispatched(true);
            return true;
        }
    
        if (!$condition->getContinue()) {
            return false;
        }
        if (trim($identifier)) {
            $landingPage   = Mage::getModel('unitech_landingpage/landingPage');
            $landingPageId = $landingPage->checkIdentifier($identifier, Mage::app()->getStore()->getId());
            if (!$landingPageId) {
                return false;
            }
    
            $request->setModuleName('landingpage')
                ->setControllerName('index')
                ->setActionName('view')
                ->setParam('landingpage_id', $landingPageId);
            $request->setAlias(
                Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                $router.'/'.$identifier
            );
        } else {
            $request->setModuleName('landingpage')
                ->setControllerName('index')
                ->setActionName('index');
            $request->setAlias(
                Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                $router
            );
        }
        

        return true;
    }
}
