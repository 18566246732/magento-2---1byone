<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/22/18
 * Time: 6:04 PM
 */

namespace TouchShop\ProductTool\Helper;


use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class ProductHelper
{
    const AMAZON_ASIN = 'amazon_asin';
    const AMAZON_URL = 'amazon_url';
    const DISCOUNT = 'discount';
    const SUGGESTED = 'suggested';
    const MARK = 'mark';
    const SIMPLE = 'simple';
    const CONFIGURABLE = Configurable::TYPE_CODE;

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

    public static function getMark(Product $product)
    {
        return self::getCustomAttribute($product, self::MARK);
    }

    public static function getDiscount(Product $product)
    {
        $discount = self::getCustomAttribute($product, self::DISCOUNT, '00');
        return intval($discount);
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

    public static function isSimple(Product $product)
    {
        return $product->getTypeId() == self::SIMPLE;
    }

    public static function isConfigurable(Product $product)
    {
        return $product->getTypeId() == self::CONFIGURABLE;
    }


    /**
     * @param Product $product
     * @return array
     */
    public static function getChildren(Product $product)
    {
        return $product->getTypeInstance()->getUsedProducts($product);
    }
}