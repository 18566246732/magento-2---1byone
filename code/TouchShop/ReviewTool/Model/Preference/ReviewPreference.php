<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/31/18
 * Time: 11:38 PM
 */

namespace TouchShop\ReviewTool\Model\Preference;


use Magento\Review\Block\Product\Review;

class ReviewPreference extends Review
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