<?php
/**
 * GhoSter FileAttribute Model Attribute Backend File
 *
 * @category    GhoSter
 * @package     GhoSter_FileAttribute
 * @author      opensource
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class GhoSter_FileAttribute_Model_Attribute_Backend_File
    extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    /**
     * After attribute is saved upload file to media
     * folder and save it to its associated product.
     *
     * @param  Mage_Catalog_Model_Product $object
     * @return GhoSter_FileAttribute_Model_Attribute_Backend_File
     */
    public function afterSave($object)
    {
        $value = $object->getData($this->getAttribute()->getName());

        if (is_array($value) && !empty($value['delete'])) {
            $object->setData($this->getAttribute()->getName(), '');
            $this->getAttribute()->getEntity()
                ->saveAttribute($object, $this->getAttribute()->getName());
            return;
        }

        try {
            $uploadedFile = new Varien_Object();
            $uploadedFile->setData('name', $this->getAttribute()->getName());
            $uploadedFile->setData(
                'allowed_extensions',
                array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png',
                    'tif',
                    'tiff',
                    'mpg',
                    'mpeg',
                    'mp3',
                    'wav',
                    'pdf',
                    'txt',
                    'mp4',
                )
            );

            Mage::dispatchEvent(
                'ghoster_fileattribute_allowed_extensions',
                array('file' => $uploadedFile)
            );

            $uploader = new Mage_Core_Model_File_Uploader($this->getAttribute()->getName());
            $uploader->setAllowedExtensions($uploadedFile->getData('allowed_extensions'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);

            $uploader->save(Mage::getBaseDir('media') . '/catalog/product');
        } catch (Exception $e) {
            return $this;
        }

        $fileName = $uploader->getUploadedFileName();

        if ($fileName) {
            $object->setData($this->getAttribute()->getName(), $fileName);
            $this->getAttribute()->getEntity()
                ->saveAttribute($object, $this->getAttribute()->getName());
        }

        return $this;
    }
}
