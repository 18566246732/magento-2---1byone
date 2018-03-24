<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/2/18
 * Time: 6:38 PM
 */

namespace TouchShop\ProductTool\Block\Product;


use TouchShop\ProductTool\Helper\ProductHelper;

class ProductsList extends \Magento\CatalogWidget\Block\Product\ProductsList
{
    public function getAddToCartUrl($product, $additional = [])
    {
        return ProductHelper::getAmazonUrl($product);
    }

    public function getMark(Product $product)
    {
        return ProductHelper::getMark($product);
    }

    public function isHot($product)
    {
        return ProductHelper::isHot($product);
    }

    public function getImgBaseUrl($product)
    {
        return $this->getBaseUrl() . 'pub/media/wysiwyg/products/' . $product;
    }


}