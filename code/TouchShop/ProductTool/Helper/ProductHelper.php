<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/22/18
 * Time: 6:04 PM
 */

namespace TouchShop\ProductTool\Helper;


use Magento\Catalog\Model\Product;

class ProductHelper
{
    const AMAZON_ASIN = 'amazon_asin';

    public static function getAsin(Product $product)
    {
        $customAttribute = $product->getCustomAttribute(self::AMAZON_ASIN);
        if ($customAttribute) {
            $asin = $customAttribute->getValue();
            if ($asin) {
                return $asin;
            }
        }
        return null;
    }
}