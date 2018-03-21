<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/20/18
 * Time: 2:55 AM
 */

namespace TouchShop\Support\Helper;


use Magento\Catalog\Model\Product;

class DownloadFilesHelper
{
    const LINE_BREAK_PATTERN = '/\r\n|\r|\n/';
    const SEPARATOR = '/:/';
    const DOWNLOAD_FILES_LOCATION = 'pub/media/download_files/';

    public static function getDownloadFiles(Product $product)
    {
        $download_files = $product->getCustomAttribute('download_files');
        if ($download_files) {
            $files = $download_files->getValue();
            if ($files) {
                $result = [];
                foreach (preg_split(self::LINE_BREAK_PATTERN, $files) as $file) {
                    $data = preg_split(self::SEPARATOR, $file);
                    $result[] = [
                        'label' => $data[0],
                        'src' => self::DOWNLOAD_FILES_LOCATION . $data[1]
                    ];
                }
                return $result;
            }
        }

        return [];
    }
}