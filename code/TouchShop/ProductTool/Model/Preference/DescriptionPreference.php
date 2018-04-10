<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/10/18
 * Time: 1:13 AM
 */

namespace TouchShop\ProductTool\Model\Preference;


use Magento\Catalog\Block\Product\View\Description;

class DescriptionPreference extends Description
{
    public function getCurrentProductId()
    {
        $product = $this->_coreRegistry->registry('current_product');
        if (!$product) {
            $product = $this->_coreRegistry->registry('product');
        }
        if ($product) {
            return $product->getId();
        }
        return null;
    }
}