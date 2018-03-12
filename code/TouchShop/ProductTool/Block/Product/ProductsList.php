<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/2/18
 * Time: 6:38 PM
 */

namespace TouchShop\ProductTool\Block\Product;


class ProductsList extends \Magento\CatalogWidget\Block\Product\ProductsList
{
    public function getAddToCartUrl($product, $additional = [])
    {
        $default_amazon_1byone = 'https://www.amazon.com/';
        $attribute = $product->getCustomAttribute('amazon_url');
        $amazon_url = $attribute ? $attribute->getValue() : null;
        return $amazon_url ? $amazon_url : $default_amazon_1byone;
    }

}