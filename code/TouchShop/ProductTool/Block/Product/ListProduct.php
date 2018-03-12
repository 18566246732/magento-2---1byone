<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/8/18
 * Time: 11:58 PM
 */

namespace TouchShop\ProductTool\Block\Product;


class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    public function getAddToCartUrl($product, $additional = [])
    {
        $default_amazon_1byone = 'https://www.amazon.com/';
        $attribute = $product->getCustomAttribute('amazon_url');
        $amazon_url = $attribute ? $attribute->getValue() : null;
        return $amazon_url ? $amazon_url : $default_amazon_1byone;
    }
}