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
    const AMAZON_URL = 'amazon_url';

    const DEFAULT_URL = 'https://www.amazon.com';
    const BY_AT_AMAZON_LINK_LABEL = 'Buy at Amazon';

    public static function getAsin(Product $product)
    {

        return self::getCustomAttribute($product, self::AMAZON_ASIN);
    }

    public static function getAmazonUrl(Product $product)
    {
        return self::getCustomAttribute($product, self::AMAZON_URL, self::DEFAULT_URL);
    }

    private static function getCustomAttribute(Product $product, $attribute, $default = null)
    {
        $customAttribute = $product->getCustomAttribute($attribute);
        if ($customAttribute) {
            $value = $customAttribute->getValue();
            if ($value) {
                return $value;
            }
        }
        return $default;
    }
}