<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Adminhtml_LandingPage_ListController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Landing Page list
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_title($this->__('GameDay Extensions'))->_title($this->__('Landing Page'));
        $this->loadLayout();
        $this->_setActiveMenu('zextension/unitech_landingpage');
        $this->renderLayout();
    }

    /**
     * Create new landing page
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit action
     *
     */
    public function editAction()
    {
        $id     = $this->getRequest()->getParam('id');
        $model = $this->_initLandingPage('id');
        $model  = Mage::getModel('unitech_landingpage/landingPage')->load($id);

        if (!$model->getId() && $id) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('unitech_landingpage')->__('This Landing Page no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('Add Landing Page'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        $this->loadLayout();
        $this->_setActiveMenu('zextension/unitech_landingpage');

        $this->_addBreadcrumb(
            $id ? 
            Mage::helper('unitech_landingpage')->__('Edit Landing Page') : 
            Mage::helper('unitech_landingpage')->__('Add Landing Page'),
            $id ? 
            Mage::helper('unitech_landingpage')->__('Edit Landing Page') : 
            Mage::helper('unitech_landingpage')->__('Add Landing Page')
        )
        ->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        $redirectBack = $this->getRequest()->getParam('back', false);
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('id');
            $model = $this->_initLandingPage();

            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('unitech_landingpage')->__('This landing page no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }

            $identifier = $data['identifier'] ? $data['identifier'] : $data['title'];
            $data['identifier'] = Mage::getModel('unitech_landingpage/url')->formatUrlKey($identifier);

            // save model
            try {
                if (!empty($data)) {
                    $model->addData($data);
                    Mage::getSingleton('adminhtml/session')->setFormData($data);
                }
                $model->save();
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('unitech_landingpage')->__('The landing page has been saved.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $redirectBack = true;
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('unitech_landingpage')->__('Unable to save the landing page.')
                );
                $redirectBack = true;
                Mage::logException($e);
            }
            if ($redirectBack) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Delete action
     *
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                // init model and delete
                $model = Mage::getModel('unitech_landingpage/landingPage');
                $model->load($id);
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('unitech_landingpage')->__('The landing page has been deleted.')
                );
                // go to grid
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('unitech_landingpage')->__(
                        'An error occurred while deleting landing page data. Please review log and try again.'
                    )
                );
                Mage::logException($e);
                // save data in session
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                // redirect to edit form
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('unitech_landingpage')->__('Unable to find a landing page to delete.')
        );
        // go to grid
        $this->_redirect('*/*/');
    }

    /**
     * Delete specified landing page using grid massaction
     *
     */
    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('landingpage');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select Landing Page(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getSingleton('unitech_landingpage/landingPage')->load($id);
                    $model->delete();
                }

                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been deleted.', count($ids))
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('unitech_landingpage')->__(
                        'An error occurred while mass deleting landing page. Please review log and try again.'
                    )
                );
                Mage::logException($e);
                return;
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Update specified landing page status using grid massaction
     *
     */
    public function massStatusAction()
    {
        $ids = $this->getRequest()->getParam('landingpage');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select Landing Page(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getSingleton('unitech_landingpage/landingPage')->load($id);
                    $model->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been updated', count($ids))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('unitech_landingpage')->__(
                        'An error occurred while mass updating landing page. Please review log and try again.'
                    )
                );
                Mage::logException($e);
                return;
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Load Landing Page from request
     *
     * @param string $idFieldName
     * @return Unitech_LandingPage_Model_LandingPage $model
     */
    protected function _initLandingPage($idFieldName = 'landingpage_id')
    {
        $id = (int)$this->getRequest()->getParam($idFieldName);
        $model = Mage::getModel('unitech_landingpage/landingPage');
        if ($id) {
            $model->load($id);
        }
        if (!Mage::registry('current_landingpage')) {
            Mage::register('current_landingpage', $model);
        }
        return $model;
    }

    /**
     * Render Landing Page grid
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Import and export Page
     *
     */
    public function importExportAction()
    {
        $this->_title($this->__('GameDay Extensions'))
             ->_title($this->__('Landing Page'));

        $this->_title($this->__('Import and Export Landing Pages'));

        $this->loadLayout()
            ->_setActiveMenu('zextension/unitech_landingpage')
            ->_addContent($this->getLayout()->createBlock('unitech_landingpage/adminhtml_landingPage_importExport'))
            ->renderLayout();
    }

    /**
     * import action from import/export landing pages
     *
     */
    public function importPostAction()
    {
        if ($this->getRequest()->isPost() && !empty($_FILES['import_landingpage_file']['tmp_name'])) {
            try {
                $this->_importLandingPages();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('unitech_landingpage')->__('The landing page(s) has been imported.')
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('unitech_landingpage')->__('Invalid file upload attempt')
                );
            }
        } else {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('unitech_landingpage')->__('Invalid file upload attempt')
            );
        }
        $this->_redirect('*/*/importExport');
    }

    protected function _importLandingPages()
    {
        $fileName   = $_FILES['import_landingpage_file']['tmp_name'];
        $csvObject  = new Varien_File_Csv();
        $csvData = $csvObject->getData($fileName);

        /** checks columns */
        $csvFields  = array(
            0   => Mage::helper('unitech_landingpage')->__('Landing Page Id'),
            1   => Mage::helper('unitech_landingpage')->__('Title'),
            2   => Mage::helper('unitech_landingpage')->__('Identifier'),
            3   => Mage::helper('unitech_landingpage')->__('Status'),
            4   => Mage::helper('unitech_landingpage')->__('Keywords'),
            5   => Mage::helper('unitech_landingpage')->__('Part Numbers'),
            6   => Mage::helper('unitech_landingpage')->__('Short Description'),
            7   => Mage::helper('unitech_landingpage')->__('Description'),
            8   => Mage::helper('unitech_landingpage')->__('Meta Keywords'),
            9   => Mage::helper('unitech_landingpage')->__('Meta Description'),
            10  => Mage::helper('unitech_landingpage')->__('Sort Order'),
            11  => Mage::helper('unitech_landingpage')->__('Store Id'),
        );

        if ($csvData[0] == $csvFields) {
            /** @var $helper Mage_Adminhtml_Helper_Data */
            $helper = Mage::helper('adminhtml');
            $urlModel = Mage::getModel('unitech_landingpage/url');
            $count = 0;
            foreach ($csvData as $k => $v) {

                if ($k == 0) {
                    continue;
                }

                //end of file has more then one empty lines
                if (count($v) <= 1 && !strlen($v[0])) {
                    continue;
                }
                $landingPageModel = Mage::getModel('unitech_landingpage/landingPage');
                if (count($csvFields) != count($v)) {
                    Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('unitech_landingpage')->__('Invalid file upload attempt')
                    );
                }

                /* Validate csv data */
                $landingPageModel->validateImportData($v);
                if (!empty($v[1]) && !empty($v[3]) && !empty($v[6]) && !empty($v[7]) && is_numeric($v[11])) {
                    /* Save csv data in a array */
                    $landingPages[$count]  = array(
                        'id'                => $v[0],
                        'title'             => $helper->stripTags($v[1]),
                        'identifier'        => $v[2] ? $urlModel->formatUrlKey($v[2]) : $urlModel->formatUrlKey($v[1]),
                        'status'            => $v[3],
                        'keywords'          => $v[4],
                        'part_numbers'      => $v[5],
                        'short_description' => $v[6],
                        'description'       => $v[7],
                        'meta_keywords'     => $v[8],
                        'meta_description'  => $v[9],
                        'sort_order'        => $v[10],
                        'store_ids'         => array($v[11])
                    );
                    $count++;
                }
            }
            foreach ($landingPages as $landingPageData) {
                $landingPageModel = Mage::getModel('unitech_landingpage/landingPage');
                foreach ($landingPageData as $dataName => $dataValue) {
                    if ($dataName != 'id') {
                         /* Below code was added to replace '&quot;' with '"' as 'quot;' was getting replace with
                          * '"&quot;' in editor,  that's why it was not displaying properly in frontend*/
                         $dataValue = str_replace('&quot;', '"', $dataValue);
                         $landingPageModel->setData($dataName, $dataValue);
                    }
                }
                 /* Set Id of records which are already present in database, which will get update
                  * If a record dosen't have any landingpage_id it will get inserted in database
                  */
                 if ($landingPageData['id'] !='') {
                         $landingPageModel->setId($landingPageData['id']);
                 }
                 /* Save each record in database */
                 $landingPageModel->save();
            }
        } else {
            Mage::throwException(Mage::helper('unitech_landingpage')->__('Invalid file format upload attempt'));
        }
    }

    /**
     * export action from import/export tax
     *
     */
    public function exportPostAction()
    {
        /** start csv content and set template */
        $headers = new Varien_Object(
            array(
                'landingpage_id'    => Mage::helper('unitech_landingpage')->__('Landing Page Id'),
                'title'             => Mage::helper('unitech_landingpage')->__('Title'),
                'identifier'        => Mage::helper('unitech_landingpage')->__('Identifier'),
                'status'            => Mage::helper('unitech_landingpage')->__('Status'),
                'keywords'          => Mage::helper('unitech_landingpage')->__('Keywords'),
                'part_numbers'      => Mage::helper('unitech_landingpage')->__('Part Numbers'),
                'short_description' => Mage::helper('unitech_landingpage')->__('Short Description'),
                'description'       => Mage::helper('unitech_landingpage')->__('Description'),
                'meta_keywords'     => Mage::helper('unitech_landingpage')->__('Meta Keywords'),
                'meta_description'  => Mage::helper('unitech_landingpage')->__('Meta Description'),
                'sort_order'        => Mage::helper('unitech_landingpage')->__('Sort Order'),
                'store_id'          => Mage::helper('unitech_landingpage')->__('Store Id')
            )
        );
        $template = '"{{landingpage_id}}","{{title}}","{{identifier}}","{{status}}","{{keywords}}"'
                . ',"{{part_numbers}}","{{short_description}}","{{description}}","{{meta_keywords}}"'
                . ',"{{meta_description}}","{{sort_order}}","{{store_id}}"';
        $content = $headers->toString($template);

        $content .= "\n";
        $collection = Mage::getResourceModel('unitech_landingpage/landingPage_collection')
                        ->joinStoreTable()
                        ->addOrder('landingpage_id', 'ASC');

        while ($page = $collection->fetchItem()) {
            $content .= $page->toString($template) . "\n";
        }

        $this->_prepareDownloadResponse('landing_pages.csv', $content);
    }

    protected function _isAllowed()
    {

        switch ($this->getRequest()->getActionName()) {
            case 'importExport':
                return Mage::getSingleton('admin/session')->isAllowed(
                    'zextension/unitech_landingpage/landingpage_import_export'
                );
                break;
            case 'index':
                return Mage::getSingleton('admin/session')->isAllowed('zextension/unitech_landingpage/landingpage_list');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('zextension/unitech_landingpage/landingpage_list');
                break;
        }
    }

}