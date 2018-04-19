<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/18/18
 * Time: 1:36 AM
 */

namespace TouchShop\ProductTool\EntityManager\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use TouchShop\ProductTool\Model\FileUploader;

class BeforeProductSave implements ObserverInterface
{
    private $uploader;

    /**
     * BeforeProductSave constructor.
     * @param FileUploader $uploader
     */
    public function __construct(
        FileUploader $uploader
    )
    {
        $this->uploader = $uploader;
    }


    /**
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(Observer $observer)
    {
        $product = $observer->getData('product');
        $sku = $product->getData('sku');
        $download_files = $product->getData('download_files');
        if (is_array($download_files)) {
            $values = [];
            foreach ($download_files as $file) {
                if (isset($file['baseTempPath'])) {
                    $baseTempPath = $file['baseTempPath'];
                    $basePath = $this->uploader->getFolderPath($file['basePath'], $sku);
                    $file_name = $file['name'];
                    $this->uploader->moveFileFromTemp($baseTempPath, $basePath, $file_name);
                    $values[] = $file_name . ':' . $sku . '/' . $file_name;
                } else {
                    $file_name = $file['name'];
                    $src_splits = explode('/', $file['src']);
                    $len = count($src_splits);
                    if ($len > 2) {
                        $file_path = $src_splits[$len - 2] . '/' . $src_splits[$len - 1];
                        $values[] = $file_name . ':' . $file_path;
                    }
                }
            }
            $product->setData('download_files', join(';', $values));
        } else {
            $product->setData('download_files', null);
        }
    }
}