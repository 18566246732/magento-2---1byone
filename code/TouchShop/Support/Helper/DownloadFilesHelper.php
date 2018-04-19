<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/20/18
 * Time: 2:55 AM
 */

namespace TouchShop\Support\Helper;


use Magento\Catalog\Model\Product;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use TouchShop\ProductTool\Model\FileUploader;

class DownloadFilesHelper
{
    const LINE_BREAK_PATTERN = '/\r\n|\r|\n|;/';
    const SEPARATOR = '/:/';
    private $storeManager;
    private $uploader;

    public function __construct(
        StoreManagerInterface $storeManager,
        FileUploader $uploader
    )
    {
        $this->storeManager = $storeManager;
        $this->uploader = $uploader;
    }


    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $this->uploader->getBasePath() . '/';
        return $mediaUrl;
    }

    public function getDownloadFiles(Product $product)
    {
        $download_files = $product->getCustomAttribute('download_files');
        if ($download_files) {
            $files = $download_files->getValue();
            if ($files) {
                $result = [];
                foreach (preg_split(self::LINE_BREAK_PATTERN, $files) as $file) {
                    $data = preg_split(self::SEPARATOR, $file);
                    $result[] = [
                        'name' => $data[0],
                        'src' => $this->getMediaUrl() . $data[1]
                    ];
                }
                return $result;
            }
        }

        return [];
    }
}