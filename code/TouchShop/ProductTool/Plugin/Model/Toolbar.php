<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/8/18
 * Time: 12:59 AM
 */

namespace TouchShop\ProductTool\Plugin\Model;


class Toolbar
{
    public function beforeGetCurrentDirection(\Magento\Catalog\Block\Product\ProductList\Toolbar $toolbar)
    {
        $orderArray = [
            'discount' => 'desc',
            'price' => 'asc',
            'suggested' => 'desc'

        ];
        $order = $toolbar->getCurrentOrder();
        if (array_key_exists($order, $orderArray)) {
            $toolbar->setDefaultDirection($orderArray[$order]);
        }
    }
}