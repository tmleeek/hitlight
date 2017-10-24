<?php


class GhoSter_Avatar_Model_Avatar extends Mage_Core_Model_Abstract
{
    protected $_supportedExtensions = array('jpg', 'JPG', 'png', 'PNG', 'gif', 'GIF');
    protected $_file = null;

    /**
     * Get Avatar Path
     *
     * @return string
     */
    public function getAvatarBasePath()
    {
        return Mage::getBaseDir('media') . DS . 'customer';
    }

    /**
     * Set Avatar File
     *
     * @param $fileData
     */
    public function setAvatarFileData($fileData)
    {
        $this->_file = $fileData;
    }

    public function getAvatarFileData()
    {
        return $this->_file;
    }

    /**
     * Save Avatar File
     *
     * @return null|string
     * @throws Exception
     */
    public function saveAvatarFile()
    {

        $uploadedFile = null;

        if ($fileData = $this->getAvatarFileData()) {

            $uploader = new Varien_File_Uploader($this->getAvatarFileData());

            $uploader->setFilesDispersion(true);
            $uploader->setFilenamesCaseSensitivity(false);
            $uploader->setAllowRenameFiles(true);
            $uploader->setAllowedExtensions($this->_supportedExtensions);

            $uploader->save($this->getAvatarBasePath(), $fileData['name']);
            $uploadedFile = $uploader->getUploadedFileName();
        }
        return $uploadedFile;
    }

}
