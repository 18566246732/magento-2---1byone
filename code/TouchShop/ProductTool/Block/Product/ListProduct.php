<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/8/18
 * Time: 11:58 PM
 */

namespace TouchShop\ProductTool\Block\Product;


use Magento\Catalog\Model\Product;
use TouchShop\ProductTool\Helper\ProductHelper;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    public function getAddToCartUrl($product, $additional = [])
    {
        return ProductHelper::getAmazonUrl($product);
    }

    public function getMark(Product $product)
    {
        return ProductHelper::getMark($product);
    }

    public function getImgBaseUrl(Product $product)
    {
        return $this->getBaseUrl() . 'pub/media/wysiwyg/products' . $product;
    }

}