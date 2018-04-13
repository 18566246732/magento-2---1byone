<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/12/18
 * Time: 7:00 PM
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